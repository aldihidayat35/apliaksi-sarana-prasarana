@extends('layouts.app')
@section('title', 'Riwayat Perubahan Kondisi')
@section('page-title', 'Riwayat Perubahan Kondisi')

@section('breadcrumb')
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.monitoring.index') }}" class="text-muted text-hover-primary">Monitoring</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-gray-900">Riwayat Perubahan</li>
</ul>
@endsection

@push('vendor-css')
<link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
@endpush

@section('content')
<div class="card card-flush">
    <div class="card-header border-0 pt-6">
        <div class="card-title">
            <h3 class="fw-bold">Riwayat Perubahan Kondisi</h3>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3" id="kt_datatable">
                <thead>
                    <tr class="fw-bold text-muted">
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Barang</th>
                        <th>Sebelum</th>
                        <th>Sesudah</th>
                        <th>Keterangan</th>
                        <th>Pelapor</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $r)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $r->report_date->format('d M Y') }}</td>
                        <td class="fw-bold">{{ $r->item->name }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $r->condition_before)) }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $r->condition_after)) }}</td>
                        <td>{{ Str::limit($r->description, 60) }}</td>
                        <td>{{ $r->reportedByUser->name }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-10">Belum ada riwayat perubahan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('vendor-js')
<script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
@endpush

@push('custom-js')
<script>
$('#kt_datatable').DataTable({
    responsive: true,
    pageLength: 10,
    order: [],
    language: {
        search: "Cari:",
        lengthMenu: "Tampilkan _MENU_ data",
        info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
        infoEmpty: "Tidak ada data",
        infoFiltered: "(disaring dari _MAX_ total data)",
        zeroRecords: "Tidak ditemukan data yang cocok",
        paginate: { first: "Pertama", last: "Terakhir", next: "Selanjutnya", previous: "Sebelumnya" }
    },
    columnDefs: [{ orderable: false, targets: -1 }]
});
</script>
@endpush
