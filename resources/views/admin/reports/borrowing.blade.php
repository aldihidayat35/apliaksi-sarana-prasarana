@extends('layouts.app')
@section('title', 'Laporan Peminjaman')
@section('page-title', 'Laporan Peminjaman')

@section('breadcrumb')
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.reports.index') }}" class="text-muted text-hover-primary">Laporan</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-gray-900">Peminjaman</li>
</ul>
@endsection

@push('custom-css')
<style>@media print { .no-print { display: none !important; } .card { border: none !important; box-shadow: none !important; } }</style>
@endpush

@section('content')
<div class="row g-5 g-xl-8 mb-5 no-print">
    <div class="col-xl-3 col-md-6"><div class="card card-flush"><div class="card-body text-center py-5"><div class="fs-2hx fw-bold text-primary">{{ $summary['total'] }}</div><div class="fs-7 text-muted">Total Peminjaman</div></div></div></div>
    <div class="col-xl-3 col-md-6"><div class="card card-flush"><div class="card-body text-center py-5"><div class="fs-2hx fw-bold text-warning">{{ $summary['dipinjam'] }}</div><div class="fs-7 text-muted">Dipinjam</div></div></div></div>
    <div class="col-xl-3 col-md-6"><div class="card card-flush"><div class="card-body text-center py-5"><div class="fs-2hx fw-bold text-success">{{ $summary['dikembalikan'] }}</div><div class="fs-7 text-muted">Dikembalikan</div></div></div></div>
    <div class="col-xl-3 col-md-6"><div class="card card-flush"><div class="card-body text-center py-5"><div class="fs-2hx fw-bold text-danger">{{ $summary['terlambat'] }}</div><div class="fs-7 text-muted">Terlambat</div></div></div></div>
</div>

<!--begin::Charts Row-->
<div class="row g-5 g-xl-8 mb-5 no-print">
    <div class="col-xl-8">
        <div class="card card-flush h-xl-100">
            <div class="card-header pt-7">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">Tren Peminjaman {{ date('Y') }}</span>
                    <span class="text-gray-500 mt-1 fw-semibold fs-6">Perbandingan peminjaman vs pengembalian per bulan</span>
                </h3>
            </div>
            <div class="card-body pt-5">
                <div id="chart_borrow_trend" style="height: 300px;"></div>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card card-flush h-xl-100">
            <div class="card-header pt-7">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">Status Peminjaman</span>
                    <span class="text-gray-500 mt-1 fw-semibold fs-6">Distribusi status saat ini</span>
                </h3>
            </div>
            <div class="card-body pt-5">
                <div id="chart_borrow_status" style="height: 300px;"></div>
            </div>
        </div>
    </div>
</div>
<!--end::Charts Row-->

<div class="card card-flush">
    <div class="card-header border-0 pt-6 no-print">
        <div class="card-title">
            <form method="GET" class="d-flex gap-3">
                <select name="status" class="form-select form-select-solid w-175px" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                    <option value="terlambat" {{ request('status') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                </select>
                <input type="date" name="date_from" class="form-control form-control-solid w-175px" value="{{ request('date_from') }}" placeholder="Dari">
                <input type="date" name="date_to" class="form-control form-control-solid w-175px" value="{{ request('date_to') }}" placeholder="Sampai">
                <button class="btn btn-primary btn-sm">Filter</button>
            </form>
        </div>
        <div class="card-toolbar d-flex gap-2">
            <a href="{{ route('admin.reports.borrowing.pdf', request()->all()) }}" class="btn btn-light-danger btn-sm">
                <i class="ki-duotone ki-file-down fs-4"><span class="path1"></span><span class="path2"></span></i> Unduh PDF
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
                        <th>Barang</th>
                        <th>Peminjam</th>
                        <th>Tgl Pinjam</th>
                        <th>Harus Kembali</th>
                        <th>Dikembalikan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($borrowings as $b)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-bold">{{ $b->item->name }}</td>
                        <td>{{ $b->user->name }}</td>
                        <td>{{ $b->borrow_date->format('d M Y') }}</td>
                        <td>{{ $b->expected_return_date->format('d M Y') }}</td>
                        <td>{{ $b->actual_return_date?->format('d M Y') ?? '-' }}</td>
                        <td><span class="badge badge-light-{{ $b->status_badge }}">{{ $b->status_label }}</span></td>
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
// Borrowing trend area chart
new ApexCharts(document.querySelector("#chart_borrow_trend"), {
    series: [
        { name: 'Peminjaman', data: [@for($m=1;$m<=12;$m++){{ $monthlyBorrow[$m] }}{{ $m<12?',':'' }}@endfor] },
        { name: 'Dikembalikan', data: [@for($m=1;$m<=12;$m++){{ $monthlyReturn[$m] }}{{ $m<12?',':'' }}@endfor] }
    ],
    chart: { type: 'area', height: 300, toolbar: { show: false }, fontFamily: 'inherit' },
    colors: ['#1B84FF', '#17C653'],
    dataLabels: { enabled: false },
    stroke: { curve: 'smooth', width: 2 },
    fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.1 } },
    xaxis: { categories: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'], labels: { style: { colors: '#A1A5B7', fontSize: '12px' } } },
    yaxis: { labels: { style: { colors: '#A1A5B7', fontSize: '12px' } } },
    grid: { borderColor: '#F1F1F2', strokeDashArray: 4 },
    legend: { position: 'top', fontSize: '13px', labels: { colors: '#A1A5B7' } },
    tooltip: { theme: 'dark' }
}).render();

// Borrowing status radial chart
new ApexCharts(document.querySelector("#chart_borrow_status"), {
    series: [{{ $summary['dipinjam'] }}, {{ $summary['dikembalikan'] }}, {{ $summary['terlambat'] }}],
    chart: { type: 'donut', height: 300, fontFamily: 'inherit' },
    labels: ['Dipinjam', 'Dikembalikan', 'Terlambat'],
    colors: ['#F6C000', '#17C653', '#F8285A'],
    plotOptions: { pie: { donut: { size: '65%', labels: { show: true, total: { show: true, label: 'Total', fontSize: '14px', fontWeight: 600, color: '#A1A5B7' } } } } },
    dataLabels: { enabled: false },
    legend: { position: 'bottom', fontSize: '12px', labels: { colors: '#A1A5B7' } },
    stroke: { width: 0 },
    tooltip: { theme: 'dark' }
}).render();
</script>
@endpush
