<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BorrowingExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected Collection $borrowings;

    public function __construct(Collection $borrowings)
    {
        $this->borrowings = $borrowings;
    }

    public function collection(): Collection
    {
        return $this->borrowings;
    }

    public function headings(): array
    {
        return [
            'Barang',
            'Peminjam',
            'Tanggal Pinjam',
            'Harus Kembali',
            'Dikembalikan',
            'Status',
            'Kondisi Pengembalian',
            'Keterangan Pengembalian',
        ];
    }

    public function map($borrowing): array
    {
        return [
            $borrowing->item->name ?? '-',
            $borrowing->user->name ?? '-',
            $borrowing->borrow_date?->format('Y-m-d') ?? '-',
            $borrowing->expected_return_date?->format('Y-m-d') ?? '-',
            $borrowing->actual_return_date?->format('Y-m-d') ?? '-',
            $borrowing->status_label,
            $borrowing->return_condition_label ?? '-',
            $borrowing->return_notes ?? '-',
        ];
    }
}
