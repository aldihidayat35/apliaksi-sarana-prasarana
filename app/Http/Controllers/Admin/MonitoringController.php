<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\ConditionReport;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MonitoringController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::with(['category', 'location']);

        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        $items = $query->latest()->get();

        $totalBarang = Item::count();
        $barangBaik = Item::where('condition', 'baik')->count();
        $barangRusakRingan = Item::where('condition', 'rusak_ringan')->count();
        $barangRusakBerat = Item::where('condition', 'rusak_berat')->count();
        $barangHilang = Item::where('condition', 'hilang')->count();

        return view('admin.monitoring.index', compact(
            'items', 'totalBarang', 'barangBaik', 'barangRusakRingan', 'barangRusakBerat', 'barangHilang'
        ));
    }

    public function updateCondition(Request $request, Item $item)
    {
        $validated = $request->validate([
            'condition_after' => ['required', 'in:baik,rusak_ringan,rusak_berat,hilang'],
            'description' => ['required', 'string'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $conditionBefore = $item->condition;

        $reportData = [
            'item_id' => $item->id,
            'reported_by' => Auth::id(),
            'condition_before' => $conditionBefore,
            'condition_after' => $validated['condition_after'],
            'description' => $validated['description'],
            'report_date' => now()->toDateString(),
        ];

        if ($request->hasFile('photo')) {
            $reportData['photo'] = $request->file('photo')->store('condition_reports', 'public');
        }

        $report = ConditionReport::create($reportData);
        $item->update(['condition' => $validated['condition_after']]);

        ActivityLog::log('condition_updated', "Update kondisi {$item->name}: {$conditionBefore} → {$validated['condition_after']}", $item);

        return redirect()->route('admin.monitoring.index')->with('success', 'Kondisi barang berhasil diperbarui.');
    }

    public function reports(Request $request)
    {
        $query = ConditionReport::with(['item', 'reportedByUser']);

        if ($request->filled('search')) {
            $query->whereHas('item', fn($q) => $q->where('name', 'like', "%{$request->search}%"));
        }

        $reports = $query->latest()->get();
        return view('admin.monitoring.reports', compact('reports'));
    }
}
