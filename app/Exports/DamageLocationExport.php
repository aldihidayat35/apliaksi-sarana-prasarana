<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DamageLocationExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected Collection $reports;

    public function __construct(Collection $reports)
    {
        $this->reports = $reports;
    }

    public function collection(): Collection
    {
        return $this->reports;
    }

    public function headings(): array
    {
        return ['Lokasi', 'Barang', 'Tanggal', 'Kondisi Sesudah', 'Keterangan', 'Pelapor'];
    }

    public function map($report): array
    {
        return [
            $report->item->location->name ?? '-',
            $report->item->name ?? '-',
            $report->report_date?->format('Y-m-d') ?? '-',
            ucfirst(str_replace('_', ' ', $report->condition_after)),
            $report->description,
            $report->reportedByUser->name ?? '-',
        ];
    }
}
