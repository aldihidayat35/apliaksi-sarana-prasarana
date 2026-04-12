@extends('layouts.app')
@section('title', 'Cetak QR Code')
@section('page-title', 'Cetak QR Code')

@section('breadcrumb')
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.registrations.index') }}" class="text-muted text-hover-primary">Registrasi</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-gray-900">QR Code</li>
</ul>
@endsection

@push('custom-css')
<style>
@media print {
    body * { visibility: hidden; }
    #printArea, #printArea * { visibility: visible; }
    #printArea { position: absolute; left: 0; top: 0; width: 100%; }
    .no-print { display: none !important; }
}
</style>
@endpush

@section('content')
<div class="card card-flush">
    <div class="card-header no-print">
        <h3 class="card-title">QR Code - {{ $registration->item->name }}</h3>
        <div class="card-toolbar">
            <button onclick="window.print()" class="btn btn-primary">
                <i class="ki-duotone ki-printer fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i> Cetak
            </button>
        </div>
    </div>
    <div class="card-body">
        <div id="printArea" class="text-center py-10">
            <div class="border border-2 border-gray-300 rounded d-inline-block p-8">
                <div class="mb-4">
                    <h4 class="fw-bold">{{ app_setting('app_name', 'BRIL-SMART') }}</h4>
                    <p class="text-muted fs-7 mb-0">Sistem Manajemen Sarana & Prasarana</p>
                </div>
                <div id="qrcode" class="d-inline-block mb-4"></div>
                <div>
                    <h5 class="fw-bold mb-1">{{ $registration->unique_id }}</h5>
                    <p class="text-gray-700 mb-0">{{ $registration->item->name }}</p>
                    <p class="text-muted fs-7 mb-0">[{{ $registration->item->code }}] - {{ $registration->item->location->name }}</p>
                </div>
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
    width: 250,
    height: 250,
    colorDark: "#000000",
    colorLight: "#ffffff",
    correctLevel: QRCode.CorrectLevel.H
});
</script>
@endpush
