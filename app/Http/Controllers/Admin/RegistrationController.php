<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\ItemRegistration;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $query = ItemRegistration::with(['item.category', 'item.location', 'registeredByUser']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('unique_id', 'like', "%{$search}%")
                  ->orWhereHas('item', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%")
                         ->orWhere('code', 'like', "%{$search}%");
                  });
            });
        }

        $registrations = $query->latest()->get();

        return view('admin.registrations.index', compact('registrations'));
    }

    public function create()
    {
        $items = Item::doesntHave('registration')->orderBy('name')->get();
        return view('admin.registrations.create', compact('items'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id' => ['required', 'exists:items,id', 'unique:item_registrations,item_id'],
            'notes' => ['nullable', 'string'],
        ]);

        $item = Item::findOrFail($validated['item_id']);
        $uniqueId = 'BRL-' . strtoupper(Str::random(3)) . '-' . str_pad($item->id, 5, '0', STR_PAD_LEFT);

        $registration = ItemRegistration::create([
            'item_id' => $validated['item_id'],
            'unique_id' => $uniqueId,
            'registered_by' => Auth::id(),
            'notes' => $validated['notes'] ?? null,
        ]);

        ActivityLog::log('registration_created', "Registrasi barang: {$item->name} ({$uniqueId})", $registration);

        return redirect()->route('admin.registrations.show', $registration)->with('success', 'Barang berhasil diregistrasi.');
    }

    public function show(ItemRegistration $registration)
    {
        $registration->load(['item.category', 'item.location', 'registeredByUser']);
        return view('admin.registrations.show', compact('registration'));
    }

    public function generateQr(ItemRegistration $registration)
    {
        $registration->load('item');
        return view('admin.registrations.qr', compact('registration'));
    }

    public function scan()
    {
        return view('admin.registrations.scan');
    }

    public function scanResult(Request $request)
    {
        $request->validate(['unique_id' => 'required|string']);

        $registration = ItemRegistration::with(['item.category', 'item.location', 'item.activeBorrowing.user'])
            ->where('unique_id', $request->unique_id)
            ->first();

        if (!$registration) {
            return response()->json(['found' => false, 'message' => 'Barang tidak ditemukan.']);
        }

        return response()->json([
            'found' => true,
            'data' => [
                'unique_id' => $registration->unique_id,
                'item_name' => $registration->item->name,
                'item_code' => $registration->item->code,
                'category' => $registration->item->category->name,
                'location' => $registration->item->location->name,
                'condition' => $registration->item->condition_label,
                'condition_badge' => $registration->item->condition_badge,
                'is_borrowed' => $registration->item->activeBorrowing ? true : false,
                'borrowed_by' => $registration->item->activeBorrowing?->user?->name,
                'url' => route('admin.registrations.show', $registration),
            ],
        ]);
    }

    public function destroy(ItemRegistration $registration)
    {
        ActivityLog::log('registration_deleted', "Menghapus registrasi: {$registration->unique_id}");
        $registration->delete();

        return redirect()->route('admin.registrations.index')->with('success', 'Registrasi berhasil dihapus.');
    }
}
