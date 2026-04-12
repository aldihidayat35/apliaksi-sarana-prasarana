@extends('layouts.app')
@section('title', 'Laporan')
@section('page-title', 'Pusat Laporan')

@section('breadcrumb')
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-gray-900">Laporan</li>
</ul>
@endsection

@section('content')
<div class="row g-5 g-xl-8">
    <div class="col-xl-3 col-md-6">
        <a href="{{ route('admin.reports.inventory') }}" class="card card-flush hoverable h-100">
            <div class="card-body text-center py-10">
                <i class="ki-duotone ki-box fs-5x text-primary mb-5"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                <h3 class="fw-bold text-gray-900">Laporan Inventaris</h3>
                <p class="text-gray-500 fs-7">Laporan seluruh data barang dan aset sekolah</p>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-md-6">
        <a href="{{ route('admin.reports.borrowing') }}" class="card card-flush hoverable h-100">
            <div class="card-body text-center py-10">
                <i class="ki-duotone ki-handcart fs-5x text-warning mb-5"><span class="path1"></span><span class="path2"></span></i>
                <h3 class="fw-bold text-gray-900">Laporan Peminjaman</h3>
                <p class="text-gray-500 fs-7">Rekap seluruh transaksi peminjaman barang</p>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-md-6">
        <a href="{{ route('admin.reports.damage') }}" class="card card-flush hoverable h-100">
            <div class="card-body text-center py-10">
                <i class="ki-duotone ki-shield-cross fs-5x text-danger mb-5"><span class="path1"></span><span class="path2"></span></i>
                <h3 class="fw-bold text-gray-900">Laporan Kerusakan</h3>
                <p class="text-gray-500 fs-7">Riwayat perubahan kondisi & kerusakan barang</p>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-md-6">
        <a href="{{ route('admin.reports.annual') }}" class="card card-flush hoverable h-100">
            <div class="card-body text-center py-10">
                <i class="ki-duotone ki-chart-simple fs-5x text-success mb-5"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                <h3 class="fw-bold text-gray-900">Laporan Tahunan</h3>
                <p class="text-gray-500 fs-7">Ringkasan statistik tahunan sarana prasarana</p>
            </div>
        </a>
    </div>
</div>
@endsection
