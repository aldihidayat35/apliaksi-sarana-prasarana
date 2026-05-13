@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard BRIL-SMART')

@section('breadcrumb')
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
    <li class="breadcrumb-item text-muted">
        <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Home</a>
    </li>
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-300 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-gray-900">Dashboard</li>
</ul>
@endsection

@section('content')
<!--begin::Stats Row-->
<div class="row g-5 g-xl-8 mb-5 mb-xl-8">
    <div class="col-xl-3 col-md-6">
        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: #1B84FF; background-image: url('assets/media/svg/shapes/wave-bg-blue.svg')">
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
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: #F6C000; background-image: url('assets/media/svg/shapes/wave-bg-warning.svg')">
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
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: #F8285A; background-image: url('assets/media/svg/shapes/wave-bg-red.svg')">
            <div class="card-header pt-5 pb-0 border-0">
                <h3 class="card-title align-items-start flex-column">
                    <span class="fw-bold text-white fs-2x">{{ $barangRusak }}</span>
                    <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Barang Rusak</span>
                </h3>
            </div>
            <div class="card-body d-flex align-items-end pt-0 pb-5">
                <div class="d-flex align-items-center">
                    <i class="ki-duotone ki-shield-cross text-white fs-3x opacity-75"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: #7239EA; background-image: url('assets/media/svg/shapes/wave-bg-purple.svg')">
            <div class="card-header pt-5 pb-0 border-0">
                <h3 class="card-title align-items-start flex-column">
                    <span class="fw-bold text-white fs-2x">{{ $barangHilang }}</span>
                    <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Barang Hilang</span>
                </h3>
            </div>
            <div class="card-body d-flex align-items-end pt-0 pb-5">
                <div class="d-flex align-items-center">
                    <i class="ki-duotone ki-information-2 text-white fs-3x opacity-75"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end::Stats Row-->

<!--begin::Quick Reports Row-->
<div class="row g-5 g-xl-8 mb-5 mb-xl-8">
    <div class="col-xl-6">
        <a href="{{ route('admin.reports.damage-location') }}" class="card card-flush hoverable h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="fw-bold fs-3 text-gray-900">Kerusakan per Lokasi</div>
                    <div class="text-muted fs-7">Lihat ruangan dengan kerusakan terbanyak</div>
                </div>
                <i class="ki-duotone ki-map fs-3x text-primary"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
            </div>
        </a>
    </div>
    <div class="col-xl-6">
        <a href="{{ route('admin.reports.priority') }}" class="card card-flush hoverable h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="fw-bold fs-3 text-gray-900">Prioritas Pengadaan</div>
                    <div class="text-muted fs-7">Rekomendasi barang yang perlu diprioritaskan</div>
                </div>
                <i class="ki-duotone ki-chart-simple fs-3x text-success"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
            </div>
        </a>
    </div>
</div>
<!--end::Quick Reports Row-->

<!--begin::Charts Row-->
<div class="row g-5 g-xl-8 mb-5 mb-xl-8">
    <!--begin::Chart - Peminjaman Bulanan-->
    <div class="col-xl-8">
        <div class="card card-flush h-xl-100">
            <div class="card-header pt-7">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">Grafik Peminjaman {{ date('Y') }}</span>
                    <span class="text-gray-500 mt-1 fw-semibold fs-6">Statistik peminjaman barang per bulan</span>
                </h3>
            </div>
            <div class="card-body pt-5">
                <div id="chart_borrowings" style="height: 300px;"></div>
            </div>
        </div>
    </div>
    <!--end::Chart-->

    <!--begin::Chart - Kondisi Barang + Kerusakan per Lokasi stacked (side by side on xl)-->
    <div class="col-xl-4">
        <div class="card card-flush h-xl-100 mb-5 mb-xl-0">
            <div class="card-header pt-7">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">Kondisi Barang</span>
                    <span class="text-gray-500 mt-1 fw-semibold fs-6">Distribusi kondisi sarana</span>
                </h3>
            </div>
            <div class="card-body pt-5">
                <div id="chart_conditions" style="height: 250px;"></div>
            </div>
        </div>
    </div>
