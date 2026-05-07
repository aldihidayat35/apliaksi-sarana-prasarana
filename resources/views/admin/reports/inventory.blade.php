@extends('layouts.app')
@section('title', 'Laporan Inventaris')
@section('page-title', 'Laporan Inventaris')

@section('breadcrumb')
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.reports.index') }}" class="text-muted text-hover-primary">Laporan</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-gray-900">Inventaris</li>
</ul>
@endsection

@push('custom-css')
<style>
@media print {
    .no-print { display: none !important; }
    .card { border: none !important; box-shadow: none !important; }
}
</style>
@endpush

@section('content')
<!--begin::Summary-->
<div class="row g-5 g-xl-8 mb-5 no-print">
    <div class="col-xl-2 col-md-4"><div class="card card-flush"><div class="card-body text-center py-5"><div class="fs-2hx fw-bold text-primary">{{ $summary['total'] }}</div><div class="fs-7 text-muted">Total Barang</div></div></div></div>
    <div class="col-xl-2 col-md-4"><div class="card card-flush"><div class="card-body text-center py-5"><div class="fs-2hx fw-bold text-success">{{ $summary['baik'] }}</div><div class="fs-7 text-muted">Baik</div></div></div></div>
    <div class="col-xl-2 col-md-4"><div class="card card-flush"><div class="card-body text-center py-5"><div class="fs-2hx fw-bold text-warning">{{ $summary['rusak_ringan'] }}</div><div class="fs-7 text-muted">Rusak Ringan</div></div></div></div>
    <div class="col-xl-2 col-md-4"><div class="card card-flush"><div class="card-body text-center py-5"><div class="fs-2hx fw-bold text-danger">{{ $summary['rusak_berat'] }}</div><div class="fs-7 text-muted">Rusak Berat</div></div></div></div>
    <div class="col-xl-2 col-md-4"><div class="card card-flush"><div class="card-body text-center py-5"><div class="fs-2hx fw-bold text-dark">{{ $summary['hilang'] }}</div><div class="fs-7 text-muted">Hilang</div></div></div></div>
    <div class="col-xl-2 col-md-4"><div class="card card-flush"><div class="card-body text-center py-5"><div class="fs-4 fw-bold text-info">Rp {{ number_format($summary['total_value'], 0, ',', '.') }}</div><div class="fs-7 text-muted">Total Nilai</div></div></div></div>
</div>
<!--end::Summary-->

<!--begin::Charts Row-->
<div class="row g-5 g-xl-8 mb-5 no-print">
    <div class="col-xl-4">
        <div class="card card-flush h-xl-100">
            <div class="card-header pt-7">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">Kondisi Barang</span>
                    <span class="text-gray-500 mt-1 fw-semibold fs-6">Distribusi kondisi inventaris</span>
                </h3>
            </div>
            <div class="card-body pt-5">
                <div id="chart_conditions" style="height: 280px;"></div>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card card-flush h-xl-100">
            <div class="card-header pt-7">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">Per Kategori</span>
                    <span class="text-gray-500 mt-1 fw-semibold fs-6">Jumlah barang tiap kategori</span>
                </h3>
            </div>
            <div class="card-body pt-5">
                <div id="chart_categories" style="height: 280px;"></div>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card card-flush h-xl-100">
            <div class="card-header pt-7">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">Per Lokasi</span>
                    <span class="text-gray-500 mt-1 fw-semibold fs-6">Jumlah barang tiap lokasi</span>
                </h3>
            </div>
            <div class="card-body pt-5">
                <div id="chart_locations" style="height: 280px;"></div>
            </div>
        </div>
    </div>
</div>
<!--end::Charts Row-->

