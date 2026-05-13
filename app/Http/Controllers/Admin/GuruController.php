<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Borrowing;
use Illuminate\Http\Request;

class GuruController extends Controller
{
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

        // Exclude items that are fully borrowed out
        $items = $query->get()->filter(function ($item) {
            $borrowed = Borrowing::where('item_id', $item->id)
                ->whereIn('status', ['dipinjam', 'terlambat'])
                ->count();
            return $item->quantity > $borrowed;
        })->values();

        $categories = \App\Models\Category::orderBy('name')->get();

        return view('admin.guru.inventaris.ready', compact('items', 'categories'));
    }
}