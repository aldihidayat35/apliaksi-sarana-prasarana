@extends('layouts.app')
@section('title', 'Laporan Kondisi Barang')
@section('page-title', 'Laporan Kondisi Barang')

@section('breadcrumb')
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.reports.index') }}" class="text-muted text-hover-primary">Laporan</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-gray-900">Kondisi Barang</li>
</ul>
@endsection

@push('custom-css')
<style>@media print { .no-print { display: none !important; } .card { border: none !important; box-shadow: none !important; } }</style>
@endpush

@section('content')
{{-- Summary Cards --}}
<div class="row g-5 g-xl-8 mb-5 no-print">
    <div class="col-xl-3 col-md-6">
        <div class="card card-flush">
            <div class="card-body text-center py-5">
                <div class="fs-2hx fw-bold text-primary">{{ $summary['total'] }}</div>
                <div class="fs-7 text-muted fw-semibold mt-1">Total Barang</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card card-flush">
            <div class="card-body text-center py-5">
                <div class="fs-2hx fw-bold text-success">{{ $summary['baik'] }}</div>
                <div class="fs-7 text-muted fw-semibold mt-1">Baik</div>
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
                <div class="fs-2hx fw-bold text-danger">{{ $summary['rusak_berat'] + $summary['hilang'] }}</div>
                <div class="fs-7 text-muted fw-semibold mt-1">Rusak Berat + Hilang</div>
            </div>
        </div>
    </div>
</div>

{{-- Chart Row --}}
<div class="row g-5 g-xl-8 mb-5 no-print">
    <div class="col-xl-8">
        <div class="card card-flush h-xl-100">
            <div class="card-header pt-7">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">Distribusi Kondisi Barang</span>
                    <span class="text-gray-500 mt-1 fw-semibold fs-6">Grafik perbandingan kondisi sarana</span>
                </h3>
            </div>
            <div class="card-body pt-5">
                <div id="condition_chart" style="height: 280px;"></div>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card card-flush h-xl-100">
            <div class="card-header pt-7">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">Ringkasan</span>
                </h3>
            </div>
            <div class="card-body d-flex align-items-center">
                <div class="w-100">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <span class="w-8px h-8px rounded-circle" style="background:#17C653"></span>
                            <span class="fw-semibold text-gray-700">Baik</span>
                        </div>
                        <span class="fw-bold text-gray-900">{{ $summary['baik'] }}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <span class="w-8px h-8px rounded-circle" style="background:#F6C000"></span>
                            <span class="fw-semibold text-gray-700">Rusak Ringan</span>
                        </div>
                        <span class="fw-bold text-gray-900">{{ $summary['rusak_ringan'] }}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <span class="w-8px h-8px rounded-circle" style="background:#F8285A"></span>
                            <span class="fw-semibold text-gray-700">Rusak Berat</span>
                        </div>
                        <span class="fw-bold text-gray-900">{{ $summary['rusak_berat'] }}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <span class="w-8px h-8px rounded-circle" style="background:#7239EA"></span>
                            <span class="fw-semibold text-gray-700">Hilang</span>
                        </div>
                        <span class="fw-bold text-gray-900">{{ $summary['hilang'] }}</span>
                    </div>
                    <div class="separator my-4"></div>
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="fw-bold text-gray-900">Total</span>
                        <span class="fw-bold fs-5 text-primary">{{ $summary['total'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card card-flush">
    <div class="card-header border-0 pt-6 no-print">
        <div class="card-title">
            <form method="GET" class="d-flex gap-3 flex-wrap">
                <select name="condition" class="form-select form-select-solid w-175px">
                    <option value="">Semua Kondisi</option>
                    <option value="baik" {{ request('condition') == 'baik' ? 'selected' : '' }}>Baik</option>
                    <option value="rusak_ringan" {{ request('condition') == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                    <option value="rusak_berat" {{ request('condition') == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                    <option value="hilang" {{ request('condition') == 'hilang' ? 'selected' : '' }}>Hilang</option>
                </select>
                <select name="category_id" class="form-select form-select-solid w-200px">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                <select name="location_id" class="form-select form-select-solid w-200px">
                    <option value="">Semua Lokasi</option>
                    @foreach($locations as $loc)
                        <option value="{{ $loc->id }}" {{ request('location_id') == $loc->id ? 'selected' : '' }}>{{ $loc->name }}</option>
                    @endforeach
                </select>
                <button class="btn btn-primary btn-sm">Filter</button>
                @if(request()->hasAny(['condition', 'category_id', 'location_id']))
                    <a href="{{ route('admin.reports.condition') }}" class="btn btn-light-danger btn-sm">Reset</a>
                @endif
            </form>
        </div>
        <div class="card-toolbar d-flex gap-2">
            <a href="{{ route('admin.reports.condition.pdf', request()->all()) }}" class="btn btn-light-danger btn-sm">
                <i class="ki-duotone ki-file-down fs-4"><span class="path1"></span><span class="path2"></span></i> PDF
            </a>
            <a href="{{ route('admin.reports.condition.excel', request()->all()) }}" class="btn btn-light-success btn-sm">
                <i class="ki-duotone ki-file-down fs-4"><span class="path1"></span><span class="path2"></span></i> Excel
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
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Kondisi</th>
                        <th>Lokasi</th>
                        <th>Kategori</th>
                        <th>Qty</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-muted fw-semibold">{{ $item->code }}</td>
                        <td class="fw-bold text-gray-900">{{ $item->name }}</td>
                        <td><span class="badge badge-light-{{ $item->condition_badge }}">{{ $item->condition_label }}</span></td>
                        <td class="text-muted">{{ $item->location->name ?? '-' }}</td>
                        <td class="text-muted">{{ $item->category->name ?? '-' }}</td>
                        <td class="fw-semibold text-center">{{ $item->quantity }}</td>
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
var condChartOptions = {
    series: [{{ $summary['baik'] }}, {{ $summary['rusak_ringan'] }}, {{ $summary['rusak_berat'] }}, {{ $summary['hilang'] }}],
    chart: { type: 'bar', height: 280, toolbar: { show: false }, fontFamily: 'inherit' },
    colors: ['#17C653', '#F6C000', '#F8285A', '#7239EA'],
    plotOptions: {
        bar: { borderRadius: 6, horizontal: false, columnWidth: '35%', distributed: true }
    },
    dataLabels: { enabled: false },
    legend: { show: false },
    xaxis: {
        categories: ['Baik', 'Rusak Ringan', 'Rusak Berat', 'Hilang'],
        labels: { style: { colors: '#A1A5B7', fontSize: '12px', fontWeight: 600 } },
        axisBorder: { show: false }
    },
    yaxis: {
        labels: { style: { colors: '#A1A5B7', fontSize: '12px' }, min: 0 },
        tickAmount: 5
    },
    fill: { opacity: 0.9 },
    grid: { borderColor: '#F1F1F2', strokeDashArray: 4 },
    tooltip: { theme: 'dark' }
};
new ApexCharts(document.querySelector("#condition_chart"), condChartOptions).render();
</script>
@endpush
