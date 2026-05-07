<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ConditionExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
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
        return ['Kode', 'Nama Barang', 'Kondisi', 'Lokasi', 'Kategori', 'Jumlah', 'Harga', 'Tgl Perolehan'];
    }

    public function map($item): array
    {
        return [
            $item->code,
            $item->name,
            $item->condition_label,
            $item->location->name ?? '-',
            $item->category->name ?? '-',
            $item->quantity,
            (float) $item->price,
            $item->acquisition_date?->format('Y-m-d') ?? '-',
        ];
    }
}