</div>
<!--end::Charts Row-->

<!--begin::Kerusakan Per Lokasi + Prioritas Row-->
<div class="row g-5 g-xl-8 mb-5 mb-xl-8">
    <!--begin::Kerusakan per Lokasi Chart-->
    <div class="col-xl-6">
        <div class="card card-flush h-xl-100">
            <div class="card-header pt-7">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">Kerusakan Per Lokasi</span>
                    <span class="text-gray-500 mt-1 fw-semibold fs-6">Distribusi kerusakan per ruangan</span>
                </h3>
                <a href="{{ route('admin.reports.damage-location') }}" class="btn btn-sm btn-light-primary">Selengkapnya</a>
            </div>
            <div class="card-body pt-5">
                @if($damageByLocation->count())
                    <div id="chart_damage_location" style="height: 280px;"></div>
                @else
                    <div class="text-center text-muted py-15">
                        <i class="ki-duotone ki-shield-check fs-3x mb-3 text-success"></i>
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
                <a href="{{ route('admin.reports.priority') }}" class="btn btn-sm btn-light-success">Selengkapnya</a>
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
                                    <td>
                                        <span class="text-muted fw-semibold">{{ $item->location->name ?? '-' }}</span>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $score = $item->priority_score;
                                            $badge = $score >= 60 ? 'danger' : ($score >= 30 ? 'warning' : 'primary');
                                        @endphp
                                        <span class="badge badge-light-{{ $badge }} fs-7">{{ $score }}%</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center text-muted py-15">
                        <i class="ki-duotone ki-check-circle fs-3x mb-3 text-success"></i>
                        <p class="mb-0">Semua barang dalam kondisi baik.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!--end::Prioritas Pengadaan-->
</div>
<!--end::Kerusakan + Prioritas Row-->

