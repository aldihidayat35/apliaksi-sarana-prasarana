@extends('layouts.app')
@section('title', 'Prioritas Pengadaan')
@section('page-title', 'Prioritas Pengadaan')

@section('breadcrumb')
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
    <li class="breadcrumb-item text-muted"><a href="{{ route('guru.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-gray-900">Prioritas Pengadaan</li>
</ul>
@endsection

@section('content')
{{-- Info --}}
<div class="card card-flush mb-5">
    <div class="card-body d-flex flex-wrap gap-5 align-items-center">
        <div>
            <h3 class="fw-bold text-gray-800 mb-1">Sistem Skoring Prioritas</h3>
            <p class="text-muted mb-0">Barang diurutkan berdasarkan weighted scoring:</p>
        </div>
        <div class="d-flex gap-3 flex-wrap">
            <span class="badge badge-danger fs-7">Kerusakan 60%</span>
            <span class="badge badge-warning fs-7">Frekuensi 25%</span>
            <span class="badge badge-primary fs-7">Penggunaan 15%</span>
        </div>
        <form method="GET" class="ms-auto d-flex gap-2">
            <select name="months" class="form-select form-select-solid w-175px" onchange="this.form.submit()">
                <option value="6" {{ $months == 6 ? 'selected' : '' }}>6 Bulan Terakhir</option>
                <option value="12" {{ $months == 12 ? 'selected' : '' }}>12 Bulan Terakhir</option>
                <option value="24" {{ $months == 24 ? 'selected' : '' }}>24 Bulan Terakhir</option>
            </select>
        </form>
    </div>
</div>

{{-- Chart + Summary Row --}}
<div class="row g-5 g-xl-8 mb-5">
    <div class="col-xl-7">
        <div class="card card-flush h-xl-100">
            <div class="card-header pt-7">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">Skor Prioritas - Top 10 Barang</span>
                </h3>
            </div>
            <div class="card-body pt-5">
                @if($chartLabels->count())
                    <div id="chart_prioritas" style="height: 320px;"></div>
                @else
                    <div class="text-center text-muted py-15">Tidak ada data.</div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-xl-5">
        <div class="card card-flush h-xl-100">
            <div class="card-header pt-7">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">Rekomendasi Pengadaan</span>
                </h3>
            </div>
            <div class="card-body pt-5">
                @forelse($rankedItems->take(5) as $item)
                @php
                    $score = $item->priority_score;
                    $badge = $score >= 60 ? 'danger' : ($score >= 30 ? 'warning' : 'success');
                    $label = $score >= 60 ? 'Kritis' : ($score >= 30 ? 'Sedang' : 'Rendah');
                @endphp
                <div class="d-flex align-items-center justify-content-between mb-4 pb-3 {{ !$loop->last ? 'border-bottom border-gray-200' : '' }}">
                    <div class="d-flex align-items-center gap-3">
                        <span class="fs-2hx fw-bold text-muted opacity-25">{{ $loop->iteration }}</span>
                        <div>
                            <span class="fw-bold text-gray-900 d-block">{{ $item->name }}</span>
                            <span class="text-muted fs-7">{{ $item->location->name ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="text-end">
                        <span class="badge badge-light-{{ $badge }}">{{ $score }}%</span>
                        <span class="badge badge-light-{{ $badge }} mt-1">{{ $label }}</span>
                    </div>
                </div>
                @empty
                <div class="text-center text-muted py-5">Tidak ada data.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="card card-flush">
    <div class="card-header border-0 pt-6">
        <div class="card-title">
            <span class="fw-bold text-gray-800">Daftar Lengkap Prioritas ({{ $rankedItems->count() }} barang)</span>
        </div>
        <div class="card-toolbar">
            <a href="{{ route('guru.reports.prioritas.excel', ['months' => $months]) }}" class="btn btn-light-success btn-sm">
                <i class="ki-duotone ki-file-down fs-4"><span class="path1"></span><span class="path2"></span></i> Unduh Excel
            </a>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                <thead>
                    <tr class="fw-bold text-muted bg-light">
                        <th>Peringkat</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Lokasi</th>
                        <th>Kondisi</th>
                        <th class="text-center">Skor (%)</th>
                        <th class="text-center">Total Kerusakan</th>
                        <th class="text-center">Frekuensi</th>
                        <th class="text-center">Penggunaan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rankedItems as $item)
                    @php
                        $score = $item->priority_score;
                        $badge = $score >= 60 ? 'danger' : ($score >= 30 ? 'warning' : 'primary');
                    @endphp
                    <tr>
                        <td>
                            <span class="fw-bold text-muted">{{ $loop->iteration }}</span>
                        </td>
                        <td class="fw-bold text-gray-900">{{ $item->name }}</td>
                        <td class="text-muted">{{ $item->category->name ?? '-' }}</td>
                        <td class="text-muted">{{ $item->location->name ?? '-' }}</td>
                        <td>
                            <span class="badge badge-light-{{ $item->condition_badge }}">{{ $item->condition_label }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-light-{{ $badge }} fs-7">{{ $score }}%</span>
                        </td>
                        <td class="text-center text-muted">{{ $item->damage_total }}</td>
                        <td class="text-center text-muted">{{ $item->damage_recent }}</td>
                        <td class="text-center text-muted">{{ $item->usage_recent }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="9" class="text-center text-muted py-10">Tidak ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('custom-js')
<script>
var labels = {!! json_encode($chartLabels) !!};
var scores = {!! json_encode($chartScores) !!};
if (labels.length > 0) {
    new ApexCharts(document.querySelector("#chart_prioritas"), {
        series: [{ name: 'Skor Prioritas', data: scores }],
        chart: { type: 'bar', height: 320, toolbar: { show: false }, fontFamily: 'inherit' },
        colors: ['#F8285A'],
        plotOptions: { bar: { borderRadius: 4, horizontal: true, barHeight: '70%', distributed: true } },
        dataLabels: { enabled: false },
        legend: { show: false },
        xaxis: {
            labels: { style: { colors: '#A1A5B7', fontSize: '12px' }, min: 0, max: 100 },
            axisBorder: { show: false }
        },
        yaxis: {
            labels: { style: { colors: '#A1A5B7', fontSize: '12px' } }
        },
        fill: { opacity: 0.9 },
        grid: { borderColor: '#F1F1F2', strokeDashArray: 4 },
        tooltip: { theme: 'dark', x: { show: false } }
    }).render();
}
</script>
@endpush