@extends('layouts.app')
@section('title', 'Monitoring Sarana')
@section('page-title', 'Monitoring Kondisi Barang')

@section('breadcrumb')
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-gray-900">Monitoring</li>
</ul>
@endsection

@push('vendor-css')
<link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
@endpush

@section('content')
<!--begin::Stats-->
<div class="row g-5 g-xl-8 mb-5">
    <div class="col-xl-3 col-md-6">
        <div class="card card-flush h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="fs-2hx fw-bold text-gray-900">{{ $totalBarang }}</div>
                    <div class="fs-6 fw-semibold text-gray-500">Total Barang</div>
                </div>
                <i class="ki-duotone ki-box fs-3x text-primary"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <a href="?condition=baik" class="card card-flush h-100 hoverable">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="fs-2hx fw-bold text-success">{{ $barangBaik }}</div>
                    <div class="fs-6 fw-semibold text-gray-500">Kondisi Baik</div>
                </div>
                <i class="ki-duotone ki-shield-tick fs-3x text-success"><span class="path1"></span><span class="path2"></span></i>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-md-6">
        <a href="?condition=rusak_ringan" class="card card-flush h-100 hoverable">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="fs-2hx fw-bold text-warning">{{ $barangRusakRingan + $barangRusakBerat }}</div>
                    <div class="fs-6 fw-semibold text-gray-500">Rusak</div>
                </div>
                <i class="ki-duotone ki-shield-cross fs-3x text-warning"><span class="path1"></span><span class="path2"></span></i>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-md-6">
        <a href="?condition=hilang" class="card card-flush h-100 hoverable">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="fs-2hx fw-bold text-danger">{{ $barangHilang }}</div>
                    <div class="fs-6 fw-semibold text-gray-500">Hilang</div>
                </div>
                <i class="ki-duotone ki-information-2 fs-3x text-danger"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
            </div>
        </a>
    </div>
</div>
<!--end::Stats-->

<div class="card card-flush">
    <div class="card-header border-0 pt-6">
        <div class="card-title">
            <form method="GET" class="d-flex gap-3">
                <select name="condition" class="form-select form-select-solid w-175px" onchange="this.form.submit()">
                    <option value="">Semua Kondisi</option>
                    <option value="baik" {{ request('condition') == 'baik' ? 'selected' : '' }}>Baik</option>
                    <option value="rusak_ringan" {{ request('condition') == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                    <option value="rusak_berat" {{ request('condition') == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                    <option value="hilang" {{ request('condition') == 'hilang' ? 'selected' : '' }}>Hilang</option>
                </select>
            </form>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3" id="kt_datatable">
                <thead>
                    <tr class="fw-bold text-muted">
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Lokasi</th>
                        <th>Kondisi</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><span class="badge badge-light-info">{{ $item->code }}</span></td>
                        <td class="fw-bold">{{ $item->name }}</td>
                        <td>{{ $item->category->name }}</td>
                        <td>{{ $item->location->name }}</td>
                        <td><span class="badge badge-light-{{ $item->condition_badge }}">{{ $item->condition_label }}</span></td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-light-warning" data-bs-toggle="modal" data-bs-target="#conditionModal{{ $item->id }}">
                                <i class="ki-duotone ki-pencil fs-4"><span class="path1"></span><span class="path2"></span></i> Update Kondisi
                            </button>
                        </td>
                    </tr>

                    <!-- Condition Update Modal -->
                    <div class="modal fade" id="conditionModal{{ $item->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('admin.monitoring.update-condition', $item) }}" method="POST" enctype="multipart/form-data">
                                    @csrf @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title">Update Kondisi: {{ $item->name }}</h5>
                                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"><i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i></div>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-4">
                                            <span class="fw-bold text-muted">Kondisi saat ini:</span>
                                            <span class="badge badge-light-{{ $item->condition_badge }} ms-2">{{ $item->condition_label }}</span>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label required">Kondisi Baru</label>
                                            <select name="condition_after" class="form-select" required>
                                                <option value="baik" {{ $item->condition == 'baik' ? 'selected' : '' }}>Baik</option>
                                                <option value="rusak_ringan" {{ $item->condition == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                                <option value="rusak_berat" {{ $item->condition == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                                                <option value="hilang" {{ $item->condition == 'hilang' ? 'selected' : '' }}>Hilang</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label required">Keterangan</label>
                                            <textarea name="description" class="form-control" rows="3" required placeholder="Jelaskan perubahan kondisi..."></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Foto Bukti</label>
                                            <input type="file" name="photo" class="form-control" accept="image/*"/>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-warning">
                                            <i class="ki-duotone ki-check fs-2"></i> Update Kondisi
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-10">Tidak ada data</td>
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
