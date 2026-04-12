<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Item;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{
    public function index(Request $request)
    {
        $query = Borrowing::with(['item', 'user', 'approvedByUser']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('item', fn($q2) => $q2->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('user', fn($q2) => $q2->where('name', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $borrowings = $query->latest()->get();

        return view('admin.borrowings.index', compact('borrowings'));
    }

    public function create()
    {
        $items = Item::where('condition', '!=', 'hilang')
            ->whereDoesntHave('activeBorrowing')
            ->orderBy('name')
            ->get();
        $users = User::where('is_active', true)->orderBy('name')->get();
        return view('admin.borrowings.create', compact('items', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id' => ['required', 'exists:items,id'],
            'user_id' => ['required', 'exists:users,id'],
            'borrow_date' => ['required', 'date'],
            'expected_return_date' => ['required', 'date', 'after_or_equal:borrow_date'],
            'purpose' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ]);

        $item = Item::findOrFail($validated['item_id']);

        if (!$item->isAvailable()) {
            return back()->with('error', 'Barang sedang dipinjam atau tidak tersedia.')->withInput();
        }

        $validated['status'] = 'dipinjam';
        $validated['approved_by'] = Auth::id();

        $borrowing = Borrowing::create($validated);

        ActivityLog::log('borrowing_created', "Peminjaman: {$item->name} oleh " . User::find($validated['user_id'])->name, $borrowing);

        return redirect()->route('admin.borrowings.index')->with('success', 'Peminjaman berhasil dicatat.');
    }

    public function show(Borrowing $borrowing)
    {
        $borrowing->load(['item.category', 'item.location', 'user', 'approvedByUser']);
        return view('admin.borrowings.show', compact('borrowing'));
    }

    public function returnItem(Borrowing $borrowing, Request $request)
    {
        $request->validate([
            'actual_return_date' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
        ]);

        $status = $request->date('actual_return_date') > $borrowing->expected_return_date ? 'terlambat' : 'dikembalikan';

        $borrowing->update([
            'actual_return_date' => $request->actual_return_date,
            'status' => $status,
            'notes' => $request->notes,
        ]);

        ActivityLog::log('borrowing_returned', "Pengembalian: {$borrowing->item->name} oleh {$borrowing->user->name}", $borrowing);

        return redirect()->route('admin.borrowings.index')->with('success', 'Barang berhasil dikembalikan.');
    }

    public function destroy(Borrowing $borrowing)
    {
        ActivityLog::log('borrowing_deleted', "Menghapus peminjaman: {$borrowing->item->name}");
        $borrowing->delete();

        return redirect()->route('admin.borrowings.index')->with('success', 'Data peminjaman berhasil dihapus.');
    }
}
