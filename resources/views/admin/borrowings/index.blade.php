@extends('layouts.app')
@section('title', 'Data Peminjaman')
@section('page-title', 'Peminjaman Barang')

@section('breadcrumb')
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-gray-900">Peminjaman</li>
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
                <select name="status" class="form-select form-select-solid w-175px" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                    <option value="terlambat" {{ request('status') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                </select>
            </form>
        </div>
        <div class="card-toolbar">
            <a href="{{ route('admin.borrowings.create') }}" class="btn btn-primary">
                <i class="ki-duotone ki-plus fs-2"></i> Form Peminjaman
            </a>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3" id="kt_datatable">
                <thead>
                    <tr class="fw-bold text-muted">
                        <th>No</th>
                        <th>Barang</th>
                        <th>Peminjam</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Harus Kembali</th>
                        <th>Tgl Dikembalikan</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($borrowings as $b)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <span class="fw-bold">{{ $b->item->name }}</span>
                            <span class="text-muted d-block fs-7">{{ $b->item->code }}</span>
                        </td>
                        <td>{{ $b->user->name }}</td>
                        <td>{{ $b->borrow_date->format('d M Y') }}</td>
                        <td>{{ $b->expected_return_date->format('d M Y') }}</td>
                        <td>{{ $b->actual_return_date?->format('d M Y') ?? '-' }}</td>
                        <td><span class="badge badge-light-{{ $b->status_badge }}">{{ $b->status_label }}</span></td>
                        <td class="text-end">
                            @if($b->status === 'dipinjam')
                            <button class="btn btn-icon btn-light-success btn-sm" data-bs-toggle="modal" data-bs-target="#returnModal{{ $b->id }}" title="Kembalikan">
                                <i class="ki-duotone ki-check-circle fs-4"><span class="path1"></span><span class="path2"></span></i>
                            </button>
                            @endif
                            <a href="{{ route('admin.borrowings.show', $b) }}" class="btn btn-icon btn-light-info btn-sm" title="Detail">
                                <i class="ki-duotone ki-eye fs-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                            </a>
                            @if(auth()->user()->isAdmin())
                            <form action="{{ route('admin.borrowings.destroy', $b) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin menghapus?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-icon btn-light-danger btn-sm" title="Hapus">
                                    <i class="ki-duotone ki-trash fs-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>

                    @if($b->status === 'dipinjam')
                    <div class="modal fade" id="returnModal{{ $b->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('admin.borrowings.return', $b) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title">Pengembalian Barang</h5>
                                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"><i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i></div>
                                    </div>
                                    <div class="modal-body">
                                        <p class="mb-3">Barang: <strong>{{ $b->item->name }}</strong></p>
                                        <p class="mb-4">Peminjam: <strong>{{ $b->user->name }}</strong></p>
                                        <div class="mb-3">
                                            <label class="form-label required">Tanggal Pengembalian</label>
                                            <input type="date" name="actual_return_date" class="form-control" value="{{ date('Y-m-d') }}" required/>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Catatan</label>
                                            <textarea name="notes" class="form-control" rows="2"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-success">
                                            <i class="ki-duotone ki-check fs-2"></i> Konfirmasi Pengembalian
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-10">Belum ada data peminjaman</td>
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
