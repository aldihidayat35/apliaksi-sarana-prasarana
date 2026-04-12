<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Borrowing;
use App\Models\ConditionReport;
use App\Models\Category;
use App\Models\Location;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function inventory(Request $request)
    {
        $query = Item::with(['category', 'location']);

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }
        if ($request->filled('location_id')) {
            $query->where('location_id', $request->location_id);
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
            'total_value' => Item::sum('price'),
        ];

        // Chart data: items per category
        $categoryChart = Category::withCount('items')->orderBy('name')->get();
        // Chart data: items per location
        $locationChart = Location::withCount('items')->orderBy('name')->get();

        return view('admin.reports.inventory', compact('items', 'categories', 'locations', 'summary', 'categoryChart', 'locationChart'));
    }

    public function borrowing(Request $request)
    {
        $query = Borrowing::with(['item', 'user']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('date_from')) {
            $query->where('borrow_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('borrow_date', '<=', $request->date_to);
        }

        $borrowings = $query->orderBy('borrow_date', 'desc')->get();

        $summary = [
            'total' => Borrowing::count(),
            'dipinjam' => Borrowing::where('status', 'dipinjam')->count(),
            'dikembalikan' => Borrowing::where('status', 'dikembalikan')->count(),
            'terlambat' => Borrowing::where('status', 'terlambat')->count(),
        ];

        // Monthly borrowing chart for current year
        $monthlyBorrow = [];
        $monthlyReturn = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthlyBorrow[$m] = Borrowing::whereYear('borrow_date', date('Y'))->whereMonth('borrow_date', $m)->count();
            $monthlyReturn[$m] = Borrowing::whereYear('borrow_date', date('Y'))->whereMonth('borrow_date', $m)->where('status', 'dikembalikan')->count();
        }

        return view('admin.reports.borrowing', compact('borrowings', 'summary', 'monthlyBorrow', 'monthlyReturn'));
    }

    public function damage(Request $request)
    {
        $query = ConditionReport::with(['item', 'reportedByUser']);

        if ($request->filled('date_from')) {
            $query->where('report_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('report_date', '<=', $request->date_to);
        }

        $reports = $query->orderBy('report_date', 'desc')->get();

        // Damage summary data for chart
        $damageSummary = [
            'rusak_ringan' => ConditionReport::where('condition_after', 'rusak_ringan')->count(),
            'rusak_berat' => ConditionReport::where('condition_after', 'rusak_berat')->count(),
            'hilang' => ConditionReport::where('condition_after', 'hilang')->count(),
        ];

        // Monthly damage data for line chart (current year)
        $monthlyDamage = ['rusak_ringan' => [], 'rusak_berat' => [], 'hilang' => []];
        for ($m = 1; $m <= 12; $m++) {
            $monthlyDamage['rusak_ringan'][$m] = ConditionReport::where('condition_after', 'rusak_ringan')
                ->whereYear('report_date', date('Y'))->whereMonth('report_date', $m)->count();
            $monthlyDamage['rusak_berat'][$m] = ConditionReport::where('condition_after', 'rusak_berat')
                ->whereYear('report_date', date('Y'))->whereMonth('report_date', $m)->count();
            $monthlyDamage['hilang'][$m] = ConditionReport::where('condition_after', 'hilang')
                ->whereYear('report_date', date('Y'))->whereMonth('report_date', $m)->count();
        }

        return view('admin.reports.damage', compact('reports', 'damageSummary', 'monthlyDamage'));
    }

    public function annual(Request $request)
    {
        $year = $request->input('year', date('Y'));

        $monthlyItems = [];
        $monthlyBorrowings = [];
        $monthlyDamages = [];

        for ($m = 1; $m <= 12; $m++) {
            $monthlyItems[$m] = Item::whereYear('created_at', $year)->whereMonth('created_at', $m)->count();
            $monthlyBorrowings[$m] = Borrowing::whereYear('borrow_date', $year)->whereMonth('borrow_date', $m)->count();
            $monthlyDamages[$m] = ConditionReport::whereYear('report_date', $year)->whereMonth('report_date', $m)->count();
        }

        $summary = [
            'total_items' => Item::count(),
            'total_borrowings' => Borrowing::whereYear('borrow_date', $year)->count(),
            'total_damages' => ConditionReport::whereYear('report_date', $year)->count(),
            'total_value' => Item::sum('price'),
        ];

        return view('admin.reports.annual', compact('year', 'monthlyItems', 'monthlyBorrowings', 'monthlyDamages', 'summary'));
    }

    // ─── PDF Downloads ────────────────────────────────────────────────────────

    public function inventoryPdf(Request $request)
    {
        $query = Item::with(['category', 'location']);
        if ($request->filled('category_id')) $query->where('category_id', $request->category_id);
        if ($request->filled('condition'))   $query->where('condition', $request->condition);
        if ($request->filled('location_id')) $query->where('location_id', $request->location_id);
        $items = $query->orderBy('name')->get();

        $summary = [
            'total'      => Item::count(),
            'baik'       => Item::where('condition', 'baik')->count(),
            'rusak_ringan' => Item::where('condition', 'rusak_ringan')->count(),
            'rusak_berat'  => Item::where('condition', 'rusak_berat')->count(),
            'hilang'     => Item::where('condition', 'hilang')->count(),
            'total_value'  => Item::sum('price'),
        ];

        $pdf = Pdf::loadView('admin.reports.pdf.inventory', compact('items', 'summary'))
            ->setPaper('a4', 'landscape');
        return $pdf->download('laporan-inventaris-' . date('Ymd') . '.pdf');
    }

    public function borrowingPdf(Request $request)
    {
        $query = Borrowing::with(['item', 'user']);
        if ($request->filled('status'))    $query->where('status', $request->status);
        if ($request->filled('date_from')) $query->where('borrow_date', '>=', $request->date_from);
        if ($request->filled('date_to'))   $query->where('borrow_date', '<=', $request->date_to);
        $borrowings = $query->orderBy('borrow_date', 'desc')->get();

        $summary = [
            'total'        => Borrowing::count(),
            'dipinjam'     => Borrowing::where('status', 'dipinjam')->count(),
            'dikembalikan' => Borrowing::where('status', 'dikembalikan')->count(),
            'terlambat'    => Borrowing::where('status', 'terlambat')->count(),
        ];

        $pdf = Pdf::loadView('admin.reports.pdf.borrowing', compact('borrowings', 'summary'))
            ->setPaper('a4', 'landscape');
        return $pdf->download('laporan-peminjaman-' . date('Ymd') . '.pdf');
    }

    public function damagePdf(Request $request)
    {
        $query = ConditionReport::with(['item', 'reportedByUser']);
        if ($request->filled('date_from')) $query->where('report_date', '>=', $request->date_from);
        if ($request->filled('date_to'))   $query->where('report_date', '<=', $request->date_to);
        $reports = $query->orderBy('report_date', 'desc')->get();

        $damageSummary = [
            'rusak_ringan' => ConditionReport::where('condition_after', 'rusak_ringan')->count(),
            'rusak_berat'  => ConditionReport::where('condition_after', 'rusak_berat')->count(),
            'hilang'       => ConditionReport::where('condition_after', 'hilang')->count(),
        ];

        $pdf = Pdf::loadView('admin.reports.pdf.damage', compact('reports', 'damageSummary'))
            ->setPaper('a4', 'landscape');
        return $pdf->download('laporan-kerusakan-' . date('Ymd') . '.pdf');
    }

    public function annualPdf(Request $request)
    {
        $year = $request->input('year', date('Y'));

        $monthlyData = [];
        $months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        for ($m = 1; $m <= 12; $m++) {
            $monthlyData[$m] = [
                'month'      => $months[$m - 1],
                'items'      => Item::whereYear('created_at', $year)->whereMonth('created_at', $m)->count(),
                'borrowings' => Borrowing::whereYear('borrow_date', $year)->whereMonth('borrow_date', $m)->count(),
                'damages'    => ConditionReport::whereYear('report_date', $year)->whereMonth('report_date', $m)->count(),
            ];
        }

        $summary = [
            'total_items'      => Item::count(),
            'total_borrowings' => Borrowing::whereYear('borrow_date', $year)->count(),
            'total_damages'    => ConditionReport::whereYear('report_date', $year)->count(),
            'total_value'      => Item::sum('price'),
        ];

        $pdf = Pdf::loadView('admin.reports.pdf.annual', compact('year', 'summary', 'monthlyData'))
            ->setPaper('a4', 'portrait');
        return $pdf->download('laporan-tahunan-' . $year . '.pdf');
    }
}
