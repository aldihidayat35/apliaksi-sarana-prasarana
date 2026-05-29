@extends('layouts.app')
@section('title', 'Barang Sedang Dipinjam')
@section('page-title', 'Barang Sedang Dipinjam')

@section('breadcrumb')
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
    <li class="breadcrumb-item text-gray-500"><a href="{{ route('admin.dashboard') }}" class="text-gray-500 text-hover-primary">Dashboard</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-gray-500"><a href="{{ route('guru.inventaris') }}" class="text-gray-500 text-hover-primary">Inventaris</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-gray-900">Sedang Dipinjam</li>
</ul>
@endsection

@section('content')
<div class="card card-flush">
    <div class="card-header border-0 pt-6">
        <div class="card-title">
            <h3 class="fw-bold text-gray-800">Barang yang Saya Pinjam</h3>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                <thead>
                    <tr class="fw-bold text-gray-500 bg-light">
                        <th>No</th>
                        <th>Barang</th>
                        <th>Kode</th>
                        <th>Lokasi</th>
                        <th>Tgl Pinjam</th>
                        <th>Harus Kembali</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($borrowings as $b)
                    @php
                        $isOverdue = $b->status === 'terlambat' || ($b->expected_return_date && $b->expected_return_date->isPast());
                    @endphp
                    <tr class="{{ $isOverdue ? 'table-danger' : '' }}">
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-bold text-gray-900">{{ $b->item->name ?? '-' }}</td>
                        <td class="text-gray-500 fw-semibold">{{ $b->item->code ?? '-' }}</td>
                        <td class="text-gray-500">{{ $b->item->location->name ?? '-' }}</td>
                        <td class="text-gray-500">{{ $b->borrow_date->format('d M Y') }}</td>
                        <td>
                            <span class="fw-semibold {{ $isOverdue ? 'text-danger' : 'text-gray-700' }}">
                                {{ $b->expected_return_date->format('d M Y') }}
                            </span>
                            @if($isOverdue)
                                <span class="badge badge-danger ms-1">{{ $b->expected_return_date->diffInDays(now()) }} hari terlambat</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-light-{{ $isOverdue ? 'danger' : 'primary' }}">
                                {{ $isOverdue ? 'Terlambat' : 'Dipinjam' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.borrowings.return-slip', $b) }}" target="_blank" class="btn btn-light-primary btn-icon btn-sm" title="Bukti Pengembalian">
                                <i class="ki-duotone ki-devise fs-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-10">
                            <i class="ki-duotone ki-check-circle fs-3x mb-2 d-block text-success"></i>
                            <span class="text-gray-500">Anda tidak sedang meminjam barang apapun.</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $borrowings->links() }}
        </div>
    </div>
</div>
@endsection
