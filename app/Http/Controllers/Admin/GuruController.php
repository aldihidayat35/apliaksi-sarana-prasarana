<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Borrowing;
use App\Models\ConditionReport;
use App\Models\Category;
use App\Models\Location;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuruController extends Controller
{
    /**
     * Dashboard khusus Guru
     */
    public function dashboard()
    {
        $user = auth()->user();

        // Stats untuk guru
        $totalBarang = Item::where('condition', '!=', 'hilang')->count();
        $barangDipinjam = Borrowing::where('user_id', $user->id)->whereIn('status', ['dipinjam', 'terlambat'])->count();
        $barangReady = Item::where('condition', 'baik')->where('quantity', '>', 0)->count();

        // Kerusakan per lokasi (chart)
        $damageByLocation = Item::whereIn('condition', ['rusak_ringan', 'rusak_berat'])
            ->with('location:id,name')
            ->select('location_id', DB::raw('COUNT(*) as total'))
            ->groupBy('location_id')
            ->orderByDesc('total')
            ->get();

        $locationChartLabels = $damageByLocation->map(fn($i) => $i->location->name ?? 'Tanpa Lokasi')->values();
        $locationChartCounts = $damageByLocation->map(fn($i) => $i->total)->values();

        // Kondisi barang summary
        $summary = [
            'total' => Item::count(),
            'baik' => Item::where('condition', 'baik')->count(),
            'rusak_ringan' => Item::where('condition', 'rusak_ringan')->count(),
            'rusak_berat' => Item::where('condition', 'rusak_berat')->count(),
            'hilang' => Item::where('condition', 'hilang')->count(),
        ];

        // Prioritas pengadaan (reused from ReportController)
        $months = 12;
        $startDate = Carbon::now()->subMonths($months)->startOfDay();

        $priorityItems = Item::with(['category', 'location'])
            ->withCount([
                'conditionReports as damage_total' => fn($q) => $q->whereIn('condition_after', ['rusak_ringan', 'rusak_berat', 'hilang']),
                'conditionReports as damage_recent' => fn($q) => $q->whereDate('report_date', '>=', $startDate),
                'borrowings as usage_recent' => fn($q) => $q->whereDate('borrow_date', '>=', $startDate),
            ])
            ->where('condition', '!=', 'hilang')
            ->get();

        $maxDamage = $priorityItems->max('damage_total') ?: 1;
        $maxFrequency = $priorityItems->max('damage_recent') ?: 1;
        $maxUsage = $priorityItems->max('usage_recent') ?: 1;

        $priorityItems = $priorityItems->map(function ($item) use ($maxDamage, $maxFrequency, $maxUsage) {
            $damageScore = $item->damage_total / $maxDamage;
            $frequencyScore = $item->damage_recent / $maxFrequency;
            $usageScore = $item->usage_recent / $maxUsage;
            $item->priority_score = round((($damageScore * 0.6) + ($frequencyScore * 0.25) + ($usageScore * 0.15)) * 100, 1);
            return $item;
        })->sortByDesc('priority_score')->take(5);

        // Peminjaman saya (guru)
        $myBorrowings = Borrowing::with(['item', 'item.location'])
            ->where('user_id', $user->id)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->orderBy('expected_return_date')
            ->take(5)
            ->get();

        return view('admin.guru.dashboard', compact(
            'totalBarang', 'barangDipinjam', 'barangReady',
            'damageByLocation', 'locationChartLabels', 'locationChartCounts',
            'summary', 'priorityItems', 'myBorrowings'
        ));
    }

    /**
     * Daftar semua barang (read-only, untuk guru)
     */
    public function inventaris(Request $request)
    {
        $query = Item::with(['category', 'location'])
            ->where('condition', '!=', 'hilang');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('code', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $items = $query->orderBy('name')->paginate(12)->withQueryString();
        $categories = \App\Models\Category::orderBy('name')->get();

        return view('admin.guru.inventaris.index', compact('items', 'categories'));
    }

    /**
     * Barang yang sedang dipinjam oleh guru ini
     */
    public function sedangDipinjam(Request $request)
    {
        $borrowings = Borrowing::with(['item', 'item.location', 'item.category'])
            ->where('user_id', auth()->id())
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->orderBy('expected_return_date')
            ->paginate(10);

        return view('admin.guru.inventaris.dipinjam', compact('borrowings'));
    }

    /**
     * Barang yang ready untuk dipinjam (baik, tidak sedang dipinjam semua)
     */
    public function ready(Request $request)
    {
        $query = Item::with(['category', 'location'])
            ->where('condition', 'baik')
            ->where('quantity', '>', 0);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('code', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $items = $query->get()->filter(function ($item) {
            $borrowed = Borrowing::where('item_id', $item->id)
                ->whereIn('status', ['dipinjam', 'terlambat'])
                ->count();
            return $item->quantity > $borrowed;
        })->values();

        $categories = \App\Models\Category::orderBy('name')->get();

        return view('admin.guru.inventaris.ready', compact('items', 'categories'));
    }

    /**
     * Kerusakan per Lokasi (ringkasan untuk guru)
     */
    public function kerusakanLokasi(Request $request)
    {
        $query = ConditionReport::with(['item.location', 'item.category'])
            ->whereIn('condition_after', ['rusak_ringan', 'rusak_berat', 'hilang']);

        if ($request->filled('location_id')) {
            $query->whereHas('item', fn($q) => $q->where('location_id', $request->location_id));
        }

        $reports = $query->orderBy('report_date', 'desc')->get();

        $groupedByLocation = $reports->groupBy(fn($r) => $r->item->location->name ?? 'Tanpa Lokasi');
        $locationChartLabels = $groupedByLocation->keys()->values();
        $locationChartCounts = $groupedByLocation->map->count()->values();

        $locations = Location::orderBy('name')->get();

        $summary = [
            'total' => $reports->count(),
            'rusak_ringan' => $reports->where('condition_after', 'rusak_ringan')->count(),
            'rusak_berat' => $reports->where('condition_after', 'rusak_berat')->count(),
            'hilang' => $reports->where('condition_after', 'hilang')->count(),
            'lokasi' => $groupedByLocation->count(),
        ];

        return view('admin.guru.reports.kerusakan-lokasi', compact(
            'reports', 'locationChartLabels', 'locationChartCounts', 'locations', 'summary'
        ));
    }

    /**
     * Laporan Kondisi Barang (ringkasan untuk guru)
     */
    public function laporanKondisi(Request $request)
    {
        $query = Item::with(['category', 'location']);

        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }
        if ($request->filled('location_id')) {
            $query->where('location_id', $request->location_id);
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $items = $query->orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $locations = Location::orderBy('name')->get();

        $summary = [
            'total' => Item::count(),
            'baik' => Item::where('condition', 'baik')->count(),
            'rusak_ringan' => Item::where('condition', 'rusak_ringan')->count(),
            'rusak_berat' => Item::where('condition', 'rusak_berat')->count(),
            'hilang' => Item::where('condition', 'hilang')->count(),
        ];

        return view('admin.guru.reports.kondisi', compact('items', 'categories', 'locations', 'summary'));
    }

    /**
     * Prioritas Pengadaan (ringkasan untuk guru)
     */
    public function prioritasPengadaan(Request $request)
    {
        $months = (int) $request->input('months', 12);
        $months = $months > 0 ? $months : 12;
        $startDate = Carbon::now()->subMonths($months)->startOfDay();

        $items = Item::with(['category', 'location'])
            ->withCount([
                'conditionReports as damage_total' => fn($q) => $q->whereIn('condition_after', ['rusak_ringan', 'rusak_berat', 'hilang']),
                'conditionReports as damage_recent' => fn($q) => $q->whereDate('report_date', '>=', $startDate),
                'borrowings as usage_recent' => fn($q) => $q->whereDate('borrow_date', '>=', $startDate),
            ])
            ->where('condition', '!=', 'hilang')
            ->get();

        $maxDamage = $items->max('damage_total') ?: 1;
        $maxFrequency = $items->max('damage_recent') ?: 1;
        $maxUsage = $items->max('usage_recent') ?: 1;

        $rankedItems = $items->map(function ($item) use ($maxDamage, $maxFrequency, $maxUsage) {
            $damageScore = $item->damage_total / $maxDamage;
            $frequencyScore = $item->damage_recent / $maxFrequency;
            $usageScore = $item->usage_recent / $maxUsage;
            $item->priority_score = round((($damageScore * 0.6) + ($frequencyScore * 0.25) + ($usageScore * 0.15)) * 100, 1);
            return $item;
        })->sortByDesc('priority_score')->values();

        $topItems = $rankedItems->take(10);
        $chartLabels = $topItems->map(fn($item) => $item->name)->values();
        $chartScores = $topItems->map(fn($item) => $item->priority_score)->values();

        $weights = ['damage' => 0.6, 'frequency' => 0.25, 'usage' => 0.15];

        return view('admin.guru.reports.prioritas', compact(
            'months', 'rankedItems', 'chartLabels', 'chartScores', 'weights'
        ));
    }

    /**
     * Unduh Excel - Kerusakan Lokasi
     */
    public function kerusakanLokasiExcel(Request $request)
    {
        $reports = ConditionReport::with(['item.location', 'item.category'])
            ->whereIn('condition_after', ['rusak_ringan', 'rusak_berat', 'hilang'])
            ->orderBy('report_date', 'desc')->get();

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\DamageLocationExport($reports),
            'laporan-kerusakan-lokasi-' . date('Ymd') . '.xlsx'
        );
    }

    /**
     * Unduh Excel - Kondisi Barang
     */
    public function kondisiExcel(Request $request)
    {
        $query = Item::with(['category', 'location']);
        if ($request->filled('condition')) $query->where('condition', $request->condition);
        if ($request->filled('location_id')) $query->where('location_id', $request->location_id);
        if ($request->filled('category_id')) $query->where('category_id', $request->category_id);
        $items = $query->orderBy('name')->get();

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\ConditionExport($items),
            'laporan-kondisi-' . date('Ymd') . '.xlsx'
        );
    }

    /**
     * Unduh Excel - Prioritas Pengadaan
     */
    public function prioritasExcel(Request $request)
    {
        $months = (int) $request->input('months', 12);
        $startDate = Carbon::now()->subMonths($months)->startOfDay();

        $items = Item::with(['category', 'location'])
            ->withCount([
                'conditionReports as damage_total' => fn($q) => $q->whereIn('condition_after', ['rusak_ringan', 'rusak_berat', 'hilang']),
                'conditionReports as damage_recent' => fn($q) => $q->whereDate('report_date', '>=', $startDate),
                'borrowings as usage_recent' => fn($q) => $q->whereDate('borrow_date', '>=', $startDate),
            ])
            ->where('condition', '!=', 'hilang')
            ->get();

        $maxDamage = $items->max('damage_total') ?: 1;
        $maxFrequency = $items->max('damage_recent') ?: 1;
        $maxUsage = $items->max('usage_recent') ?: 1;

        $items = $items->map(function ($item) use ($maxDamage, $maxFrequency, $maxUsage) {
            $damageScore = $item->damage_total / $maxDamage;
            $frequencyScore = $item->damage_recent / $maxFrequency;
            $usageScore = $item->usage_recent / $maxUsage;
            $item->priority_score = round((($damageScore * 0.6) + ($frequencyScore * 0.25) + ($usageScore * 0.15)) * 100, 1);
            return $item;
        })->sortByDesc('priority_score')->values();

        // Custom export for priority
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\PriorityExport($items),
            'laporan-prioritas-pengadaan-' . date('Ymd') . '.xlsx'
        );
    }

    /**
     * Unduh PDF - Kondisi Barang
     */
    public function kondisiPdf(Request $request)
    {
        $query = \App\Models\Item::with(['category', 'location']);
        if ($request->filled('condition')) $query->where('condition', $request->condition);
        if ($request->filled('location_id')) $query->where('location_id', $request->location_id);
        if ($request->filled('category_id')) $query->where('category_id', $request->category_id);
        $items = $query->orderBy('name')->get();
        $summary = [
            'total' => \App\Models\Item::count(),
            'baik' => \App\Models\Item::where('condition', 'baik')->count(),
            'rusak_ringan' => \App\Models\Item::where('condition', 'rusak_ringan')->count(),
            'rusak_berat' => \App\Models\Item::where('condition', 'rusak_berat')->count(),
            'hilang' => \App\Models\Item::where('condition', 'hilang')->count(),
        ];
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.guru.reports.pdf.kondisi', compact('items', 'summary'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('laporan-kondisi-' . date('Ymd') . '.pdf');
    }

    /**
     * Generate bukti pengembalian PDF untuk guru
     */
    public function buktiPengembalianPdf($borrowingId)
    {
        $borrowing = \App\Models\Borrowing::with(['item', 'item.location', 'item.category', 'user'])
            ->where('user_id', auth()->id())
            ->findOrFail($borrowingId);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.guru.reports.pdf.bukti-pengembalian', compact('borrowing'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->download('bukti-pengembalian-' . $borrowing->id . '-' . date('Ymd') . '.pdf');
    }

}