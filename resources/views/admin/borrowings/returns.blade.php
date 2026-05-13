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
{{-- Summary Count Cards --}}
@php
    $totalDipinjam = $borrowings->count();
    $overdueCount = $borrowings->filter(fn($b) => $b->status === 'terlambat' || ($b->expected_return_date && $b->expected_return_date->isPast()))->count();
    $soonCount = $borrowings->filter(fn($b) => $b->status === 'dipinjam' && $b->expected_return_date && !$b->expected_return_date->isPast() && $b->expected_return_date->diffInDays(now()) <= 2)->count();
@endphp
<div class="row g-5 g-xl-8 mb-5">
    <div class="col-md-4">
        <div class="card card-flush" style="border-left: 4px solid #1B84FF;">
            <div class="card-body d-flex align-items-center gap-3 py-4">
                <div class="d-flex flex-center flex-shrink-0 me-3">
                    <span class="fs-2hx fw-bold text-primary">{{ $totalDipinjam }}</span>
                </div>
                <div>
                    <div class="fw-bold text-gray-800 fs-6">Total Dipinjam</div>
                    <span class="text-muted fs-7">Barang yang sedang dipinjam</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-flush" style="border-left: 4px solid #F8285A;">
            <div class="card-body d-flex align-items-center gap-3 py-4">
                <div class="d-flex flex-center flex-shrink-0 me-3">
                    <span class="fs-2hx fw-bold text-danger">{{ $overdueCount }}</span>
                </div>
                <div>
                    <div class="fw-bold text-gray-800 fs-6">Terlambat</div>
                    <span class="text-muted fs-7">Melebihi batas pengembalian</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-flush" style="border-left: 4px solid #F6C000;">
            <div class="card-body d-flex align-items-center gap-3 py-4">
                <div class="d-flex flex-center flex-shrink-0 me-3">
                    <span class="fs-2hx fw-bold text-warning">{{ $soonCount }}</span>
                </div>
                <div>
                    <div class="fw-bold text-gray-800 fs-6">Akan Jatuh Tempo</div>
                    <span class="text-muted fs-7">Maksimal 2 hari lagi</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card card-flush">
    <div class="card-header border-0 pt-6">
        <div class="card-title">
            <form method="GET" class="d-flex gap-3 flex-wrap">
                <input type="text" name="search" class="form-control form-control-solid w-250px" placeholder="Cari nama barang atau peminjam..." value="{{ request('search') }}" />
                <select name="status" class="form-select form-select-solid w-175px">
                    <option value="">Semua Status</option>
                    <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="terlambat" {{ request('status') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                </select>
                <button class="btn btn-primary btn-sm">Filter</button>
            </form>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3" id="kt_datatable">
                <thead>
                    <tr class="fw-bold text-muted bg-light">
                        <th>No</th>
                        <th>Barang</th>
                        <th>Peminjam</th>
                        <th>Tgl Pinjam</th>
                        <th>Harus Kembali</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($borrowings as $b)
                    @php
                        $isOverdue = $b->status === 'terlambat' || ($b->expected_return_date && $b->expected_return_date->isPast());
                        $isSoon = !$isOverdue && $b->expected_return_date && $b->expected_return_date->diffInDays(now()) <= 2;
                    @endphp
                    <tr class="{{ $isOverdue ? 'table-danger' : ($isSoon ? 'table-warning' : '') }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <span class="fw-bold text-gray-900">{{ $b->item->name }}</span>
                            <span class="text-muted d-block fs-7">{{ $b->item->code }}</span>
                        </td>
                        <td>
                            <span class="fw-semibold text-gray-700">{{ $b->user->name }}</span>
                        </td>
                        <td>{{ $b->borrow_date->format('d M Y') }}</td>
                        <td>
                            <span class="fw-semibold {{ $isOverdue ? 'text-danger' : ($isSoon ? 'text-warning' : 'text-gray-700') }}">
                                {{ $b->expected_return_date->format('d M Y') }}
                            </span>
                            @if($isOverdue)
                                <span class="badge badge-danger ms-1 fs-8">+{{ $b->expected_return_date->diffInDays(now()) }} hari</span>
                            @elseif($isSoon)
                                <span class="badge badge-warning ms-1 fs-8">{{ $b->expected_return_date->diffInDays(now()) }} hari lagi</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-light-{{ $isOverdue ? 'danger' : ($isSoon ? 'warning' : 'primary') }}">
                                {{ $isOverdue ? 'Terlambat' : 'Dipinjam' }}
                            </span>
                        </td>
                        <td class="text-end">
                            <button class="btn btn-icon btn-light-success btn-sm" data-bs-toggle="modal" data-bs-target="#returnModal{{ $b->id }}" title="Kembalikan">
                                <i class="ki-duotone ki-check-circle fs-4"><span class="path1"></span><span class="path2"></span></i>
                            </button>
                        </td>
                    </tr>

                    <div class="modal fade" id="returnModal{{ $b->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('admin.borrowings.return', $b) }}" method="POST" enctype="multipart/form-data">
                                    @csrf @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title">Pengembalian Barang</h5>
                                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"><i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i></div>
                                    </div>
                                    <div class="modal-body">
                                        <div class="d-flex gap-3 mb-4 p-3 rounded" style="background: #f8f9fa;">
                                            <div>
                                                <p class="mb-1 fw-bold text-gray-800">{{ $b->item->name }}</p>
                                                <p class="mb-0 text-muted fs-7">{{ $b->item->code }} &bull; {{ $b->user->name }}</p>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label required">Tanggal Pengembalian</label>
                                            <input type="date" name="actual_return_date" class="form-control" value="{{ date('Y-m-d') }}" required/>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label required">Kondisi Saat Dikembalikan</label>
                                            <select name="return_condition" class="form-select" required>
                                                <option value="baik">Baik</option>
                                                <option value="rusak_ringan">Rusak Ringan</option>
                                                <option value="rusak_berat">Rusak Berat</option>
                                                <option value="hilang">Hilang</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Keterangan Tambahan</label>
                                            <textarea name="return_notes" class="form-control" rows="2" placeholder="Contoh: kabel charger hilang, casing lecet"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Upload Foto (jika ada kerusakan)</label>
                                            <input type="file" name="return_photo" class="form-control" accept="image/*"/>
                                            <span class="text-muted fs-8 mt-1">Format: JPG, PNG, maks 2MB</span>
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
                        <td colspan="7" class="text-center text-muted py-10">
                            <i class="ki-duotone ki-check-circle fs-3x mb-2 d-block text-success"></i>
                            Tidak ada barang yang perlu dikembalikan
                        </td>
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
