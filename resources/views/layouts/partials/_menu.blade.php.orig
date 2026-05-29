<!--begin::Menu-->
<div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true"
    data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto"
    data-kt-scroll-dependencies="#kt_aside_toolbar, #kt_aside_footer"
    data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="5px">

    <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
        id="#kt_aside_menu" data-kt-menu="true">

        <!--begin::Menu item - Dashboard (Admin)-->
        @if(auth()->user()->isAdmin())
        <div class="menu-item">
            <a class="menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <span class="menu-icon">
                    <i class="ki-duotone ki-element-11 fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                </span>
                <span class="menu-title">Dashboard</span>
            </a>
        </div>
        @endif
        <!--end::Menu item - Dashboard (Admin)-->

        <!--begin::Menu item - Dashboard (Guru only)-->
        @if(auth()->user()->isGuru() && !auth()->user()->isAdmin())
        <div class="menu-item">
            <a class="menu-link {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}" href="{{ route('guru.dashboard') }}">
                <span class="menu-icon">
                    <i class="ki-duotone ki-element-11 fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                </span>
                <span class="menu-title">Dashboard</span>
            </a>
        </div>
        @endif
        <!--end::Menu item - Dashboard (Guru only)-->

        @if(auth()->user()->isAdmin())
        <div class="menu-item pt-5">
            <div class="menu-content">
                <span class="menu-heading fw-bold text-uppercase fs-7">Sarana & Prasarana</span>
            </div>
        </div>

        <!--begin::Menu item - Inventaris (Admin)-->
        <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('admin.items.*') ? 'here show' : '' }}">
            <span class="menu-link">
                <span class="menu-icon">
                    <i class="ki-duotone ki-cube-2 fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                </span>
                <span class="menu-title">Inventaris</span>
                <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion">
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.items.index') ? 'active' : '' }}" href="{{ route('admin.items.index') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">Daftar Barang</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.items.new') ? 'active' : '' }}" href="{{ route('admin.items.new') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">Barang Baru</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.items.create') ? 'active' : '' }}" href="{{ route('admin.items.create') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">Tambah Barang</span>
                    </a>
                </div>
            </div>
        </div>
        <!--end::Menu item - Inventaris (Admin)-->

        <!--begin::Menu item - Registrasi Sarana (Admin)-->
        <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('admin.registrations.*') ? 'here show' : '' }}">
            <span class="menu-link">
                <span class="menu-icon">
                    <i class="ki-duotone ki-scan-barcode fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span></i>
                </span>
                <span class="menu-title">Registrasi Sarana</span>
                <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion">
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.registrations.index') ? 'active' : '' }}" href="{{ route('admin.registrations.index') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">Daftar Registrasi</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.registrations.create') ? 'active' : '' }}" href="{{ route('admin.registrations.create') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">Registrasi Baru</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.registrations.scan') ? 'active' : '' }}" href="{{ route('admin.registrations.scan') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">Scan QR Code</span>
                    </a>
                </div>
            </div>
        </div>
        <!--end::Menu item - Registrasi Sarana (Admin)-->
        @endif

        @if(auth()->user()->isAdmin() || auth()->user()->isGuru())
        <div class="menu-item pt-5">
            <div class="menu-content">
                <span class="menu-heading fw-bold text-uppercase fs-7">Transaksi</span>
            </div>
        </div>

        <!--begin::Menu item - Inventaris (Guru only)-->
        @if(auth()->user()->isGuru() && !auth()->user()->isAdmin())
        <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('guru.inventaris*') ? 'here show' : '' }}">
            <span class="menu-link">
                <span class="menu-icon">
                    <i class="ki-duotone ki-cube-2 fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                </span>
                <span class="menu-title">Inventaris</span>
                <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion">
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('guru.inventaris') && !request()->routeIs('guru.inventaris.ready') && !request()->routeIs('guru.inventaris.dipinjam') ? 'active' : '' }}" href="{{ route('guru.inventaris') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">Daftar Barang</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('guru.inventaris.ready') ? 'active' : '' }}" href="{{ route('guru.inventaris.ready') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">Barang Ready</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('guru.inventaris.dipinjam') ? 'active' : '' }}" href="{{ route('guru.inventaris.dipinjam') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">Sedang Dipinjam</span>
                    </a>
                </div>
            </div>
        </div>
        <!--end::Menu item - Inventaris (Guru only)-->
        @endif

        <!--begin::Menu item - Peminjaman (Admin + Guru)-->
        <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('admin.borrowings.*') ? 'here show' : '' }}">
            <span class="menu-link">
                <span class="menu-icon">
                    <i class="ki-duotone ki-handcart fs-2"><span class="path1"></span><span class="path2"></span></i>
                </span>
                <span class="menu-title">Peminjaman</span>
                <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion">
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.borrowings.index') ? 'active' : '' }}" href="{{ route('admin.borrowings.index') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">Data Peminjaman</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.borrowings.returns') ? 'active' : '' }}" href="{{ route('admin.borrowings.returns') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">Pengembalian Barang</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.borrowings.create') ? 'active' : '' }}" href="{{ route('admin.borrowings.create') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">Form Peminjaman</span>
                    </a>
                </div>
            </div>
        </div>
        <!--end::Menu item - Peminjaman (Admin + Guru)-->
        @endif

        @if(auth()->user()->isAdmin())
        <div class="menu-item pt-5">
            <div class="menu-content">
                <span class="menu-heading fw-bold text-uppercase fs-7">Pengawasan</span>
            </div>
        </div>

        <!--begin::Menu item - Monitoring (Admin only)-->
        <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('admin.monitoring.*') ? 'here show' : '' }}">
            <span class="menu-link">
                <span class="menu-icon">
                    <i class="ki-duotone ki-eye fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                </span>
                <span class="menu-title">Monitoring</span>
                <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion">
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.monitoring.index') ? 'active' : '' }}" href="{{ route('admin.monitoring.index') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">Kondisi Barang</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.monitoring.reports') ? 'active' : '' }}" href="{{ route('admin.monitoring.reports') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">Riwayat Perubahan</span>
                    </a>
                </div>
            </div>
        </div>
        <!--end::Menu item - Monitoring (Admin only)-->
        @endif

        <!--begin::Menu item - Pelaporan (Guru only - no Admin access to reports menu since admin has its own Pelaporan below)-->
        @if(auth()->user()->isGuru() && !auth()->user()->isAdmin())
        <div class="menu-item pt-5">
            <div class="menu-content">
                <span class="menu-heading fw-bold text-uppercase fs-7">Pelaporan</span>
            </div>
        </div>
        <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('guru.reports.*') ? 'here show' : '' }}">
            <span class="menu-link">
                <span class="menu-icon">
                    <i class="ki-duotone ki-chart-simple fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                </span>
                <span class="menu-title">Laporan</span>
                <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion">
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('guru.reports.kerusakan-lokasi') ? 'active' : '' }}" href="{{ route('guru.reports.kerusakan-lokasi') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">Kerusakan per Lokasi</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('guru.reports.kondisi') ? 'active' : '' }}" href="{{ route('guru.reports.kondisi') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">Kondisi Barang</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('guru.reports.prioritas') ? 'active' : '' }}" href="{{ route('guru.reports.prioritas') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">Prioritas Pengadaan</span>
                    </a>
                </div>
            </div>
        </div>
        <!--end::Menu item - Pelaporan (Guru only)-->
        @endif

        <div class="menu-item pt-5">
            <div class="menu-content">
                <span class="menu-heading fw-bold text-uppercase fs-7">Pelaporan</span>
            </div>
        </div>

        <!--begin::Menu item - Laporan (Admin only, since guru has its own above)-->
        @if(auth()->user()->isAdmin())
        <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('admin.reports.*') ? 'here show' : '' }}">
            <span class="menu-link">
                <span class="menu-icon">
                    <i class="ki-duotone ki-chart-simple fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                </span>
                <span class="menu-title">Laporan</span>
                <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion">
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.reports.inventory') ? 'active' : '' }}" href="{{ route('admin.reports.inventory') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">Laporan Inventaris</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.reports.borrowing') ? 'active' : '' }}" href="{{ route('admin.reports.borrowing') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">Laporan Peminjaman</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.reports.damage') ? 'active' : '' }}" href="{{ route('admin.reports.damage') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">Laporan Kerusakan</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.reports.damage-location') ? 'active' : '' }}" href="{{ route('admin.reports.damage-location') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">Kerusakan per Lokasi</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.reports.condition') ? 'active' : '' }}" href="{{ route('admin.reports.condition') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">Laporan Kondisi Barang</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.reports.priority') ? 'active' : '' }}" href="{{ route('admin.reports.priority') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">Prioritas Pengadaan</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.reports.annual') ? 'active' : '' }}" href="{{ route('admin.reports.annual') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">Laporan Tahunan</span>
                    </a>
                </div>
            </div>
        </div>
        @endif
        <!--end::Menu item - Laporan (Admin only)-->

        @if(auth()->user()->isAdmin())
        <div class="menu-item pt-5">
            <div class="menu-content">
                <span class="menu-heading fw-bold text-uppercase fs-7">Manajemen</span>
            </div>
        </div>

        <!--begin::Menu item - User Management (Admin only)-->
        <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('admin.users.*') ? 'here show' : '' }}">
            <span class="menu-link">
                <span class="menu-icon">
                    <i class="ki-duotone ki-people fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                </span>
                <span class="menu-title">Manajemen User</span>
                <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion">
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.users.index') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">Daftar User</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.users.create') ? 'active' : '' }}" href="{{ route('admin.users.create') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">Tambah User</span>
                    </a>
                </div>
            </div>
        </div>
        <!--end::Menu item - User Management (Admin only)-->

        <div class="menu-item pt-5">
            <div class="menu-content">
                <span class="menu-heading fw-bold text-uppercase fs-7">Pengaturan</span>
            </div>
        </div>

        <!--begin::Menu item - Pengaturan (Admin only)-->
        <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('admin.settings.*') || request()->routeIs('admin.categories.*') || request()->routeIs('admin.locations.*') ? 'here show' : '' }}">
            <span class="menu-link">
                <span class="menu-icon">
                    <i class="ki-duotone ki-setting-2 fs-2"><span class="path1"></span><span class="path2"></span></i>
                </span>
                <span class="menu-title">Pengaturan</span>
                <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion">
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">Profil Sekolah</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">Kategori Barang</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('admin.locations.*') ? 'active' : '' }}" href="{{ route('admin.locations.index') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">Lokasi</span>
                    </a>
                </div>
            </div>
        </div>
        <!--end::Menu item - Pengaturan (Admin only)-->
        @endif
    </div>
</div>
<!--end::Menu-->