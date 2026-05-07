@extends('layouts.app')
@section('title', 'Detail Peminjaman')
@section('page-title', 'Detail Peminjaman')

@section('breadcrumb')
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.borrowings.index') }}" class="text-muted text-hover-primary">Peminjaman</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-gray-900">Detail</li>
</ul>
@endsection

@section('content')
<div class="row g-5">
    <div class="col-xl-6">
        <div class="card card-flush">
            <div class="card-header">
                <h3 class="card-title">Informasi Peminjaman</h3>
            </div>
            <div class="card-body">
                <table class="table table-row-bordered gy-4">
                    <tr>
                        <td class="fw-bold text-muted w-175px">Status</td>
                        <td><span class="badge badge-light-{{ $borrowing->status_badge }} fs-6">{{ $borrowing->status_label }}</span></td>
                    </tr>
                    <tr><td class="fw-bold text-muted">Peminjam</td><td class="fw-bold">{{ $borrowing->user->name }}</td></tr>
                    <tr><td class="fw-bold text-muted">Tanggal Pinjam</td><td>{{ $borrowing->borrow_date->format('d M Y') }}</td></tr>
                    <tr><td class="fw-bold text-muted">Harus Kembali</td><td>{{ $borrowing->expected_return_date->format('d M Y') }}</td></tr>
                    <tr><td class="fw-bold text-muted">Dikembalikan</td><td>{{ $borrowing->actual_return_date?->format('d M Y') ?? '-' }}</td></tr>
                    <tr><td class="fw-bold text-muted">Kondisi Pengembalian</td><td>{{ $borrowing->return_condition_label ?? '-' }}</td></tr>
                    <tr><td class="fw-bold text-muted">Tujuan</td><td>{{ $borrowing->purpose ?? '-' }}</td></tr>
                    <tr><td class="fw-bold text-muted">Catatan</td><td>{{ $borrowing->notes ?? '-' }}</td></tr>
                    <tr><td class="fw-bold text-muted">Keterangan Pengembalian</td><td>{{ $borrowing->return_notes ?? '-' }}</td></tr>
                    <tr><td class="fw-bold text-muted">Disetujui Oleh</td><td>{{ $borrowing->approvedByUser->name ?? '-' }}</td></tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card card-flush">
            <div class="card-header">
                <h3 class="card-title">Informasi Barang</h3>
            </div>
            <div class="card-body">
                <table class="table table-row-bordered gy-4">
                    <tr><td class="fw-bold text-muted w-175px">Nama Barang</td><td class="fw-bold">{{ $borrowing->item->name }}</td></tr>
                    <tr><td class="fw-bold text-muted">Kode</td><td><span class="badge badge-light-info">{{ $borrowing->item->code }}</span></td></tr>
                    <tr><td class="fw-bold text-muted">Kategori</td><td>{{ $borrowing->item->category->name }}</td></tr>
                    <tr><td class="fw-bold text-muted">Lokasi</td><td>{{ $borrowing->item->location->name }}</td></tr>
                    <tr><td class="fw-bold text-muted">Kondisi</td><td><span class="badge badge-light-{{ $borrowing->item->condition_badge }}">{{ $borrowing->item->condition_label }}</span></td></tr>
                    <tr><td class="fw-bold text-muted">Status</td><td><span class="badge badge-light-{{ $borrowing->item->availability_badge }}">{{ $borrowing->item->availability_label }}</span></td></tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
