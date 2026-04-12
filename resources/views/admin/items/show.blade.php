@extends('layouts.app')
@section('title', 'Detail Barang')
@section('page-title', 'Detail Barang')

@section('breadcrumb')
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.items.index') }}" class="text-muted text-hover-primary">Inventaris</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-gray-900">{{ $item->name }}</li>
</ul>
@endsection

@section('content')
<div class="row g-5 g-xl-8">
    <!--begin::Detail Card-->
    <div class="col-xl-4">
        <div class="card card-flush mb-5">
            <div class="card-header">
                <h3 class="card-title">Informasi Barang</h3>
                <div class="card-toolbar">
                    <a href="{{ route('admin.items.edit', $item) }}" class="btn btn-sm btn-light-primary">
                        <i class="ki-duotone ki-pencil fs-4"><span class="path1"></span><span class="path2"></span></i> Edit
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($item->photo)
                <div class="text-center mb-5">
                    <img src="{{ asset('storage/' . $item->photo) }}" class="rounded mw-100" style="max-height: 200px;" alt="{{ $item->name }}">
                </div>
                @endif
                <table class="table table-row-bordered gy-3">
                    <tr><td class="fw-bold text-muted w-150px">Kode</td><td><span class="badge badge-light-info">{{ $item->code }}</span></td></tr>
                    <tr><td class="fw-bold text-muted">Nama</td><td class="fw-bold">{{ $item->name }}</td></tr>
                    <tr><td class="fw-bold text-muted">Kategori</td><td>{{ $item->category->name }}</td></tr>
                    <tr><td class="fw-bold text-muted">Lokasi</td><td>{{ $item->location->name }}</td></tr>
                    <tr><td class="fw-bold text-muted">Kondisi</td><td><span class="badge badge-light-{{ $item->condition_badge }}">{{ $item->condition_label }}</span></td></tr>
                    <tr><td class="fw-bold text-muted">Jumlah</td><td>{{ $item->quantity }}</td></tr>
                    <tr><td class="fw-bold text-muted">Harga</td><td>Rp {{ number_format($item->price, 0, ',', '.') }}</td></tr>
                    <tr><td class="fw-bold text-muted">Tgl Perolehan</td><td>{{ $item->acquisition_date?->format('d M Y') ?? '-' }}</td></tr>
                    <tr><td class="fw-bold text-muted">Sumber</td><td>{{ $item->acquisition_source ?? '-' }}</td></tr>
                    <tr><td class="fw-bold text-muted">QR Status</td><td>
                        @if($item->registration)
                            <span class="badge badge-light-success">Terdaftar ({{ $item->registration->unique_id }})</span>
                        @else
                            <span class="badge badge-light-warning">Belum Registrasi</span>
                        @endif
                    </td></tr>
                </table>

                @if($item->registration)
                <!--begin::QR Code-->
                <div class="separator my-5"></div>
                <div class="text-center">
                    <h6 class="fw-bold text-gray-700 mb-4">QR Code Barang</h6>
                    <div class="d-inline-block bg-white p-4 rounded border border-gray-200 mb-3">
                        <div id="qrcode_display" style="width: 180px; height: 180px; margin: 0 auto;"></div>
                    </div>
                    <div class="mt-2">
                        <span class="badge badge-light-primary fw-bold fs-7">{{ $item->registration->unique_id }}</span>
                    </div>
                    <button type="button" class="btn btn-sm btn-light-success mt-3" onclick="printQR()">
                        <i class="ki-duotone ki-printer fs-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i> Cetak QR
                    </button>
                </div>
                <!--end::QR Code-->
                @endif
                @if($item->description)
                <div class="mt-4">
                    <span class="fw-bold text-muted">Deskripsi:</span>
                    <p class="text-gray-700 mt-2">{{ $item->description }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    <!--end::Detail Card-->

    <!--begin::History-->
    <div class="col-xl-8">
        <!--begin::Borrowing History-->
        <div class="card card-flush mb-5">
            <div class="card-header">
                <h3 class="card-title">Riwayat Peminjaman</h3>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table table-row-bordered gy-3">
                        <thead>
                            <tr class="fw-bold text-muted">
                                <th>Peminjam</th>
                                <th>Tgl Pinjam</th>
                                <th>Tgl Kembali</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($item->borrowings as $b)
                            <tr>
                                <td>{{ $b->user->name }}</td>
                                <td>{{ $b->borrow_date->format('d M Y') }}</td>
                                <td>{{ $b->actual_return_date?->format('d M Y') ?? '-' }}</td>
                                <td><span class="badge badge-light-{{ $b->status_badge }}">{{ $b->status_label }}</span></td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted py-5">Belum ada riwayat peminjaman</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--end::Borrowing History-->

        <!--begin::Condition History-->
        <div class="card card-flush">
            <div class="card-header">
                <h3 class="card-title">Riwayat Kondisi</h3>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table table-row-bordered gy-3">
                        <thead>
                            <tr class="fw-bold text-muted">
                                <th>Tanggal</th>
                                <th>Sebelum</th>
                                <th>Sesudah</th>
                                <th>Keterangan</th>
                                <th>Pelapor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($item->conditionReports as $r)
                            <tr>
                                <td>{{ $r->report_date->format('d M Y') }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $r->condition_before)) }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $r->condition_after)) }}</td>
                                <td>{{ Str::limit($r->description, 50) }}</td>
                                <td>{{ $r->reportedByUser->name }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted py-5">Belum ada riwayat kondisi</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--end::Condition History-->
    </div>
    <!--end::History-->
</div>
@endsection

@if($item->registration)
@push('vendor-js')
<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
@endpush

@push('custom-js')
<script>
new QRCode(document.getElementById("qrcode_display"), {
    text: "{{ $item->registration->unique_id }}",
    width: 180,
    height: 180,
    colorDark: "#1B2559",
    colorLight: "#ffffff",
    correctLevel: QRCode.CorrectLevel.H
});

function printQR() {
    var qrImg = document.querySelector('#qrcode_display img');
    if (!qrImg) { var canvas = document.querySelector('#qrcode_display canvas'); if(canvas) qrImg = {src: canvas.toDataURL()}; }
    var w = window.open('', '_blank');
    w.document.write('<html><head><title>QR Code - {{ $item->registration->unique_id }}</title>');
    w.document.write('<style>body{text-align:center;font-family:Inter,sans-serif;padding:40px;}h3{margin-bottom:5px;}p{color:#666;margin-bottom:20px;}</style>');
    w.document.write('</head><body>');
    w.document.write('<h3>{{ e($item->name) }}</h3>');
    w.document.write('<p>{{ $item->registration->unique_id }}</p>');
    w.document.write('<img src="' + (qrImg.src || qrImg.getAttribute('src')) + '" style="width:200px;height:200px;">');
    w.document.write('<p style="margin-top:15px;font-size:12px;">{{ app_setting("app_name", "BRIL-SMART") }}</p>');
    w.document.write('</body></html>');
    w.document.close();
    w.onload = function() { w.print(); };
}
</script>
@endpush
@endif
