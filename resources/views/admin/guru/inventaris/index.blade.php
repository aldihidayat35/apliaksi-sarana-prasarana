@extends('layouts.app')
@section('title', 'Daftar Inventaris')
@section('page-title', 'Daftar Inventaris')

@section('breadcrumb')
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-gray-900">Inventaris</li>
</ul>
@endsection

@section('content')
<div class="card card-flush">
    <div class="card-header border-0 pt-6 no-print">
        <div class="card-title">
            <form method="GET" class="d-flex gap-3 flex-wrap">
                <input type="text" name="search" class="form-control form-control-solid w-250px" placeholder="Cari barang..." value="{{ request('search') }}" />
                <select name="category_id" class="form-select form-select-solid w-200px">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                <button class="btn btn-primary btn-sm">Cari</button>
            </form>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                <thead>
                    <tr class="fw-bold text-muted bg-light">
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Lokasi</th>
                        <th>Kondisi</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-muted fw-semibold">{{ $item->code }}</td>
                        <td class="fw-bold text-gray-900">{{ $item->name }}</td>
                        <td class="text-muted">{{ $item->category->name ?? '-' }}</td>
                        <td class="text-muted">{{ $item->location->name ?? '-' }}</td>
                        <td>
                            <span class="badge badge-light-{{ $item->condition_badge }}">{{ $item->condition_label }}</span>
                        </td>
                        <td class="fw-semibold text-center">{{ $item->quantity }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-10">Tidak ada data inventaris.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4 no-print">
            {{ $items->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
