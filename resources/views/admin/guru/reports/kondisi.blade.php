@extends('layouts.app')
@section('title', 'Laporan Kondisi Barang')
@section('page-title', 'Laporan Kondisi Barang')

@section('breadcrumb')
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
    <li class="breadcrumb-item text-gray-500"><a href="{{ route('guru.dashboard') }}" class="text-gray-500 text-hover-primary">Dashboard</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-gray-900">Laporan Kondisi Barang</li>
</ul>
@endsection

@section('content')
{{-- Summary Cards --}}
<div class="row g-5 g-xl-8 mb-5 no-print">
    <div class="col-xl-3 col-md-6"><div class="card card-flush"><div class="card-body text-center py-5"><div class="fs-2hx fw-bold text-primary">{{ $summary['total'] }}</div><div class="fs-7 text-gray-500 fw-semibold mt-1">Total Barang</div></div></div></div>
    <div class="col-xl-3 col-md-6"><div class="card card-flush"><div class="card-body text-center py-5"><div class="fs-2hx fw-bold text-success">{{ $summary['baik'] }}</div><div class="fs-7 text-gray-500 fw-semibold mt-1">Baik</div></div></div></div>
    <div class="col-xl-3 col-md-6"><div class="card card-flush"><div class="card-body text-center py-5"><div class="fs-2hx fw-bold text-warning">{{ $summary['rusak_ringan'] }}</div><div class="fs-7 text-gray-500 fw-semibold mt-1">Rusak Ringan</div></div></div></div>
    <div class="col-xl-3 col-md-6"><div class="card card-flush"><div class="card-body text-center py-5"><div class="fs-2hx fw-bold text-danger">{{ $summary['rusak_berat'] + $summary['hilang'] }}</div><div class="fs-7 text-gray-500 fw-semibold mt-1">Rusak Berat + Hilang</div></div></div></div>
</div>

<div class="card card-flush">
    <div class="card-header border-0 pt-6 no-print">
        <div class="card-title">
            <form method="GET" class="d-flex gap-3 flex-wrap">
                <select name="condition" class="form-select form-select-solid w-175px">
                    <option value="">Semua Kondisi</option>
                    <option value="baik" {{ request('condition') == 'baik' ? 'selected' : '' }}>Baik</option>
                    <option value="rusak_ringan" {{ request('condition') == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                    <option value="rusak_berat" {{ request('condition') == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                    <option value="hilang" {{ request('condition') == 'hilang' ? 'selected' : '' }}>Hilang</option>
                </select>
                <select name="category_id" class="form-select form-select-solid w-200px">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                <select name="location_id" class="form-select form-select-solid w-200px">
                    <option value="">Semua Lokasi</option>
                    @foreach($locations as $loc)
                        <option value="{{ $loc->id }}" {{ request('location_id') == $loc->id ? 'selected' : '' }}>{{ $loc->name }}</option>
                    @endforeach
                </select>
                <button class="btn btn-primary btn-sm">Filter</button>
                @if(request()->hasAny(['condition', 'category_id', 'location_id']))
                    <a href="{{ route('guru.reports.kondisi') }}" class="btn btn-light-danger btn-sm">Reset</a>
                @endif
            </form>
        </div>
        <div class="card-toolbar d-flex gap-2">
            <a href="{{ route('guru.reports.kondisi.pdf', request()->all()) }}" class="btn btn-light-danger btn-sm"><i class="ki-duotone ki-file-down fs-4"><span class="path1"></span><span class="path2"></span></i> Unduh PDF</a>
            <a href="{{ route('guru.reports.kondisi.excel', request()->all()) }}" class="btn btn-light-success btn-sm">
                <i class="ki-duotone ki-file-down fs-4"><span class="path1"></span><span class="path2"></span></i> Unduh Excel
            </a>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3 table-striped">
                <thead>
                    <tr class="fw-bold text-gray-500 bg-light">
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Kondisi</th>
                        <th>Lokasi</th>
                        <th>Kategori</th>
                        <th>Qty</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-gray-500 fw-semibold">{{ $item->code }}</td>
                        <td class="fw-bold text-gray-900">{{ $item->name }}</td>
                        <td><span class="badge badge-light-{{ $item->condition_badge }}">{{ $item->condition_label }}</span></td>
                        <td class="text-gray-500">{{ $item->location->name ?? '-' }}</td>
                        <td class="text-gray-500">{{ $item->category->name ?? '-' }}</td>
                        <td class="fw-semibold text-center">{{ $item->quantity }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-gray-500 py-10">Tidak ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection