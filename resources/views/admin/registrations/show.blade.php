@extends('layouts.app')
@section('title', 'Detail Registrasi')
@section('page-title', 'Detail Registrasi Sarana')

@section('breadcrumb')
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.registrations.index') }}" class="text-muted text-hover-primary">Registrasi</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-gray-900">{{ $registration->unique_id }}</li>
</ul>
@endsection

@section('content')
<div class="row g-5 g-xl-8">
    <div class="col-xl-4">
        <div class="card card-flush text-center">
            <div class="card-body py-10">
                <div class="mb-5">
                    <div id="qrcode" class="d-inline-block p-5 bg-white rounded shadow-sm"></div>
                </div>
                <h3 class="fw-bold text-gray-900">{{ $registration->unique_id }}</h3>
                <p class="text-muted">{{ $registration->item->name }}</p>
                <a href="{{ route('admin.registrations.qr', $registration) }}" class="btn btn-sm btn-light-success mt-3" target="_blank">
                    <i class="ki-duotone ki-printer fs-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i> Cetak QR Code
                </a>
            </div>
        </div>
    </div>
    <div class="col-xl-8">
        <div class="card card-flush">
            <div class="card-header">
                <h3 class="card-title">Informasi Registrasi</h3>
            </div>
            <div class="card-body">
                <table class="table table-row-bordered gy-4">
                    <tr><td class="fw-bold text-muted w-200px">ID Unik</td><td class="fw-bold"><span class="badge badge-light-success fs-6">{{ $registration->unique_id }}</span></td></tr>
                    <tr><td class="fw-bold text-muted">Nama Barang</td><td class="fw-bold">{{ $registration->item->name }}</td></tr>
                    <tr><td class="fw-bold text-muted">Kode Barang</td><td><span class="badge badge-light-info">{{ $registration->item->code }}</span></td></tr>
                    <tr><td class="fw-bold text-muted">Kategori</td><td>{{ $registration->item->category->name }}</td></tr>
                    <tr><td class="fw-bold text-muted">Lokasi</td><td>{{ $registration->item->location->name }}</td></tr>
                    <tr><td class="fw-bold text-muted">Kondisi</td><td><span class="badge badge-light-{{ $registration->item->condition_badge }}">{{ $registration->item->condition_label }}</span></td></tr>
                    <tr><td class="fw-bold text-muted">Tanggal Registrasi</td><td>{{ $registration->registered_at->format('d M Y, H:i') }}</td></tr>
                    <tr><td class="fw-bold text-muted">Didaftarkan Oleh</td><td>{{ $registration->registeredByUser->name }}</td></tr>
                    @if($registration->notes)
                    <tr><td class="fw-bold text-muted">Catatan</td><td>{{ $registration->notes }}</td></tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('vendor-js')
<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
@endpush
@push('custom-js')
<script>
new QRCode(document.getElementById("qrcode"), {
    text: "{{ $registration->unique_id }}",
    width: 200,
    height: 200,
    colorDark: "#000000",
    colorLight: "#ffffff",
    correctLevel: QRCode.CorrectLevel.H
});
</script>
@endpush
