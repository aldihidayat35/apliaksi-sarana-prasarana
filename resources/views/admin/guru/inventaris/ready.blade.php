@extends('layouts.app')
@section('title', 'Barang Ready')
@section('page-title', 'Barang Ready')

@section('breadcrumb')
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-muted"><a href="{{ route('guru.inventaris') }}" class="text-muted text-hover-primary">Inventaris</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-gray-900">Barang Ready</li>
</ul>
@endsection

@section('content')
<div class="card card-flush">
    <div class="card-header border-0 pt-6 no-print">
        <div class="card-title">
            <h3 class="fw-bold text-gray-800">Barang yang Tersedia untuk Dipinjam</h3>
        </div>
        <div class="card-toolbar">
            <form method="GET" class="d-flex gap-3">
                <input type="text" name="search" class="form-control form-control-solid w-200px" placeholder="Cari barang..." value="{{ request('search') }}" />
                <select name="category_id" class="form-select form-select-solid w-175px">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                <button class="btn btn-primary btn-sm">Filter</button>
            </form>
        </div>
    </div>
    <div class="card-body pt-0">
        @if($items->count())
        <div class="table-responsive">
            <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                <thead>
                    <tr class="fw-bold text-muted bg-light">
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Lokasi</th>
                        <th>Tersedia</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    @php
                        $borrowed = \App\Models\Borrowing::where('item_id', $item->id)
                            ->whereIn('status', ['dipinjam', 'terlambat'])->count();
                        $available = $item->quantity - $borrowed;
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-muted fw-semibold">{{ $item->code }}</td>
                        <td class="fw-bold text-gray-900">{{ $item->name }}</td>
                        <td class="text-muted">{{ $item->category->name ?? '-' }}</td>
                        <td class="text-muted">{{ $item->location->name ?? '-' }}</td>
                        <td class="text-center">
                            <span class="badge badge-light-success">{{ $available }} unit</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center text-muted py-10">
            <i class="ki-duotone ki-information-2 fs-3x mb-2 d-block text-muted"></i>
            <span>Tidak ada barang yang ready saat ini.</span>
        </div>
        @endif
    </div>
</div>
@endsection
