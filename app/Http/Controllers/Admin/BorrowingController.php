<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Item;
use App\Models\User;
use App\Models\ActivityLog;
use App\Models\ConditionReport;
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
        if (Auth::user()->isGuru() && $borrowing->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $request->validate([
            'actual_return_date' => ['required', 'date'],
            'return_condition' => ['required', 'in:baik,rusak_ringan,rusak_berat,hilang'],
            'return_notes' => ['nullable', 'string'],
        ]);

        $status = $request->date('actual_return_date') > $borrowing->expected_return_date ? 'terlambat' : 'dikembalikan';

        $borrowing->update([
            'actual_return_date' => $request->actual_return_date,
            'return_condition' => $request->return_condition,
            'return_notes' => $request->return_notes,
            'status' => $status,
        ]);

        $item = $borrowing->item;
        $conditionBefore = $item->condition;
        if ($request->return_condition && $request->return_condition !== $conditionBefore) {
            $item->update(['condition' => $request->return_condition]);

            ConditionReport::create([
                'item_id' => $item->id,
                'reported_by' => Auth::id(),
                'condition_before' => $conditionBefore,
                'condition_after' => $request->return_condition,
                'description' => $request->return_notes ?: 'Update kondisi saat pengembalian barang.',
                'report_date' => $request->actual_return_date,
            ]);
        }

        ActivityLog::log('borrowing_returned', "Pengembalian: {$borrowing->item->name} oleh {$borrowing->user->name}", $borrowing);

        return back()->with('success', 'Barang berhasil dikembalikan.');
    }

    public function returns(Request $request)
    {
        $query = Borrowing::with(['item', 'user'])
            ->whereIn('status', ['dipinjam', 'terlambat']);

        if (Auth::user()->isGuru()) {
            $query->where('user_id', Auth::id());
        }

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

        $borrowings = $query->orderBy('expected_return_date', 'asc')->get();

        return view('admin.borrowings.returns', compact('borrowings'));
    }

    public function destroy(Borrowing $borrowing)
    {
        ActivityLog::log('borrowing_deleted', "Menghapus peminjaman: {$borrowing->item->name}");
        $borrowing->delete();

        return redirect()->route('admin.borrowings.index')->with('success', 'Data peminjaman berhasil dihapus.');
    }
}

    public function returnSlip(Borrowing $borrowing)
    {
        return view('admin.borrowings.return-slip', compact('borrowing'));
    }
