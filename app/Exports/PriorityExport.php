<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PriorityExport implements FromCollection, WithHeadings, WithMapping
{
    protected $items;

    public function __construct($items)
    {
        $this->items = $items;
    }

    public function collection()
    {
        return $this->items;
    }

    public function headings(): array
    {
        return ['No', 'Nama Barang', 'Kategori', 'Lokasi', 'Kondisi', 'Skor Prioritas (%)', 'Total Kerusakan', 'Kerusakan Baru', 'Total Peminjaman'];
    }

    public function map($item): array
    {
        return [
            '',
            $item->name,
            $item->category->name ?? '-',
            $item->location->name ?? '-',
            $item->condition,
            $item->priority_score,
            $item->damage_total,
            $item->damage_recent,
            $item->usage_recent,
        ];
    }
}
