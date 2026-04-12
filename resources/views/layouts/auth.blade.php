<!DOCTYPE html>
<html lang="id" data-bs-theme="light">
<head>
    <base href="{{ url('/') }}/"/>
    <title>@yield('title', 'Login') - {{ app_setting('app_name', config('app.name')) }}</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link rel="shortcut icon" href="{{ app_setting('favicon', 'assets/media/logos/favicon.ico') }}"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700"/>
    <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css"/>
    <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css"/>
    <style>
        .auth-aside {
            background: linear-gradient(135deg, #1B84FF 0%, #0D47A1 50%, #0A1F44 100%);
            position: relative;
            overflow: hidden;
        }
        .auth-aside::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
            border-radius: 50%;
        }
        .auth-aside::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -30%;
            width: 80%;
            height: 80%;
            background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
            border-radius: 50%;
        }
        .auth-aside .content-wrapper {
            position: relative;
            z-index: 2;
        }
        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 1;
            pointer-events: none;
        }
        .floating-shapes .shape {
            position: absolute;
            opacity: 0.06;
        }
        .floating-shapes .shape-1 { top: 10%; left: 10%; width: 80px; height: 80px; border: 3px solid #fff; border-radius: 50%; animation: float 6s ease-in-out infinite; }
        .floating-shapes .shape-2 { top: 60%; right: 15%; width: 60px; height: 60px; border: 3px solid #fff; transform: rotate(45deg); animation: float 8s ease-in-out infinite reverse; }
        .floating-shapes .shape-3 { bottom: 20%; left: 20%; width: 40px; height: 40px; background: #fff; border-radius: 50%; animation: float 7s ease-in-out infinite; }
        .floating-shapes .shape-4 { top: 30%; right: 30%; width: 100px; height: 100px; border: 2px solid #fff; border-radius: 20px; transform: rotate(30deg); animation: float 9s ease-in-out infinite reverse; }
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
        .auth-card {
            backdrop-filter: blur(10px);
            box-shadow: 0 0 50px rgba(0,0,0,0.08);
            border: 1px solid rgba(255,255,255,0.8);
            transition: transform 0.3s ease;
        }
        .auth-illustration {
            max-width: 320px;
            filter: drop-shadow(0 20px 40px rgba(0,0,0,0.15));
            animation: illustFloat 4s ease-in-out infinite;
        }
        @keyframes illustFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .feature-item {
            transition: transform 0.2s ease;
        }
        .feature-item:hover {
            transform: translateX(5px);
        }
    </style>
</head>
<body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center">
    @include('layouts.partials._theme-mode')

    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <!--begin::Aside (Branding Panel)-->
            <div class="d-flex flex-lg-row-fluid auth-aside">
                <div class="floating-shapes">
                    <div class="shape shape-1"></div>
                    <div class="shape shape-2"></div>
                    <div class="shape shape-3"></div>
                    <div class="shape shape-4"></div>
                </div>
                <div class="d-flex flex-column flex-center py-15 px-5 px-md-15 w-100 content-wrapper">
                    <!--begin::Logo-->
                    <a href="{{ url('/') }}" class="mb-12">
                        @if(app_setting('app_logo'))
                            <img alt="Logo" src="{{ asset('storage/' . app_setting('app_logo')) }}" class="h-60px"/>
                        @else
                            <div class="d-flex align-items-center">
                                <div class="bg-white rounded-circle d-flex align-items-center justify-content-center me-4" style="width: 55px; height: 55px;">
                                    <i class="ki-duotone ki-abstract-26 fs-2x text-primary"><span class="path1"></span><span class="path2"></span></i>
                                </div>
                                <h1 class="text-white fw-bolder m-0" style="font-size: 2.2rem; letter-spacing: 2px;">
                                    {{ app_setting('app_name', config('app.name')) }}
                                </h1>
                            </div>
                        @endif
                    </a>
                    <!--end::Logo-->

                    <!--begin::Illustration-->
                    <img class="auth-illustration mx-auto mb-10 mb-lg-15 d-none d-lg-block"
                         src="assets/media/illustrations/sketchy-1/17.png"
                         alt="Illustration"/>
                    <!--end::Illustration-->

                    <!--begin::Title-->
                    <h2 class="text-white fw-bolder text-center fs-2qx mb-4">
                        {{ app_setting('app_description', 'Sistem Manajemen Sarana & Prasarana') }}
                    </h2>
                    <!--end::Title-->

                    <!--begin::Features-->
                    <div class="d-none d-lg-block mt-8">
                        <div class="d-flex align-items-center feature-item mb-5">
                            <div class="rounded-circle bg-white bg-opacity-15 d-flex align-items-center justify-content-center me-4" style="width: 40px; height: 40px; min-width: 40px;">
                                <i class="ki-duotone ki-tablet-ok fs-3 text-white"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                            </div>
                            <span class="text-white fs-5 fw-semibold opacity-75">Pendataan & inventarisasi barang sekolah</span>
                        </div>
                        <div class="d-flex align-items-center feature-item mb-5">
                            <div class="rounded-circle bg-white bg-opacity-15 d-flex align-items-center justify-content-center me-4" style="width: 40px; height: 40px; min-width: 40px;">
                                <i class="ki-duotone ki-scan-barcode fs-3 text-white"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span></i>
                            </div>
                            <span class="text-white fs-5 fw-semibold opacity-75">QR Code tracking & peminjaman barang</span>
                        </div>
                        <div class="d-flex align-items-center feature-item">
                            <div class="rounded-circle bg-white bg-opacity-15 d-flex align-items-center justify-content-center me-4" style="width: 40px; height: 40px; min-width: 40px;">
                                <i class="ki-duotone ki-chart-simple fs-3 text-white"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                            </div>
                            <span class="text-white fs-5 fw-semibold opacity-75">Laporan & monitoring kondisi aset</span>
                        </div>
                    </div>
                    <!--end::Features-->
                </div>
            </div>
            <!--end::Aside-->

            <!--begin::Body (Form Panel)-->
            <div class="d-flex flex-column flex-lg-row-fluid w-lg-50">
                <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                    <div class="w-lg-500px p-10">
                        <div class="auth-card bg-body rounded-4 p-10 p-lg-15 mx-auto">
                            @yield('content')
                        </div>
                    </div>
                </div>
                <!--begin::Footer-->
                <div class="d-flex flex-center flex-wrap px-5 pb-7">
                    <span class="text-muted fw-semibold me-1">&copy; {{ date('Y') }}</span>
                    <a href="{{ url('/') }}" class="text-primary fw-semibold">{{ app_setting('app_name', config('app.name')) }}</a>
                </div>
                <!--end::Footer-->
            </div>
            <!--end::Body-->
        </div>
    </div>

    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <script src="assets/js/scripts.bundle.js"></script>
</body>
</html>
