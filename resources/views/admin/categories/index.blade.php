@extends('layouts.app')
@section('title', 'Kategori Barang')
@section('page-title', 'Kategori Barang')

@section('breadcrumb')
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-muted">Pengaturan</li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-gray-900">Kategori</li>
</ul>
@endsection

@push('vendor-css')
<link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
@endpush

@section('content')
<div class="card card-flush">
    <div class="card-header border-0 pt-6">
        <div class="card-title">
            <h3 class="fw-bold">Daftar Kategori</h3>
        </div>
        <div class="card-toolbar">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="ki-duotone ki-plus fs-2"></i> Tambah Kategori
            </button>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3" id="kt_datatable">
                <thead>
                    <tr class="fw-bold text-muted">
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th>Slug</th>
                        <th>Jumlah Barang</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $cat)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-bold">{{ $cat->name }}</td>
                        <td><span class="badge badge-light-info">{{ $cat->slug }}</span></td>
                        <td>{{ $cat->items_count }}</td>
                        <td class="text-end">
                            <button class="btn btn-icon btn-light-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $cat->id }}">
                                <i class="ki-duotone ki-pencil fs-4"><span class="path1"></span><span class="path2"></span></i>
                            </button>
                            <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin menghapus kategori ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-icon btn-light-danger btn-sm"><i class="ki-duotone ki-trash fs-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i></button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal{{ $cat->id }}" tabindex="-1">
                        <div class="modal-dialog"><div class="modal-content">
                            <form action="{{ route('admin.categories.update', $cat) }}" method="POST">
                                @csrf @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Kategori</h5>
                                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"><i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i></div>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3"><label class="form-label required">Nama Kategori</label><input type="text" name="name" class="form-control" value="{{ $cat->name }}" required/></div>
                                    <div class="mb-3"><label class="form-label">Deskripsi</label><textarea name="description" class="form-control" rows="2">{{ $cat->description }}</textarea></div>
                                </div>
                                <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Simpan</button></div>
                            </form>
                        </div></div>
                    </div>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted py-10">Belum ada kategori</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kategori</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"><i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i></div>
            </div>
            <div class="modal-body">
                <div class="mb-3"><label class="form-label required">Nama Kategori</label><input type="text" name="name" class="form-control" required placeholder="Contoh: Meja, Kursi, Proyektor"/></div>
                <div class="mb-3"><label class="form-label">Deskripsi</label><textarea name="description" class="form-control" rows="2" placeholder="Opsional..."></textarea></div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Simpan</button></div>
        </form>
    </div></div>
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
