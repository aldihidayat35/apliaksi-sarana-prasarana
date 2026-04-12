<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Item;
use App\Models\Borrowing;
use App\Models\ActivityLog;
use App\Models\Category;

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

        return view('admin.dashboard', compact(
            'totalBarang', 'barangDipinjam', 'barangRusak', 'barangHilang', 'barangBaik',
            'totalUsers', 'categoryData', 'monthlyBorrowings',
            'recentActivities', 'recentBorrowings'
        ));
    }
}
