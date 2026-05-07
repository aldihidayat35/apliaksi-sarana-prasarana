@extends('layouts.app')
@section('title', 'Analisis Prioritas Pengadaan')
@section('page-title', 'Analisis Prioritas Kebutuhan Barang')

@section('breadcrumb')
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.reports.index') }}" class="text-muted text-hover-primary">Laporan</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-gray-900">Prioritas Pengadaan</li>
</ul>
@endsection

@section('content')
<div class="row g-5 g-xl-8 mb-5">
    <div class="col-xl-8">
        <div class="card card-flush h-100">
            <div class="card-header pt-7">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">Skala Prioritas Barang</span>
                    <span class="text-gray-500 mt-1 fw-semibold fs-6">Skor dihitung dari kerusakan, frekuensi, dan penggunaan</span>
                </h3>
                <div class="card-toolbar">
                    <form method="GET">
                        <select name="months" class="form-select form-select-solid" onchange="this.form.submit()">
                            <option value="6" {{ $months == 6 ? 'selected' : '' }}>6 Bulan Terakhir</option>
                            <option value="12" {{ $months == 12 ? 'selected' : '' }}>12 Bulan Terakhir</option>
                            <option value="24" {{ $months == 24 ? 'selected' : '' }}>24 Bulan Terakhir</option>
                        </select>
                    </form>
                </div>
            </div>
            <div class="card-body pt-5">
                <div id="chart_priority" style="height: 320px;"></div>
                <div class="text-muted fs-7 mt-4">
                    Bobot: kerusakan {{ $weights['damage'] * 100 }}%, frekuensi {{ $weights['frequency'] * 100 }}%, penggunaan {{ $weights['usage'] * 100 }}%.
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card card-flush h-100">
            <div class="card-header pt-7">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">Rekomendasi Pengadaan</span>
                    <span class="text-gray-500 mt-1 fw-semibold fs-6">Top 5 prioritas tertinggi</span>
                </h3>
            </div>
            <div class="card-body pt-5">
                @forelse($recommendations as $item)
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <div class="fw-bold text-gray-900">{{ $item->name }}</div>
                        <div class="text-muted fs-7">{{ $item->location->name ?? '-' }} • {{ $item->category->name ?? '-' }}</div>
                    </div>
                    <span class="badge badge-light-warning">{{ $item->priority_score }}</span>
                </div>
                @empty
                <div class="text-muted">Belum ada data prioritas.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="card card-flush">
    <div class="card-header">
        <h3 class="card-title">Detail Skor Prioritas</h3>
    </div>
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3 table-striped">
                <thead>
                    <tr class="fw-bold text-muted bg-light">
                        <th>Barang</th>
                        <th>Lokasi</th>
                        <th>Kerusakan Total</th>
                        <th>Kerusakan {{ $months }} Bulan</th>
                        <th>Peminjaman {{ $months }} Bulan</th>
                        <th>Skor</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rankedItems as $item)
                    <tr>
                        <td class="fw-bold">{{ $item->name }}</td>
                        <td>{{ $item->location->name ?? '-' }}</td>
                        <td>{{ $item->damage_total }}</td>
                        <td>{{ $item->damage_recent }}</td>
                        <td>{{ $item->usage_recent }}</td>
                        <td><span class="badge badge-light-primary">{{ $item->priority_score }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-10">Tidak ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('custom-js')
<script>
new ApexCharts(document.querySelector("#chart_priority"), {
    series: [{
        name: 'Skor Prioritas',
        data: @json($chartScores)
    }],
    chart: { type: 'bar', height: 320, toolbar: { show: false }, fontFamily: 'inherit' },
    plotOptions: { bar: { borderRadius: 6, horizontal: true, barHeight: '65%' } },
    colors: ['#0F766E'],
    dataLabels: { enabled: true, style: { fontSize: '12px' } },
    xaxis: {
        categories: @json($chartLabels),
        labels: { style: { colors: '#A1A5B7', fontSize: '12px' } }
    },
    grid: { borderColor: '#F1F1F2', strokeDashArray: 4 },
    tooltip: { theme: 'dark' }
}).render();
</script>
@endpush
