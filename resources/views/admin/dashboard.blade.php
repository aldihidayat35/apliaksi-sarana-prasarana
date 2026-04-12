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

    <!--begin::Chart - Kategori Barang-->
    <div class="col-xl-4">
        <div class="card card-flush h-xl-100">
            <div class="card-header pt-7">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">Kondisi Barang</span>
                    <span class="text-gray-500 mt-1 fw-semibold fs-6">Distribusi kondisi sarana</span>
                </h3>
            </div>
            <div class="card-body pt-5">
                <div id="chart_conditions" style="height: 300px;"></div>
            </div>
        </div>
    </div>
    <!--end::Chart-->
</div>
<!--end::Charts Row-->

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
    colors: ['#1B84FF'],
    markers: { size: 5, colors: ['#1B84FF'], strokeColors: '#fff', strokeWidth: 2 },
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
</script>
@endpush