<!--begin::Tables Row-->
<div class="row g-5 g-xl-8">
    <!--begin::Recent Borrowings-->
    <div class="col-xl-7">
        <div class="card card-flush h-xl-100">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Peminjaman Terbaru</span>
                    <span class="text-muted mt-1 fw-semibold fs-7">{{ $barangDipinjam }} barang sedang dipinjam</span>
                </h3>
                @if(auth()->user()->isAdmin() || auth()->user()->isGuru())
                <div class="card-toolbar">
                    <a href="{{ route('admin.borrowings.create') }}" class="btn btn-sm btn-light-primary">
                        <i class="ki-duotone ki-plus fs-2"></i> Pinjam Baru
                    </a>
                </div>
                @endif
            </div>
            <div class="card-body py-3">
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                        <thead>
                            <tr class="fw-bold text-muted">
                                <th>Barang</th>
                                <th>Peminjam</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentBorrowings as $b)
                            <tr>
                                <td>
                                    <span class="text-gray-900 fw-bold d-block fs-6">{{ $b->item->name ?? '-' }}</span>
                                    <span class="text-muted fw-semibold d-block fs-7">{{ $b->item->code ?? '' }}</span>
                                </td>
                                <td><span class="text-muted fw-semibold">{{ $b->user->name ?? '-' }}</span></td>
                                <td><span class="text-muted fw-semibold">{{ $b->borrow_date->format('d M Y') }}</span></td>
                                <td><span class="badge badge-light-{{ $b->status_badge }}">{{ $b->status_label }}</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-10">Belum ada data peminjaman</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--end::Recent Borrowings-->

    <!--begin::Activity Log-->
    <div class="col-xl-5">
        <div class="card card-flush h-xl-100">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Aktivitas Terbaru</span>
                    <span class="text-muted mt-1 fw-semibold fs-7">Log aktivitas sistem</span>
                </h3>
            </div>
            <div class="card-body pt-5">
                <div class="timeline-label">
                    @forelse($recentActivities as $activity)
                    <div class="timeline-item mb-7">
                        <div class="timeline-label fw-bold text-gray-800 fs-7" style="min-width: 70px;">
                            {{ $activity->created_at->format('H:i') }}
                        </div>
                        <div class="timeline-badge">
                            <i class="fa fa-circle text-{{ match($activity->type) {
                                'item_created' => 'success',
                                'item_deleted' => 'danger',
                                'borrowing_created' => 'primary',
                                'borrowing_returned' => 'info',
                                'condition_updated' => 'warning',
                                'registration_created' => 'success',
                                default => 'secondary',
                            } }} fs-9"></i>
                        </div>
                        <div class="fw-semibold text-gray-700 ps-3 fs-7">
                            {{ $activity->description }}
                            <span class="text-muted d-block fs-8">oleh {{ $activity->user->name ?? 'System' }} &mdash; {{ $activity->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-10">Belum ada aktivitas</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <!--end::Activity Log-->
</div>
<!--end::Tables Row-->
@endsection

@push('custom-js')
<script>
// Borrowings Line Chart (ApexCharts)
var borrowOptions = {
    series: [{
        name: 'Peminjaman',
        data: [
            @for($m = 1; $m <= 12; $m++)
                {{ $monthlyBorrowings[$m] }}{{ $m < 12 ? ',' : '' }}
            @endfor
        ]
    }],
    chart: { type: 'line', height: 300, toolbar: { show: false }, fontFamily: 'inherit' },
    stroke: { curve: 'smooth', width: 3 },
    colors: ['#0EA5E9'],
    markers: { size: 5, colors: ['#0EA5E9'], strokeColors: '#fff', strokeWidth: 2 },
    dataLabels: { enabled: false },
    legend: { show: false },
    xaxis: {
        categories: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
        labels: { style: { colors: '#A1A5B7', fontSize: '12px' } },
        axisBorder: { show: false }
    },
    yaxis: {
        labels: { style: { colors: '#A1A5B7', fontSize: '12px' } },
        min: 0,
        tickAmount: 4
    },
    fill: {
        type: 'gradient',
        gradient: { shade: 'light', type: 'vertical', shadeIntensity: 0.3, opacityFrom: 0.4, opacityTo: 0.05 }
    },
    grid: { borderColor: '#F1F1F2', strokeDashArray: 4 },
    tooltip: { theme: 'dark' }
};
new ApexCharts(document.querySelector("#chart_borrowings"), borrowOptions).render();

// Conditions Donut Chart (ApexCharts)
var condOptions = {
    series: [{{ $barangBaik }}, {{ $barangRusak }}, {{ $barangHilang }}],
    chart: { type: 'donut', height: 300, fontFamily: 'inherit' },
    labels: ['Baik', 'Rusak', 'Hilang'],
    colors: ['#17C653', '#F6C000', '#F8285A'],
    plotOptions: {
        pie: {
            donut: {
                size: '65%',
                labels: {
                    show: true,
                    total: {
                        show: true,
                        label: 'Total',
                        fontSize: '14px',
                        fontWeight: 600,
                        color: '#A1A5B7'
                    }
                }
            }
        }
    },
    dataLabels: { enabled: false },
    legend: { position: 'bottom', fontSize: '13px', labels: { colors: '#A1A5B7' } },
    stroke: { width: 0 },
    tooltip: { theme: 'dark' }
};
new ApexCharts(document.querySelector("#chart_conditions"), condOptions).render();

// Damage Per Location Bar Chart (ApexCharts)
var damageLabels = {!! json_encode($locationChartLabels) !!};
var damageCounts = {!! json_encode($locationChartCounts) !!};

if (damageLabels.length > 0) {
    var damageOptions = {
        series: [{ name: 'Jumlah Kerusakan', data: damageCounts }],
        chart: { type: 'bar', height: 280, toolbar: { show: false }, fontFamily: 'inherit' },
        colors: ['#F8285A'],
        plotOptions: {
            bar: { borderRadius: 6, horizontal: false, columnWidth: '40%', distributed: true }
        },
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
