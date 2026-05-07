@extends('layouts.app')
@section('title', 'Pengembalian Barang')
@section('page-title', 'Form Pengembalian Barang')

@section('breadcrumb')
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.borrowings.index') }}" class="text-muted text-hover-primary">Peminjaman</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-gray-900">Pengembalian</li>
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
                <input type="text" name="search" class="form-control form-control-solid w-250px" placeholder="Cari nama barang..." value="{{ request('search') }}" />
                <button class="btn btn-primary btn-sm">Cari</button>
            </form>
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
                        <th>Harus Kembali</th>
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
                        <td class="text-end">
                            <button class="btn btn-icon btn-light-success btn-sm" data-bs-toggle="modal" data-bs-target="#returnModal{{ $b->id }}" title="Kembalikan">
                                <i class="ki-duotone ki-check-circle fs-4"><span class="path1"></span><span class="path2"></span></i>
                            </button>
                        </td>
                    </tr>

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
                                            <label class="form-label required">Kondisi Saat Dikembalikan</label>
                                            <select name="return_condition" class="form-select" required>
                                                <option value="baik" {{ $b->item->condition === 'baik' ? 'selected' : '' }}>Baik</option>
                                                <option value="rusak_ringan" {{ $b->item->condition === 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                                <option value="rusak_berat" {{ $b->item->condition === 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                                                <option value="hilang" {{ $b->item->condition === 'hilang' ? 'selected' : '' }}>Hilang</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Keterangan Tambahan</label>
                                            <textarea name="return_notes" class="form-control" rows="2" placeholder="Contoh: kabel charger hilang, casing lecet"></textarea>
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
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-10">Tidak ada barang yang perlu dikembalikan</td>
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
