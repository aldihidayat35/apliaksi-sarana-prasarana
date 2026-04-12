@extends('layouts.app')
@section('title', 'Registrasi Sarana')
@section('page-title', 'Registrasi Sarana')

@section('breadcrumb')
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-gray-900">Registrasi Sarana</li>
</ul>
@endsection

@push('vendor-css')
<link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
@endpush

@section('content')
<div class="card card-flush">
    <div class="card-header border-0 pt-6">
        <div class="card-title">
            <h3 class="fw-bold">Data Registrasi</h3>
        </div>
        <div class="card-toolbar gap-3">
            <a href="{{ route('admin.registrations.scan') }}" class="btn btn-info">
                <i class="ki-duotone ki-scan-barcode fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span></i> Scan QR
            </a>
            <a href="{{ route('admin.registrations.create') }}" class="btn btn-primary">
                <i class="ki-duotone ki-plus fs-2"></i> Registrasi Baru
            </a>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3" id="kt_datatable">
                <thead>
                    <tr class="fw-bold text-muted">
                        <th>No</th>
                        <th>ID Unik</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Lokasi</th>
                        <th>Tgl Registrasi</th>
                        <th>Didaftarkan Oleh</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($registrations as $reg)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><span class="badge badge-light-success fw-bold fs-7">{{ $reg->unique_id }}</span></td>
                        <td class="fw-bold">{{ $reg->item->name }}</td>
                        <td>{{ $reg->item->category->name }}</td>
                        <td>{{ $reg->item->location->name }}</td>
                        <td>{{ $reg->registered_at->format('d M Y') }}</td>
                        <td>{{ $reg->registeredByUser->name }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.registrations.show', $reg) }}" class="btn btn-icon btn-light-info btn-sm" title="Detail">
                                <i class="ki-duotone ki-eye fs-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                            </a>
                            <a href="{{ route('admin.registrations.qr', $reg) }}" class="btn btn-icon btn-light-success btn-sm" title="QR Code">
                                <i class="ki-duotone ki-scan-barcode fs-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span></i>
                            </a>
                            <form action="{{ route('admin.registrations.destroy', $reg) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin menghapus registrasi ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-icon btn-light-danger btn-sm" title="Hapus">
                                    <i class="ki-duotone ki-trash fs-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-10">Belum ada data registrasi</td>
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
