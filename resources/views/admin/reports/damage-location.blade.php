@extends('layouts.app')
@section('title', 'Laporan Kerusakan per Lokasi')
@section('page-title', 'Laporan Kerusakan per Lokasi')

@section('breadcrumb')
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.reports.index') }}" class="text-muted text-hover-primary">Laporan</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-gray-900">Kerusakan per Lokasi</li>
</ul>
@endsection

@push('custom-css')
<style>@media print { .no-print { display: none !important; } .card { border: none !important; box-shadow: none !important; } }</style>
@endpush

@section('content')
<div class="row g-5 g-xl-8 mb-5 no-print">
    <div class="col-xl-6 col-md-6">
        <div class="card card-flush h-100">
            <div class="card-body d-flex align-items-center justify-content-between py-5">
                <div>
                    <div class="fs-2hx fw-bold text-danger">{{ $summary['total_reports'] }}</div>
                    <div class="fs-6 fw-semibold text-gray-500">Total Laporan Kerusakan</div>
                </div>
                <i class="ki-duotone ki-shield-cross fs-3x text-danger"><span class="path1"></span><span class="path2"></span></i>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-6">
        <div class="card card-flush h-100">
            <div class="card-body d-flex align-items-center justify-content-between py-5">
                <div>
                    <div class="fs-2hx fw-bold text-primary">{{ $summary['total_locations'] }}</div>
                    <div class="fs-6 fw-semibold text-gray-500">Lokasi Terdeteksi</div>
                </div>
                <i class="ki-duotone ki-map fs-3x text-primary"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
            </div>
        </div>
    </div>
</div>

<div class="card card-flush mb-5 no-print">
    <div class="card-header pt-7">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold text-gray-800">Distribusi Kerusakan per Lokasi</span>
            <span class="text-gray-500 mt-1 fw-semibold fs-6">Ringkasan lokasi dengan kerusakan terbanyak</span>
        </h3>
    </div>
    <div class="card-body pt-5">
        <div id="chart_damage_location" style="height: 300px;"></div>
    </div>
</div>

<div class="card card-flush">
    <div class="card-header border-0 pt-6 no-print">
        <div class="card-title">
            <form method="GET" class="d-flex gap-3 flex-wrap">
                <select name="location_id" class="form-select form-select-solid w-200px">
                    <option value="">Semua Lokasi</option>
                    @foreach($locations as $loc)
                        <option value="{{ $loc->id }}" {{ request('location_id') == $loc->id ? 'selected' : '' }}>{{ $loc->name }}</option>
                    @endforeach
                </select>
                <select name="condition_after" class="form-select form-select-solid w-200px">
                    <option value="">Semua Kondisi</option>
                    <option value="rusak_ringan" {{ request('condition_after') == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                    <option value="rusak_berat" {{ request('condition_after') == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                    <option value="hilang" {{ request('condition_after') == 'hilang' ? 'selected' : '' }}>Hilang</option>
                </select>
                <input type="date" name="date_from" class="form-control form-control-solid w-175px" value="{{ request('date_from') }}" placeholder="Dari">
                <input type="date" name="date_to" class="form-control form-control-solid w-175px" value="{{ request('date_to') }}" placeholder="Sampai">
                <button class="btn btn-primary btn-sm">Filter</button>
            </form>
        </div>
        <div class="card-toolbar d-flex gap-2">
            <a href="{{ route('admin.reports.damage-location.pdf', request()->all()) }}" class="btn btn-light-danger btn-sm">
                <i class="ki-duotone ki-file-down fs-4"><span class="path1"></span><span class="path2"></span></i> Unduh PDF
            </a>
            <a href="{{ route('admin.reports.damage-location.excel', request()->all()) }}" class="btn btn-light-success btn-sm">
                <i class="ki-duotone ki-file-down fs-4"><span class="path1"></span><span class="path2"></span></i> Unduh Excel
            </a>
            <button onclick="window.print()" class="btn btn-light-primary btn-sm">
                <i class="ki-duotone ki-printer fs-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i> Cetak
            </button>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3 table-striped">
                <thead>
                    <tr class="fw-bold text-muted bg-light">
                        <th>No</th>
                        <th>Lokasi</th>
                        <th>Barang</th>
                        <th>Tanggal</th>
                        <th>Kondisi Sesudah</th>
                        <th>Keterangan</th>
                        <th>Pelapor</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $r)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $r->item->location->name ?? '-' }}</td>
                        <td class="fw-bold">{{ $r->item->name }}</td>
                        <td>{{ $r->report_date->format('d M Y') }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $r->condition_after)) }}</td>
                        <td>{{ Str::limit($r->description, 60) }}</td>
                        <td>{{ $r->reportedByUser->name }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-muted py-10">Tidak ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('custom-js')
<script>
new ApexCharts(document.querySelector("#chart_damage_location"), {
    series: [{
        name: 'Jumlah Kerusakan',
        data: @json($locationChartCounts)
    }],
    chart: { type: 'bar', height: 300, toolbar: { show: false }, fontFamily: 'inherit' },
    plotOptions: { bar: { borderRadius: 6, horizontal: true, barHeight: '65%' } },
    colors: ['#0EA5E9'],
    dataLabels: { enabled: true, style: { fontSize: '12px' } },
    xaxis: {
        categories: @json($locationChartLabels),
        labels: { style: { colors: '#A1A5B7', fontSize: '12px' } }
    },
    grid: { borderColor: '#F1F1F2', strokeDashArray: 4 },
    tooltip: { theme: 'dark' }
}).render();
</script>
@endpush
