@extends('layouts.app')
@section('title', 'Laporan Kerusakan')
@section('page-title', 'Laporan Kerusakan')

@section('breadcrumb')
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.reports.index') }}" class="text-muted text-hover-primary">Laporan</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-gray-900">Kerusakan</li>
</ul>
@endsection

@push('custom-css')
<style>@media print { .no-print { display: none !important; } .card { border: none !important; box-shadow: none !important; } }</style>
@endpush

@section('content')
<!--begin::Summary & Chart Row-->
<div class="row g-5 g-xl-8 mb-5 no-print">
    <div class="col-xl-4 col-md-4">
        <div class="card card-flush h-100">
            <div class="card-body d-flex align-items-center justify-content-between py-5">
                <div>
                    <div class="fs-2hx fw-bold text-warning">{{ $damageSummary['rusak_ringan'] }}</div>
                    <div class="fs-6 fw-semibold text-gray-500">Rusak Ringan</div>
                </div>
                <i class="ki-duotone ki-wrench fs-3x text-warning"><span class="path1"></span><span class="path2"></span></i>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-4">
        <div class="card card-flush h-100">
            <div class="card-body d-flex align-items-center justify-content-between py-5">
                <div>
                    <div class="fs-2hx fw-bold text-danger">{{ $damageSummary['rusak_berat'] }}</div>
                    <div class="fs-6 fw-semibold text-gray-500">Rusak Berat</div>
                </div>
                <i class="ki-duotone ki-shield-cross fs-3x text-danger"><span class="path1"></span><span class="path2"></span></i>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-4">
        <div class="card card-flush h-100">
            <div class="card-body d-flex align-items-center justify-content-between py-5">
                <div>
                    <div class="fs-2hx fw-bold text-dark">{{ $damageSummary['hilang'] }}</div>
                    <div class="fs-6 fw-semibold text-gray-500">Hilang</div>
                </div>
                <i class="ki-duotone ki-information-2 fs-3x text-dark"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-5 g-xl-8 mb-5 no-print">
    <div class="col-xl-12">
        <div class="card card-flush">
            <div class="card-header pt-7">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">Distribusi Jenis Kerusakan</span>
                    <span class="text-gray-500 mt-1 fw-semibold fs-6">Perbandingan laporan berdasarkan kondisi</span>
                </h3>
            </div>
            <div class="card-body pt-5">
                <div id="chart_damage" style="height: 250px;"></div>
            </div>
        </div>
    </div>
</div>
<!--end::Summary & Chart Row-->
<div class="card card-flush">
    <div class="card-header border-0 pt-6 no-print">
        <div class="card-title">
            <form method="GET" class="d-flex gap-3">
                <input type="date" name="date_from" class="form-control form-control-solid w-175px" value="{{ request('date_from') }}">
                <input type="date" name="date_to" class="form-control form-control-solid w-175px" value="{{ request('date_to') }}">
                <button class="btn btn-primary btn-sm">Filter</button>
            </form>
        </div>
        <div class="card-toolbar d-flex gap-2">
            <a href="{{ route('admin.reports.damage.pdf', request()->all()) }}" class="btn btn-light-danger btn-sm">
                <i class="ki-duotone ki-file-down fs-4"><span class="path1"></span><span class="path2"></span></i> Unduh PDF
            </a>
            <a href="{{ route('admin.reports.damage.excel', request()->all()) }}" class="btn btn-light-success btn-sm">
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
                        <th>Tanggal</th>
                        <th>Barang</th>
                        <th>Kondisi Sebelum</th>
                        <th>Kondisi Sesudah</th>
                        <th>Keterangan</th>
                        <th>Pelapor</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $r)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $r->report_date->format('d M Y') }}</td>
                        <td class="fw-bold">{{ $r->item->name }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $r->condition_before)) }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $r->condition_after)) }}</td>
                        <td>{{ Str::limit($r->description, 60) }}</td>
                        <td>{{ $r->reportedByUser->name }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-muted py-10">Tidak ada data kerusakan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('custom-js')
<script>
new ApexCharts(document.querySelector("#chart_damage"), {
    series: [
        {
            name: 'Rusak Ringan',
            data: [@for($m=1;$m<=12;$m++){{ $monthlyDamage['rusak_ringan'][$m] }}{{ $m<12?',':'' }}@endfor]
        },
        {
            name: 'Rusak Berat',
            data: [@for($m=1;$m<=12;$m++){{ $monthlyDamage['rusak_berat'][$m] }}{{ $m<12?',':'' }}@endfor]
        },
        {
            name: 'Hilang',
            data: [@for($m=1;$m<=12;$m++){{ $monthlyDamage['hilang'][$m] }}{{ $m<12?',':'' }}@endfor]
        }
    ],
    chart: { type: 'line', height: 250, toolbar: { show: false }, fontFamily: 'inherit' },
    stroke: { curve: 'smooth', width: 3 },
    colors: ['#F6C000', '#F8285A', '#7239EA'],
    markers: { size: 4 },
    xaxis: {
        categories: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
        labels: { style: { colors: '#A1A5B7', fontSize: '12px' } }
    },
    yaxis: {
        labels: { style: { colors: '#A1A5B7', fontSize: '12px' } },
        min: 0,
        tickAmount: 4
    },
    legend: { position: 'bottom', fontSize: '13px', labels: { colors: '#A1A5B7' } },
    grid: { borderColor: '#F1F1F2', strokeDashArray: 4 },
    tooltip: { theme: 'dark' }
}).render();
</script>
@endpush
