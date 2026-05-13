@extends('layouts.app')
@section('title', 'Kerusakan per Lokasi')
@section('page-title', 'Kerusakan per Lokasi')

@section('breadcrumb')
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
    <li class="breadcrumb-item text-muted"><a href="{{ route('guru.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-gray-900">Kerusakan per Lokasi</li>
</ul>
@endsection

@section('content')
{{-- Summary Cards --}}
<div class="row g-5 g-xl-8 mb-5">
    <div class="col-xl-3 col-md-6">
        <div class="card card-flush">
            <div class="card-body text-center py-5">
                <div class="fs-2hx fw-bold text-primary">{{ $summary['total'] }}</div>
                <div class="fs-7 text-muted fw-semibold mt-1">Total Laporan</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card card-flush">
            <div class="card-body text-center py-5">
                <div class="fs-2hx fw-bold text-warning">{{ $summary['rusak_ringan'] }}</div>
                <div class="fs-7 text-muted fw-semibold mt-1">Rusak Ringan</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card card-flush">
            <div class="card-body text-center py-5">
                <div class="fs-2hx fw-bold text-danger">{{ $summary['rusak_berat'] }}</div>
                <div class="fs-7 text-muted fw-semibold mt-1">Rusak Berat</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card card-flush">
            <div class="card-body text-center py-5">
                <div class="fs-2hx fw-bold" style="color:#7239EA;">{{ $summary['hilang'] }}</div>
                <div class="fs-7 text-muted fw-semibold mt-1">Hilang</div>
            </div>
        </div>
    </div>
</div>

{{-- Chart Row --}}
<div class="row g-5 g-xl-8 mb-5">
    <div class="col-xl-7">
        <div class="card card-flush h-xl-100">
            <div class="card-header pt-7">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">Grafik Kerusakan per Lokasi</span>
                </h3>
            </div>
            <div class="card-body pt-5">
                @if($locationChartLabels->count())
                    <div id="chart_kerusakan" style="height: 280px;"></div>
                @else
                    <div class="text-center text-muted py-15">Tidak ada data kerusakan.</div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-xl-5">
        <div class="card card-flush h-xl-100">
            <div class="card-header pt-7">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">Ringkasan per Ruangan</span>
                </h3>
            </div>
            <div class="card-body pt-5">
                @forelse($reports->groupBy(fn($r) => $r->item->location->name ?? 'Tanpa Lokasi') as $location => $items)
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <i class="ki-duotone ki-map text-muted fs-5"></i>
                        <span class="fw-semibold text-gray-700">{{ $location }}</span>
                    </div>
                    <span class="badge badge-light-danger">{{ $items->count() }} laporan</span>
                </div>
                @empty
                <div class="text-center text-muted py-5">Belum ada laporan kerusakan.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="card card-flush">
    <div class="card-header border-0 pt-6">
        <div class="card-title">
            <form method="GET" class="d-flex gap-3">
                <select name="location_id" class="form-select form-select-solid w-200px">
                    <option value="">Semua Lokasi</option>
                    @foreach($locations as $loc)
                        <option value="{{ $loc->id }}" {{ request('location_id') == $loc->id ? 'selected' : '' }}>{{ $loc->name }}</option>
                    @endforeach
                </select>
                <button class="btn btn-primary btn-sm">Filter</button>
            </form>
        </div>
        <div class="card-toolbar">
            <a href="{{ route('guru.reports.kerusakan-lokasi.excel') }}" class="btn btn-light-success btn-sm">
                <i class="ki-duotone ki-file-down fs-4"><span class="path1"></span><span class="path2"></span></i> Unduh Excel
            </a>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                <thead>
                    <tr class="fw-bold text-muted bg-light">
                        <th>No</th>
                        <th>Barang</th>
                        <th>Lokasi</th>
                        <th>Tanggal Laporan</th>
                        <th>Kondisi</th>
                        <th>Pelapor</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $r)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-bold text-gray-900">{{ $r->item->name ?? '-' }}</td>
                        <td class="text-muted">{{ $r->item->location->name ?? '-' }}</td>
                        <td class="text-muted">{{ $r->report_date->format('d M Y') }}</td>
                        <td>
                            @php
                                $badge = match($r->condition_after) {
                                    'rusak_ringan' => 'warning',
                                    'rusak_berat' => 'danger',
                                    'hilang' => 'primary',
                                    default => 'secondary'
                                };
                            @endphp
                            <span class="badge badge-light-{{ $badge }}">{{ ucfirst(str_replace('_', ' ', $r->condition_after)) }}</span>
                        </td>
                        <td class="text-muted">{{ $r->reportedByUser->name ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-10">Tidak ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('custom-js')
<script>
var locLabels = {!! json_encode($locationChartLabels) !!};
var locCounts = {!! json_encode($locationChartCounts) !!};
if (locLabels.length > 0) {
    new ApexCharts(document.querySelector("#chart_kerusakan"), {
        series: [{ name: 'Jumlah Laporan', data: locCounts }],
        chart: { type: 'bar', height: 280, toolbar: { show: false }, fontFamily: 'inherit' },
        colors: ['#F8285A'],
        plotOptions: { bar: { borderRadius: 6, horizontal: true, barHeight: '60%', distributed: true } },
        dataLabels: { enabled: false },
        legend: { show: false },
        xaxis: {
            labels: { style: { colors: '#A1A5B7', fontSize: '12px' }, min: 0, tickAmount: 4 },
            axisBorder: { show: false }
        },
        yaxis: { labels: { style: { colors: '#A1A5B7', fontSize: '12px' } } },
        fill: { opacity: 0.9 },
        grid: { borderColor: '#F1F1F2', strokeDashArray: 4 },
        tooltip: { theme: 'dark', x: { show: false } }
    }).render();
}
</script>
@endpush