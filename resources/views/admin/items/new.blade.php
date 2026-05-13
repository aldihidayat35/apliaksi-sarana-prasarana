@extends('layouts.app')
@section('title', 'Barang Baru')
@section('page-title', 'Daftar Barang Baru')

@section('breadcrumb')
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.items.index') }}" class="text-muted text-hover-primary">Inventaris</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-gray-900">Barang Baru</li>
</ul>
@endsection

@push('custom-css')
<style>
.catalog-hero {
    background: radial-gradient(120% 120% at 0% 0%, #e6f4ff 0%, #ffffff 65%),
        radial-gradient(80% 60% at 100% 0%, #fff4e6 0%, #ffffff 60%);
    border: 1px solid #eef2f7;
}
.catalog-card {
    border: 1px solid #eef2f7;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.catalog-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 28px rgba(15, 23, 42, 0.08);
}
.catalog-thumb {
    height: 160px;
    background: linear-gradient(135deg, #f8fafc, #e2e8f0);
}
.catalog-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.catalog-price {
    letter-spacing: 0.2px;
}
</style>
@endpush

@section('content')
<div class="card card-flush catalog-hero mb-7">
    <div class="card-body d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-4">
        <div>
            <h3 class="fw-bold text-gray-900 mb-2">Katalog Barang Terbaru</h3>
            <p class="text-gray-600 mb-0">Menampilkan <strong>{{ $items->count() }}</strong> barang yang baru diperoleh dalam {{ $days }} hari terakhir.</p>
        </div>
        <form method="GET" class="d-flex gap-2 flex-wrap">
            <select name="days" class="form-select form-select-solid w-200px" onchange="this.form.submit()">
                <option value="30" {{ $days == 30 ? 'selected' : '' }}>30 Hari Terakhir</option>
                <option value="60" {{ $days == 60 ? 'selected' : '' }}>60 Hari Terakhir</option>
                <option value="90" {{ $days == 90 ? 'selected' : '' }}>90 Hari Terakhir</option>
                <option value="180" {{ $days == 180 ? 'selected' : '' }}>180 Hari Terakhir</option>
            </select>
            <select name="category_id" class="form-select form-select-solid w-175px" onchange="this.form.submit()">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <select name="location_id" class="form-select form-select-solid w-175px" onchange="this.form.submit()">
                <option value="">Semua Lokasi</option>
                @foreach($locations as $loc)
                    <option value="{{ $loc->id }}" {{ request('location_id') == $loc->id ? 'selected' : '' }}>{{ $loc->name }}</option>
                @endforeach
            </select>
            @if(request()->hasAny(['category_id', 'location_id']))
                <a href="{{ route('admin.items.new', ['days' => $days]) }}" class="btn btn-light-danger btn-sm">Reset</a>
            @endif
        </form>
    </div>
</div>

<div class="row g-5">
    @forelse($items as $item)
    <div class="col-12 col-md-6 col-xl-4">
        <div class="card card-flush catalog-card h-100">
            <div class="catalog-thumb">
                @if($item->photo)
                    <img src="{{ asset('storage/' . $item->photo) }}" alt="{{ $item->name }}">
                @else
                    <div class="h-100 d-flex align-items-center justify-content-center text-gray-400">
                        <i class="ki-duotone ki-picture fs-3x"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                @endif
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h4 class="fw-bold text-gray-900 mb-1">{{ $item->name }}</h4>
                        <div class="text-muted fs-7">{{ $item->category->name ?? '-' }}</div>
                    </div>
                    <div class="d-flex flex-column align-items-end gap-1">
                        <span class="badge badge-light-{{ $item->availability_badge }}">{{ $item->availability_label }}</span>
                        <span class="badge badge-light-{{ $item->condition_badge }}">{{ $item->condition_label }}</span>
                    </div>
                </div>
                <div class="separator my-4"></div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Tanggal Perolehan</span>
                    <span class="fw-semibold text-gray-800">{{ $item->acquisition_date?->format('d M Y') ?? $item->created_at->format('d M Y') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Lokasi</span>
                    <span class="fw-semibold text-gray-800">{{ $item->location->name ?? '-' }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Harga</span>
                    <span class="fw-bold text-gray-900 catalog-price">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <a href="{{ route('admin.items.show', $item) }}" class="btn btn-light-primary w-100">Lihat Detail</a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card card-flush">
            <div class="card-body text-center py-10 text-muted">Belum ada barang baru dalam periode ini.</div>
        </div>
    </div>
    @endforelse
</div>
@endsection
