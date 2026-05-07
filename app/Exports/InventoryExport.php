<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class InventoryExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected Collection $items;

    public function __construct(Collection $items)
    {
        $this->items = $items;
    }

    public function collection(): Collection
    {
        return $this->items;
    }

    public function headings(): array
    {
        return ['Kode', 'Nama Barang', 'Kategori', 'Lokasi', 'Kondisi', 'Qty', 'Harga'];
    }

    public function map($item): array
    {
        return [
            $item->code,
            $item->name,
            $item->category->name ?? '-',
            $item->location->name ?? '-',
            $item->condition_label,
            $item->quantity,
            (float) $item->price,
        ];
    }
}
