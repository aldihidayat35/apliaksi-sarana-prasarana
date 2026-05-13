<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Item;
use App\Models\Borrowing;
use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\ConditionReport;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang = Item::count();
        $barangDipinjam = Borrowing::where('status', 'dipinjam')->count();
        $barangRusak = Item::whereIn('condition', ['rusak_ringan', 'rusak_berat'])->count();
        $barangHilang = Item::where('condition', 'hilang')->count();
        $barangBaik = Item::where('condition', 'baik')->count();
        $totalUsers = User::count();

        // Data for charts
        $categoryData = Category::withCount('items')->orderBy('items_count', 'desc')->take(6)->get();
        $monthlyBorrowings = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthlyBorrowings[$m] = Borrowing::whereYear('borrow_date', date('Y'))
                ->whereMonth('borrow_date', $m)->count();
        }

        $recentActivities = ActivityLog::with('user')->latest()->take(10)->get();
        $recentBorrowings = Borrowing::with(['item', 'user'])->latest()->take(5)->get();

        // ── Kerusakan per Lokasi ─────────────────────────────────────────────
        $damageByLocation = Item::whereIn('condition', ['rusak_ringan', 'rusak_berat'])
            ->with('location:id,name')
            ->select('location_id', DB::raw('COUNT(*) as total'))
            ->groupBy('location_id')
            ->orderByDesc('total')
            ->get();

        $locationChartLabels = $damageByLocation->map(fn($i) => $i->location->name ?? 'Tanpa Lokasi')->values();
        $locationChartCounts = $damageByLocation->map(fn($i) => $i->total)->values();

        // ── Prioritas Pengadaan (Top 5) ────────────────────────────────────
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

        return view('admin.dashboard', compact(
            'totalBarang', 'barangDipinjam', 'barangRusak', 'barangHilang', 'barangBaik',
            'totalUsers', 'categoryData', 'monthlyBorrowings',
            'recentActivities', 'recentBorrowings',
            'damageByLocation', 'locationChartLabels', 'locationChartCounts',
            'priorityItems'
        ));
    }
}
