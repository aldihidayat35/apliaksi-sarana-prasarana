<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AnnualExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected array $rows;
    protected string $year;

    public function __construct(array $rows, string $year)
    {
        $this->rows = $rows;
        $this->year = $year;
    }

    public function collection(): Collection
    {
        return collect($this->rows)->map(function ($row) {
            return [
                $row['month'] ?? '-',
                $row['items'] ?? 0,
                $row['borrowings'] ?? 0,
                $row['damages'] ?? 0,
            ];
        });
    }

    public function headings(): array
    {
        return ['Bulan', 'Barang Baru', 'Peminjaman ' . $this->year, 'Kerusakan ' . $this->year];
    }
}
