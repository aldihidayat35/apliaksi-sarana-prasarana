<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        $query = Location::withCount('items');

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $locations = $query->orderBy('name')->get();
        return view('admin.locations.index', compact('locations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:locations'],
            'description' => ['nullable', 'string'],
        ]);

        Location::create($validated);

        return redirect()->route('admin.locations.index')->with('success', 'Lokasi berhasil ditambahkan.');
    }

    public function update(Request $request, Location $location)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:locations,code,' . $location->id],
            'description' => ['nullable', 'string'],
        ]);

        $location->update($validated);

        return redirect()->route('admin.locations.index')->with('success', 'Lokasi berhasil diperbarui.');
    }

    public function destroy(Location $location)
    {
        if ($location->items()->exists()) {
            return back()->with('error', 'Lokasi tidak dapat dihapus karena masih memiliki barang.');
        }

        $location->delete();

        return redirect()->route('admin.locations.index')->with('success', 'Lokasi berhasil dihapus.');
    }
}
