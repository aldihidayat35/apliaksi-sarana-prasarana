@extends('layouts.app')
@section('title', 'Laporan Tahunan')
@section('page-title', 'Laporan Tahunan ' . $year)

@section('breadcrumb')
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.reports.index') }}" class="text-muted text-hover-primary">Laporan</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-gray-900">Tahunan</li>
</ul>
@endsection

@push('custom-css')
<style>@media print { .no-print { display: none !important; } .card { border: none !important; box-shadow: none !important; } }</style>
@endpush

@section('content')
<div class="row g-5 g-xl-8 mb-5">
    <div class="col-xl-12 no-print">
        <form method="GET" class="d-flex gap-3 align-items-center">
            <label class="fw-bold">Tahun:</label>
            <select name="year" class="form-select form-select-solid w-125px" onchange="this.form.submit()">
                @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
            <a href="{{ route('admin.reports.annual.pdf', ['year' => $year]) }}" class="btn btn-light-danger btn-sm ms-auto me-2">
                <i class="ki-duotone ki-file-down fs-4"><span class="path1"></span><span class="path2"></span></i> Unduh PDF
            </a>
            <a href="{{ route('admin.reports.annual.excel', ['year' => $year]) }}" class="btn btn-light-success btn-sm me-2">
                <i class="ki-duotone ki-file-down fs-4"><span class="path1"></span><span class="path2"></span></i> Unduh Excel
            </a>
            <button onclick="window.print()" type="button" class="btn btn-light-primary btn-sm">
                <i class="ki-duotone ki-printer fs-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i> Cetak
            </button>
        </form>
    </div>
</div>

<!--begin::Summary-->
<div class="row g-5 g-xl-8 mb-5">
    <div class="col-xl-3 col-md-6"><div class="card card-flush bg-primary h-100"><div class="card-body text-center py-5 d-flex flex-column align-items-center justify-content-center"><div class="fs-2hx fw-bold text-white">{{ $summary['total_items'] }}</div><div class="fs-7 text-white opacity-75">Total Barang</div></div></div></div>
    <div class="col-xl-3 col-md-6"><div class="card card-flush bg-warning h-100"><div class="card-body text-center py-5 d-flex flex-column align-items-center justify-content-center"><div class="fs-2hx fw-bold text-white">{{ $summary['total_borrowings'] }}</div><div class="fs-7 text-white opacity-75">Peminjaman {{ $year }}</div></div></div></div>
    <div class="col-xl-3 col-md-6"><div class="card card-flush bg-danger h-100"><div class="card-body text-center py-5 d-flex flex-column align-items-center justify-content-center"><div class="fs-2hx fw-bold text-white">{{ $summary['total_damages'] }}</div><div class="fs-7 text-white opacity-75">Kerusakan {{ $year }}</div></div></div></div>
    <div class="col-xl-3 col-md-6"><div class="card card-flush bg-success h-100"><div class="card-body text-center py-5 d-flex flex-column align-items-center justify-content-center"><div class="fs-2hx fw-bold text-white" style="font-size: clamp(14px, 2vw, 24px) !important;">Rp {{ number_format($summary['total_value'], 0, ',', '.') }}</div><div class="fs-7 text-white opacity-75">Total Nilai Aset</div></div></div></div>
</div>
<!--end::Summary-->

<!--begin::Chart-->
<div class="card card-flush mb-5">
    <div class="card-header pt-7">
        <h3 class="card-title">Grafik Aktivitas Tahunan {{ $year }}</h3>
    </div>
    <div class="card-body">
        <div id="annual_chart" style="height: 350px;"></div>
    </div>
</div>
<!--end::Chart-->

<!--begin::Monthly Table-->
<div class="card card-flush">
    <div class="card-header">
        <h3 class="card-title">Detail Bulanan</h3>
    </div>
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table table-row-bordered gy-3 table-striped">
                <thead>
                    <tr class="fw-bold text-muted bg-light">
                        <th>Bulan</th>
                        <th class="text-center">Barang Baru</th>
                        <th class="text-center">Peminjaman</th>
                        <th class="text-center">Kerusakan</th>
                    </tr>
                </thead>
                <tbody>
                    @php $months = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']; @endphp
                    @for($m = 1; $m <= 12; $m++)
                    <tr>
                        <td class="fw-bold">{{ $months[$m] }}</td>
                        <td class="text-center">{{ $monthlyItems[$m] }}</td>
                        <td class="text-center">{{ $monthlyBorrowings[$m] }}</td>
                        <td class="text-center">{{ $monthlyDamages[$m] }}</td>
                    </tr>
                    @endfor
                    <tr class="fw-bold bg-light">
                        <td>TOTAL</td>
                        <td class="text-center">{{ array_sum($monthlyItems) }}</td>
                        <td class="text-center">{{ array_sum($monthlyBorrowings) }}</td>
                        <td class="text-center">{{ array_sum($monthlyDamages) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!--end::Monthly Table-->
@endsection

@push('custom-js')
<script>
var annualOptions = {
    series: [
        {
            name: 'Barang Baru',
            data: [@for($m = 1; $m <= 12; $m++){{ $monthlyItems[$m] }}{{ $m < 12 ? ',' : '' }}@endfor]
        },
        {
            name: 'Peminjaman',
            data: [@for($m = 1; $m <= 12; $m++){{ $monthlyBorrowings[$m] }}{{ $m < 12 ? ',' : '' }}@endfor]
        },
        {
            name: 'Kerusakan',
            data: [@for($m = 1; $m <= 12; $m++){{ $monthlyDamages[$m] }}{{ $m < 12 ? ',' : '' }}@endfor]
        }
    ],
    chart: { type: 'bar', height: 350, toolbar: { show: false }, fontFamily: 'inherit' },
    plotOptions: { bar: { borderRadius: 4, columnWidth: '55%' } },
    colors: ['#1B84FF', '#F6C000', '#F8285A'],
    dataLabels: { enabled: false },
    xaxis: {
        categories: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
        labels: { style: { colors: '#A1A5B7', fontSize: '12px' } },
        axisBorder: { show: false }
    },
    yaxis: { labels: { style: { colors: '#A1A5B7', fontSize: '12px' } } },
    grid: { borderColor: '#F1F1F2', strokeDashArray: 4 },
    legend: { position: 'top', fontSize: '13px', labels: { colors: '#A1A5B7' } },
    tooltip: { theme: 'dark' }
};
new ApexCharts(document.querySelector("#annual_chart"), annualOptions).render();
</script>
@endpush
