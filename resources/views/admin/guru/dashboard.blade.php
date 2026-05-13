@extends('layouts.app')
@section('title', 'Dashboard Guru')
@section('page-title', 'Dashboard Guru')

@section('breadcrumb')
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
    <li class="breadcrumb-item text-muted">
        <a href="{{ route('guru.dashboard') }}" class="text-muted text-hover-primary">Home</a>
    </li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-gray-900">Dashboard</li>
</ul>
@endsection

@section('content')
<!--begin::Stats Row-->
<div class="row g-5 g-xl-8 mb-5 mb-xl-8">
    <div class="col-xl-4 col-md-4">
        <a href="{{ route('guru.inventaris') }}" class="card card-flush h-xl-100 text-decoration-none" style="background-color: #1B84FF; background-image: url('assets/media/svg/shapes/wave-bg-blue.svg');">
            <div class="card-header pt-5 pb-0 border-0">
                <h3 class="card-title align-items-start flex-column">
                    <span class="fw-bold text-white fs-2x">{{ $totalBarang }}</span>
                    <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Total Barang</span>
                </h3>
            </div>
            <div class="card-body d-flex align-items-end pt-0 pb-5">
                <div class="d-flex align-items-center">
                    <i class="ki-duotone ki-box text-white fs-3x opacity-75"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                </div>
            </div>
        </a>
    </div>

    <div class="col-xl-4 col-md-4">
        <a href="{{ route('guru.inventaris.dipinjam') }}" class="card card-flush h-xl-100 text-decoration-none" style="background-color: #F6C000; background-image: url('assets/media/svg/shapes/wave-bg-warning.svg');">
            <div class="card-header pt-5 pb-0 border-0">
                <h3 class="card-title align-items-start flex-column">
                    <span class="fw-bold text-white fs-2x">{{ $barangDipinjam }}</span>
                    <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Barang Dipinjam</span>
                </h3>
            </div>
            <div class="card-body d-flex align-items-end pt-0 pb-5">
                <div class="d-flex align-items-center">
                    <i class="ki-duotone ki-handcart text-white fs-3x opacity-75"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
        </a>
    </div>

    <div class="col-xl-4 col-md-4">
        <a href="{{ route('guru.inventaris.ready') }}" class="card card-flush h-xl-100 text-decoration-none" style="background-color: #17C653; background-image: url('assets/media/svg/shapes/wave-bg-green.svg');">
            <div class="card-header pt-5 pb-0 border-0">
                <h3 class="card-title align-items-start flex-column">
                    <span class="fw-bold text-white fs-2x">{{ $barangReady }}</span>
                    <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Barang Ready</span>
                </h3>
            </div>
            <div class="card-body d-flex align-items-end pt-0 pb-5">
                <div class="d-flex align-items-center">
                    <i class="ki-duotone ki-check-circle text-white fs-3x opacity-75"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
        </a>
    </div>
</div>
<!--end::Stats Row-->

<!--begin::Quick Actions Row for Guru - Tombol Pengembalian + Laporan + Kerusakan + Prioritas-->
<div class="row g-5 g-xl-8 mb-5 mb-xl-8">
    <div class="col-xl-3 col-md-6">
        <a href="{{ route('admin.borrowings.returns') }}" class="card card-flush hoverable h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="fw-bold fs-3 text-gray-900">Pengembalian Barang</div>
                    <div class="text-muted fs-7">Kembalikan barang yang dipinjam</div>
                </div>
                <i class="ki-duotone ki-arrows-circle ki-timer text-success fs-3x"><span class="path1"></span><span class="path2"></span></i>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-md-6">
        <a href="{{ route('guru.reports.kerusakan-lokasi') }}" class="card card-flush hoverable h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="fw-bold fs-3 text-gray-900">Kerusakan per Lokasi</div>
                    <div class="text-muted fs-7">Lihat kerusakan per ruangan</div>
                </div>
                <i class="ki-duotone ki-map fs-3x text-primary"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-md-6">
        <a href="{{ route('guru.reports.kondisi') }}" class="card card-flush hoverable h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="fw-bold fs-3 text-gray-900">Laporan Kondisi</div>
                    <div class="text-muted fs-7">Kondisi seluruh barang</div>
                </div>
                <i class="ki-duotone ki-chart-simple fs-3x text-warning"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-md-6">
        <a href="{{ route('guru.reports.prioritas') }}" class="card card-flush hoverable h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="fw-bold fs-3 text-gray-900">Prioritas Pengadaan</div>
                    <div class="text-muted fs-7">Rekomendasi pengadaan</div>
                </div>
                <i class="ki-duotone ki-chart-line-up fs-3x text-danger"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
            </div>
        </a>
    </div>
