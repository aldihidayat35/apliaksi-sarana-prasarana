@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<form class="form w-100" method="POST" action="{{ route('login') }}">
    @csrf

    <!--begin::Heading-->
    <div class="text-center mb-11">
        <div class="mb-4">
            <div class="d-inline-flex align-items-center justify-content-center bg-light-primary rounded-circle" style="width: 70px; height: 70px;">
                <i class="ki-duotone ki-lock-3 fs-2x text-primary"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
            </div>
        </div>
        <h1 class="text-gray-900 fw-bolder mb-3 fs-2qx">Selamat Datang!</h1>
        <div class="text-gray-500 fw-semibold fs-6">Masuk ke panel {{ app_setting('app_name', config('app.name')) }}</div>
    </div>
    <!--end::Heading-->

    @if($errors->any())
        <div class="alert alert-danger d-flex align-items-center p-5 mb-10">
            <i class="ki-duotone ki-shield-cross fs-2hx text-danger me-4"><span class="path1"></span><span class="path2"></span></i>
            <div class="d-flex flex-column">
                @foreach($errors->all() as $error)
                    <span>{{ $error }}</span>
                @endforeach
            </div>
        </div>
    @endif

    @if(session('status'))
        <div class="alert alert-success d-flex align-items-center p-5 mb-10">
            <i class="ki-duotone ki-shield-tick fs-2hx text-success me-4"><span class="path1"></span><span class="path2"></span></i>
            <div class="d-flex flex-column">
                <span>{{ session('status') }}</span>
            </div>
        </div>
    @endif

    <!--begin::Input group-->
    <div class="fv-row mb-8">
        <label class="form-label fs-6 fw-bold text-gray-900">Email</label>
        <div class="position-relative">
            <i class="ki-duotone ki-sms fs-4 position-absolute translate-middle-y top-50 ms-4 text-gray-500"><span class="path1"></span><span class="path2"></span></i>
            <input type="email" placeholder="nama@sekolah.sch.id" name="email" autocomplete="off"
                class="form-control form-control-lg form-control-solid ps-12 @error('email') is-invalid @enderror"
                value="{{ old('email') }}" required autofocus/>
        </div>
    </div>
    <!--end::Input group-->

    <!--begin::Input group-->
    <div class="fv-row mb-8">
        <label class="form-label fs-6 fw-bold text-gray-900">Password</label>
        <div class="position-relative" data-kt-password-meter="true">
            <i class="ki-duotone ki-lock-2 fs-4 position-absolute translate-middle-y top-50 ms-4 text-gray-500"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
            <input type="password" placeholder="Masukkan password" name="password" autocomplete="off"
                class="form-control form-control-lg form-control-solid ps-12 @error('password') is-invalid @enderror" required/>
            <span class="btn btn-sm btn-icon position-absolute translate-middle-y top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                <i class="ki-duotone ki-eye-slash fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                <i class="ki-duotone ki-eye fs-2 d-none"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
            </span>
        </div>
    </div>
    <!--end::Input group-->

    <!--begin::Wrapper-->
    <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-10">
        <div>
            <label class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}/>
                <span class="form-check-label fw-semibold text-gray-700 fs-base ms-1">Ingat Saya</span>
            </label>
        </div>
    </div>
    <!--end::Wrapper-->

    <!--begin::Submit button-->
    <div class="d-grid mb-10">
        <button type="submit" class="btn btn-primary btn-lg">
            <span class="indicator-label">
                <i class="ki-duotone ki-entrance-right fs-3 me-2"><span class="path1"></span><span class="path2"></span></i>
                Masuk
            </span>
        </button>
    </div>
    <!--end::Submit button-->
</form>
@endsection
