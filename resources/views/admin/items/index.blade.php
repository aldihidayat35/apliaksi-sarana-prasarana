@extends('layouts.app')
@section('title', 'Daftar Barang')
@section('page-title', 'Inventaris Barang')

@section('breadcrumb')
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-gray-900">Inventaris Barang</li>
</ul>
@endsection

@push('vendor-css')
<link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
@endpush

@section('content')
<div class="card card-flush">
    <div class="card-header border-0 pt-6">
        <div class="card-title">
            <form method="GET" class="d-flex gap-3">
                <select name="category_id" class="form-select form-select-solid w-175px" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                <select name="condition" class="form-select form-select-solid w-175px" onchange="this.form.submit()">
                    <option value="">Semua Kondisi</option>
                    <option value="baik" {{ request('condition') == 'baik' ? 'selected' : '' }}>Baik</option>
                    <option value="rusak_ringan" {{ request('condition') == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                    <option value="rusak_berat" {{ request('condition') == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                    <option value="hilang" {{ request('condition') == 'hilang' ? 'selected' : '' }}>Hilang</option>
                </select>
            </form>
        </div>
        <div class="card-toolbar">
            <a href="{{ route('admin.items.create') }}" class="btn btn-primary">
                <i class="ki-duotone ki-plus fs-2"></i> Tambah Barang
            </a>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3" id="kt_datatable">
                <thead>
                    <tr class="fw-bold text-muted">
                        <th class="min-w-50px">No</th>
                        <th class="min-w-120px">Kode</th>
                        <th class="min-w-200px">Nama Barang</th>
                        <th class="min-w-120px">Kategori</th>
                        <th class="min-w-120px">Lokasi</th>
                        <th class="min-w-100px">Kondisi</th>
                        <th class="min-w-80px">Qty</th>
                        <th class="min-w-120px text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><span class="badge badge-light-info fw-bold">{{ $item->code }}</span></td>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($item->photo)
                                <div class="symbol symbol-40px me-3">
                                    <img src="{{ asset('storage/' . $item->photo) }}" alt="">
                                </div>
                                @endif
                                <span class="text-gray-900 fw-bold">{{ $item->name }}</span>
                            </div>
                        </td>
                        <td>{{ $item->category->name }}</td>
                        <td>{{ $item->location->name }}</td>
                        <td><span class="badge badge-light-{{ $item->condition_badge }}">{{ $item->condition_label }}</span></td>
                        <td>{{ $item->quantity }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.items.show', $item) }}" class="btn btn-icon btn-light-info btn-sm" title="Detail">
                                <i class="ki-duotone ki-eye fs-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                            </a>
                            <a href="{{ route('admin.items.edit', $item) }}" class="btn btn-icon btn-light-primary btn-sm" title="Edit">
                                <i class="ki-duotone ki-pencil fs-4"><span class="path1"></span><span class="path2"></span></i>
                            </a>
                            <form action="{{ route('admin.items.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-icon btn-light-danger btn-sm" title="Hapus">
                                    <i class="ki-duotone ki-trash fs-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-10">Belum ada data barang</td>
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