</div>
<!--end::Quick Actions Row-->

<!--begin::Charts + Summary Row-->
<div class="row g-5 g-xl-8 mb-5 mb-xl-8">
    <!--begin::Kerusakan per Lokasi Chart-->
    <div class="col-xl-6">
        <div class="card card-flush h-xl-100">
            <div class="card-header pt-7">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">Kerusakan Per Lokasi</span>
                    <span class="text-gray-500 mt-1 fw-semibold fs-6">Distribusi kerusakan per ruangan</span>
                </h3>
                <a href="{{ route('guru.reports.kerusakan-lokasi') }}" class="btn btn-sm btn-light-primary">Selengkapnya</a>
            </div>
            <div class="card-body pt-5">
                @if($damageByLocation->count())
                    <div id="chart_damage_location" style="height: 280px;"></div>
                @else
                    <div class="text-center text-muted py-15">
                        <i class="ki-duotone ki-shield-check fs-3x mb-3 d-block text-success"></i>
                        <p class="mb-0">Belum ada data kerusakan.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!--end::Kerusakan per Lokasi-->

    <!--begin::Prioritas Pengadaan Panel-->
    <div class="col-xl-6">
        <div class="card card-flush h-xl-100">
            <div class="card-header pt-7">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">Prioritas Pengadaan</span>
                    <span class="text-gray-500 mt-1 fw-semibold fs-6">Barang yang perlu diprioritaskan (Top 5)</span>
                </h3>
                <a href="{{ route('guru.reports.prioritas') }}" class="btn btn-sm btn-light-success">Selengkapnya</a>
            </div>
            <div class="card-body pt-0">
                @if($priorityItems->count())
                    <div class="table-responsive">
                        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-3">
                            <thead>
                                <tr class="fw-bold text-muted fs-7">
                                    <th>#</th>
                                    <th>Barang</th>
                                    <th>Lokasi</th>
                                    <th class="text-center">Skor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($priorityItems as $item)
                                <tr>
                                    <td class="text-muted fw-semibold">{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="text-gray-900 fw-bold d-block fs-6">{{ $item->name }}</span>
                                        <span class="text-muted fw-semibold d-block fs-8">{{ $item->category->name ?? '-' }}</span>
                                    </td>
                                    <td class="text-muted fw-semibold">{{ $item->location->name ?? '-' }}</td>
                                    <td class="text-center">
                                        @php $score = $item->priority_score; @endphp
                                        <span class="badge badge-light-{{ $score >= 60 ? 'danger' : ($score >= 30 ? 'warning' : 'primary') }}">{{ $score }}%</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center text-muted py-15">
                        <i class="ki-duotone ki-check-circle fs-3x mb-3 d-block text-success"></i>
                        <p class="mb-0">Semua barang dalam kondisi baik.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<!--end::Charts Row-->

<!--begin::Summary Cards Row - Kondisi Barang-->
<div class="row g-5 g-xl-8 mb-5 mb-xl-8">
    <div class="col-xl-2 col-md-4">
        <a href="{{ route('guru.reports.kondisi') }}" class="card card-flush h-xl-100 text-decoration-none">
            <div class="card-body text-center py-5">
                <div class="fs-2hx fw-bold text-primary">{{ $summary['total'] }}</div>
                <div class="fs-7 text-muted fw-semibold mt-1">Total Barang</div>
            </div>
        </a>
    </div>
    <div class="col-xl-2 col-md-4">
        <a href="{{ route('guru.reports.kondisi', ['condition' => 'baik']) }}" class="card card-flush h-xl-100 text-decoration-none">
            <div class="card-body text-center py-5">
                <div class="fs-2hx fw-bold text-success">{{ $summary['baik'] }}</div>
                <div class="fs-7 text-muted fw-semibold mt-1">Baik</div>
            </div>
        </a>
    </div>
    <div class="col-xl-2 col-md-4">
        <a href="{{ route('guru.reports.kondisi', ['condition' => 'rusak_ringan']) }}" class="card card-flush h-xl-100 text-decoration-none">
            <div class="card-body text-center py-5">
                <div class="fs-2hx fw-bold text-warning">{{ $summary['rusak_ringan'] }}</div>
                <div class="fs-7 text-muted fw-semibold mt-1">Rusak Ringan</div>
            </div>
        </a>
    </div>
    <div class="col-xl-2 col-md-4">
        <a href="{{ route('guru.reports.kondisi', ['condition' => 'rusak_berat']) }}" class="card card-flush h-xl-100 text-decoration-none">
            <div class="card-body text-center py-5">
                <div class="fs-2hx fw-bold text-danger">{{ $summary['rusak_berat'] }}</div>
                <div class="fs-7 text-muted fw-semibold mt-1">Rusak Berat</div>
            </div>
        </a>
    </div>
    <div class="col-xl-2 col-md-4">
        <a href="{{ route('guru.reports.kondisi', ['condition' => 'hilang']) }}" class="card card-flush h-xl-100 text-decoration-none">
            <div class="card-body text-center py-5">
                <div class="fs-2hx fw-bold" style="color:#7239EA;">{{ $summary['hilang'] }}</div>
                <div class="fs-7 text-muted fw-semibold mt-1">Hilang</div>
            </div>
        </a>
    </div>
    <div class="col-xl-2 col-md-4">
        <a href="{{ route('guru.reports.prioritas') }}" class="card card-flush h-xl-100 text-decoration-none">
            <div class="card-body text-center py-5">
                <div class="fs-2hx fw-bold text-primary">{{ $priorityItems->count() }}</div>
                <div class="fs-7 text-muted fw-semibold mt-1">Prioritas</div>
            </div>
        </a>
    </div>
</div>

<!--begin::My Borrowings Row-->
<div class="row g-5 g-xl-8">
    <div class="col-xl-12">
        <div class="card card-flush h-xl-100">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Barang Yang Saya Pinjam</span>
                    <span class="text-muted mt-1 fw-semibold fs-7">{{ $barangDipinjam }} barang sedang dipinjam</span>
                </h3>
                <div class="card-toolbar">
                    <a href="{{ route('admin.borrowings.returns') }}" class="btn btn-sm btn-light-success">
                        <i class="ki-duotone ki-check-circle fs-2"></i> Kembalikan
                    </a>
                </div>
            </div>
            <div class="card-body py-3">
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                        <thead>
                            <tr class="fw-bold text-muted">
                                <th>Barang</th>
                                <th>Lokasi</th>
                                <th>Tanggal Pinjam</th>
                                <th>Harus Kembali</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($myBorrowings as $b)
                            @php $isOverdue = $b->status === 'terlambat' || ($b->expected_return_date && $b->expected_return_date->isPast()); @endphp
                            <tr class="{{ $isOverdue ? 'table-danger' : '' }}">
                                <td>
                                    <span class="text-gray-900 fw-bold d-block fs-6">{{ $b->item->name ?? '-' }}</span>
                                    <span class="text-muted fw-semibold d-block fs-7">{{ $b->item->code ?? '' }}</span>
                                </td>
                                <td class="text-muted fw-semibold">{{ $b->item->location->name ?? '-' }}</td>
                                <td class="text-muted fw-semibold">{{ $b->borrow_date->format('d M Y') }}</td>
                                <td>
                                    <span class="fw-semibold {{ $isOverdue ? 'text-danger' : 'text-gray-700' }}">
                                        {{ $b->expected_return_date->format('d M Y') }}
                                    </span>
                                    @if($isOverdue)
                                        <span class="badge badge-danger ms-1">{{ $b->expected_return_date->diffInDays(now()) }} hari</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-light-{{ $isOverdue ? 'danger' : 'primary' }}">
                                        {{ $isOverdue ? 'Terlambat' : 'Dipinjam' }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-10">Tidak ada barang yang sedang dipinjam.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('custom-js')
<script>
// Damage Per Location Bar Chart (ApexCharts)
var damageLabels = {!! json_encode($locationChartLabels) !!};
var damageCounts = {!! json_encode($locationChartCounts) !!};

if (damageLabels.length > 0) {
    var damageOptions = {
        series: [{ name: 'Jumlah Kerusakan', data: damageCounts }],
        chart: { type: 'bar', height: 280, toolbar: { show: false }, fontFamily: 'inherit' },
        colors: ['#F8285A'],
        plotOptions: { bar: { borderRadius: 6, horizontal: false, columnWidth: '40%', distributed: true } },
        dataLabels: { enabled: false },
        legend: { show: false },
        xaxis: {
            categories: damageLabels,
            labels: { style: { colors: '#A1A5B7', fontSize: '12px' } },
            axisBorder: { show: false }
        },
        yaxis: {
            labels: { style: { colors: '#A1A5B7', fontSize: '12px' }, min: 0 },
            tickAmount: 4
        },
        fill: { opacity: 0.9 },
        grid: { borderColor: '#F1F1F2', strokeDashArray: 4 },
        tooltip: { theme: 'dark', y: { formatter: val => val + ' item' } }
    };
    new ApexCharts(document.querySelector("#chart_damage_location"), damageOptions).render();
}
</script>
@endpush