<div class="card card-flush">
    <div class="card-header border-0 pt-6 no-print">
        <div class="card-title">
            <form method="GET" class="d-flex gap-3">
                <select name="category_id" class="form-select form-select-solid w-175px" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                <select name="condition" class="form-select form-select-solid w-175px" onchange="this.form.submit()">
                    <option value="">Semua Kondisi</option>
                    <option value="baik" {{ request('condition') == 'baik' ? 'selected' : '' }}>Baik</option>
                    <option value="rusak_ringan" {{ request('condition') == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                    <option value="rusak_berat" {{ request('condition') == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                    <option value="hilang" {{ request('condition') == 'hilang' ? 'selected' : '' }}>Hilang</option>
                </select>
                <select name="location_id" class="form-select form-select-solid w-175px" onchange="this.form.submit()">
                    <option value="">Semua Lokasi</option>
                    @foreach($locations as $loc)
                        <option value="{{ $loc->id }}" {{ request('location_id') == $loc->id ? 'selected' : '' }}>{{ $loc->name }}</option>
                    @endforeach
                </select>
            </form>
        </div>
        <div class="card-toolbar d-flex gap-2">
            <a href="{{ route('admin.reports.inventory.pdf', request()->all()) }}" class="btn btn-light-danger btn-sm">
                <i class="ki-duotone ki-file-down fs-4"><span class="path1"></span><span class="path2"></span></i> Unduh PDF
            </a>
            <a href="{{ route('admin.reports.inventory.excel', request()->all()) }}" class="btn btn-light-success btn-sm">
                <i class="ki-duotone ki-file-down fs-4"><span class="path1"></span><span class="path2"></span></i> Unduh Excel
            </a>
            <button onclick="window.print()" class="btn btn-light-primary btn-sm">
                <i class="ki-duotone ki-printer fs-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i> Cetak
            </button>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="text-center mb-5" style="display: none;" id="printHeader">
            <h3>{{ app_setting('app_name', 'BRIL-SMART') }}</h3>
            <h4>Laporan Inventaris Barang</h4>
            <p class="text-muted">Dicetak: {{ now()->format('d M Y, H:i') }}</p>
        </div>
        <div class="table-responsive">
            <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3 table-striped">
                <thead>
                    <tr class="fw-bold text-muted bg-light">
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Lokasi</th>
                        <th>Kondisi</th>
                        <th>Qty</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->code }}</td>
                        <td class="fw-bold">{{ $item->name }}</td>
                        <td>{{ $item->category->name }}</td>
                        <td>{{ $item->location->name }}</td>
                        <td><span class="badge badge-light-{{ $item->condition_badge }}">{{ $item->condition_label }}</span></td>
                        <td>{{ $item->quantity }}</td>
                        <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center text-muted py-10">Tidak ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('custom-js')
<script>
// Condition donut chart
new ApexCharts(document.querySelector("#chart_conditions"), {
    series: [{{ $summary['baik'] }}, {{ $summary['rusak_ringan'] }}, {{ $summary['rusak_berat'] }}, {{ $summary['hilang'] }}],
    chart: { type: 'donut', height: 280, fontFamily: 'inherit' },
    labels: ['Baik', 'Rusak Ringan', 'Rusak Berat', 'Hilang'],
    colors: ['#17C653', '#F6C000', '#F8285A', '#7239EA'],
    plotOptions: { pie: { donut: { size: '65%', labels: { show: true, total: { show: true, label: 'Total', fontSize: '14px', fontWeight: 600, color: '#A1A5B7' } } } } },
    dataLabels: { enabled: false },
    legend: { position: 'bottom', fontSize: '12px', labels: { colors: '#A1A5B7' } },
    stroke: { width: 0 },
    tooltip: { theme: 'dark' }
}).render();

// Category bar chart
new ApexCharts(document.querySelector("#chart_categories"), {
    series: [{ name: 'Barang', data: [{!! $categoryChart->map(fn($c) => $c->items_count)->implode(',') !!}] }],
    chart: { type: 'bar', height: 280, toolbar: { show: false }, fontFamily: 'inherit' },
    plotOptions: { bar: { borderRadius: 5, horizontal: true, barHeight: '60%', distributed: true } },
    colors: ['#1B84FF','#17C653','#F6C000','#F8285A','#7239EA','#00B2FF','#FFC700','#FF5733','#36CFC9','#9254DE'],
    dataLabels: { enabled: true, style: { fontSize: '12px' } },
    xaxis: { categories: [{!! $categoryChart->map(fn($c) => "'" . e($c->name) . "'")->implode(',') !!}] },
    legend: { show: false },
    grid: { borderColor: '#F1F1F2', strokeDashArray: 4 },
    tooltip: { theme: 'dark' }
}).render();

// Location bar chart
new ApexCharts(document.querySelector("#chart_locations"), {
    series: [{ name: 'Barang', data: [{!! $locationChart->map(fn($l) => $l->items_count)->implode(',') !!}] }],
    chart: { type: 'bar', height: 280, toolbar: { show: false }, fontFamily: 'inherit' },
    plotOptions: { bar: { borderRadius: 5, horizontal: true, barHeight: '60%', distributed: true } },
    colors: ['#00B2FF','#17C653','#F6C000','#1B84FF','#7239EA','#F8285A','#FFC700','#FF5733','#36CFC9','#9254DE'],
    dataLabels: { enabled: true, style: { fontSize: '12px' } },
    xaxis: { categories: [{!! $locationChart->map(fn($l) => "'" . e($l->name) . "'")->implode(',') !!}] },
    legend: { show: false },
    grid: { borderColor: '#F1F1F2', strokeDashArray: 4 },
    tooltip: { theme: 'dark' }
}).render();
</script>
@endpush

@push('custom-js')
<script>
window.addEventListener('beforeprint', () => document.getElementById('printHeader').style.display = 'block');
window.addEventListener('afterprint', () => document.getElementById('printHeader').style.display = 'none');
</script>
@endpush
