@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard BRIL-SMART')

@section('breadcrumb')
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
    <li class="breadcrumb-item text-gray-500">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-500 text-hover-primary">Home</a>
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
                    <div class="text-gray-500 fs-7">Lihat ruangan dengan kerusakan terbanyak</div>
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
                    <div class="text-gray-500 fs-7">Rekomendasi barang yang perlu diprioritaskan</div>
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
                    <div class="text-center text-gray-500 py-15">
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
                                <tr class="fw-bold text-gray-500 fs-7">
                                    <th>#</th>
                                    <th>Barang</th>
                                    <th>Lokasi</th>
                                    <th class="text-center">Skor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($priorityItems as $item)
                                <tr>
                                    <td class="text-gray-500 fw-semibold">{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="text-gray-900 fw-bold d-block fs-6">{{ $item->name }}</span>
                                        <span class="text-gray-500 fw-semibold d-block fs-8">{{ $item->category->name ?? '-' }}</span>
                                    </td>
                                    <td>
                                        <span class="text-gray-500 fw-semibold">{{ $item->location->name ?? '-' }}</span>
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
                    <div class="text-center text-gray-500 py-15">
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
                    <span class="text-gray-500 mt-1 fw-semibold fs-7">{{ $barangDipinjam }} barang sedang dipinjam</span>
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
                            <tr class="fw-bold text-gray-500">
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
                                    <span class="text-gray-500 fw-semibold d-block fs-7">{{ $b->item->code ?? '' }}</span>
                                </td>
                                <td><span class="text-gray-500 fw-semibold">{{ $b->user->name ?? '-' }}</span></td>
                                <td><span class="text-gray-500 fw-semibold">{{ $b->borrow_date->format('d M Y') }}</span></td>
                                <td><span class="badge badge-light-{{ $b->status_badge }}">{{ $b->status_label }}</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-gray-500 py-10">Belum ada data peminjaman</td>
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
                    <span class="text-gray-500 mt-1 fw-semibold fs-7">Log aktivitas sistem</span>
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
                            <span class="text-gray-500 d-block fs-8">oleh {{ $activity->user->name ?? 'System' }} &mdash; {{ $activity->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-gray-500 py-10">Belum ada aktivitas</div>
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
// ===== BORROWINGS AREA CHART - Vibrant Gradient =====
new ApexCharts(document.querySelector("#chart_borrowings"), {
    series: [{
        name: 'Peminjaman',
        data: [
            @for($m = 1; $m <= 12; $m++)
                {{ $monthlyBorrowings[$m] }}{{ $m < 12 ? ',' : '' }}
            @endfor
        ]
    }],
    chart: {
        type: 'area',
        height: 320,
        fontFamily: 'inherit',
        toolbar: { show: false },
        zoom: { enabled: false },
        sparkline: { enabled: false },
    },
    colors: ['#6366F1', '#06B6D4'],
    stroke: { curve: 'smooth', width: 3 },
    fill: {
        type: 'gradient',
        gradient: {
            shadeIntensity: 1,
            opacityFrom: 0.55,
            opacityTo: 0.05,
            stops: [0, 95, 100],
            colorStops: [
                { offset: 0, color: '#6366F1', opacity: 0.55 },
                { offset: 100, color: '#06B6D4', opacity: 0.05 }
            ]
        },
    },
    markers: {
        size: 5,
        strokeWidth: 2,
        strokeColors: '#fff',
        hover: { size: 7 },
    },
    dataLabels: {
        enabled: true,
        style: { fontSize: '11px', fontWeight: 700, colors: ['#fff'] },
        background: { borderRadius: 6, padding: 4 },
        dropShadow: { enabled: false }
    },
    legend: { show: false },
    xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
        labels: {
            style: { colors: '#8892B0', fontSize: '12px', fontWeight: 600 },
            offsetY: -5,
        },
        axisBorder: { show: false },
        axisTicks: { show: false },
        crosshairs: { show: true, stroke: { color: '#6366F1', width: 1, dashArray: 3 } }
    },
    yaxis: {
        labels: {
            style: { colors: '#8892B0', fontSize: '12px' },
            formatter: val => Math.round(val),
            offsetX: -10,
        },
        min: 0,
        tickAmount: 5,
    },
    grid: {
        borderColor: '#E2E8F0',
        strokeDashArray: 5,
        xaxis: { lines: { show: false } },
        yaxis: { lines: { show: true } },
        padding: { top: -20, right: 0, bottom: 0, left: 0 },
    },
    tooltip: {
        theme: 'dark',
        y: { formatter: val => val + ' peminjaman' },
        marker: { show: true }
    }
}).render();

// ===== CONDITIONS DONUT CHART - Vivid Colorful =====
var condTotal = {{ $barangBaik }} + {{ $barangRusak }} + {{ $barangHilang }};
new ApexCharts(document.querySelector("#chart_conditions"), {
    series: [{{ $barangBaik }}, {{ $barangRusak }}, {{ $barangHilang }}],
    chart: { type: 'donut', height: 300, fontFamily: 'inherit' },
    labels: ['Baik', 'Rusak', 'Hilang'],
    colors: ['#22C55E', '#F59E0B', '#EF4444'],
    plotOptions: {
        pie: {
            startAngle: -15,
            endAngle: 345,
            donut: {
                size: '70%',
                labels: {
                    show: true,
                    name: {
                        show: true,
                        fontSize: '13px',
                        fontWeight: 600,
                        color: '#64748B',
                        offsetY: -8,
                    },
                    value: {
                        show: true,
                        fontSize: '22px',
                        fontWeight: 700,
                        color: '#1E293B',
                        offsetY: 8,
                        formatter: val => val,
                    },
                    total: {
                        show: true,
                        label: 'Total Barang',
                        fontSize: '12px',
                        fontWeight: 600,
                        color: '#94A3B8',
                        formatter: () => condTotal,
                    }
                }
            },
            customScale: 1,
            dataLabels: { offset: 0 }
        }
    },
    dataLabels: {
        enabled: true,
        style: { fontSize: '12px', fontWeight: 700, colors: ['#fff'] },
        dropShadow: { enabled: false },
        formatter: (val, opts) => Math.round(val) + '%'
    },
    legend: {
        position: 'bottom',
        fontSize: '12px',
        labels: {
            colors: '#64748B',
            useSeriesColors: false,
        },
        markers: { width: 10, height: 10, radius: 3, offsetX: -4 },
        itemMargin: { horizontal: 10, vertical: 4 },
    },
    stroke: { width: 3, color: '#fff' },
    tooltip: {
        theme: 'dark',
        y: { formatter: val => val + ' item' }
    },
    responsive: [{
        breakpoint: 480,
        options: { chart: { height: 280 }, legend: { position: 'bottom' } }
    }]
}).render();

// ===== DAMAGE PER LOCATION BAR CHART - Rainbow Vibrant =====
var damageLabels = {!! json_encode($locationChartLabels) !!};
var damageCounts = {!! json_encode($locationChartCounts) !!};

// Vibrant palette for bars
var barColors = ['#EF4444', '#F97316', '#EAB308', '#22C55E', '#06B6D4', '#6366F1', '#A855F7', '#EC4899'];

if (damageLabels.length > 0) {
    var damageOptions = {
        series: [{ name: 'Jumlah Kerusakan', data: damageCounts }],
        chart: {
            type: 'bar',
            height: 310,
            fontFamily: 'inherit',
            toolbar: { show: false },
        },
        colors: function({ value, seriesIndex, w }) {
            return barColors[seriesIndex % barColors.length];
        },
        plotOptions: {
            bar: {
                borderRadius: 8,
                borderRadiusApplication: 'end',
                columnWidth: '45%',
                distributed: true,
                endingShape: 'rounded',
            }
        },
        dataLabels: {
            enabled: true,
            style: { fontSize: '11px', fontWeight: 700, colors: ['#fff'] },
            dropShadow: { enabled: false }
        },
        legend: { show: false },
        xaxis: {
            categories: damageLabels,
            labels: {
                style: {
                    colors: '#8892B0',
                    fontSize: '11px',
                    fontWeight: 600,
                    rotate: 0,
                },
                rotateAlways: false,
            },
            axisBorder: { show: false, color: '#E2E8F0' },
            axisTicks: { show: false },
        },
        yaxis: {
            labels: {
                style: { colors: '#8892B0', fontSize: '12px' },
                formatter: val => Math.round(val),
                offsetX: -8,
            },
            min: 0,
            tickAmount: 5,
        },
        fill: { opacity: 1 },
        grid: {
            borderColor: '#E2E8F0',
            strokeDashArray: 4,
            xaxis: { lines: { show: false } },
            yaxis: { lines: { show: true } },
        },
        tooltip: {
            theme: 'dark',
            marker: { show: true },
            y: { formatter: val => val + ' item rusak' }
        },
    };
    new ApexCharts(document.querySelector("#chart_damage_location"), damageOptions).render();
}
</script>
@endpush
