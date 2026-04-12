@extends('layouts.app')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')

@section('breadcrumb')
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
    <li class="breadcrumb-item text-muted">
        <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Home</a>
    </li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-gray-900">Profil Saya</li>
</ul>
@endsection

@section('content')
<div class="row g-5">
    <!--begin::Profile Card-->
    <div class="col-xl-4">
        <div class="card card-flush h-xl-100">
            <div class="card-body d-flex flex-column align-items-center py-10">
                <div class="symbol symbol-100px symbol-circle mb-5">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}"/>
                    @else
                        <div class="symbol-label fs-1 fw-bold bg-primary text-inverse-primary">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <div class="fs-3 fw-bold text-gray-800 mb-1">{{ $user->name }}</div>
                <div class="fs-6 text-muted mb-3">{{ $user->email }}</div>
                <span class="badge badge-light-{{ $user->role === 'admin' ? 'danger' : 'primary' }} fs-7 fw-semibold">
                    {{ ucfirst($user->role) }}
                </span>
                <div class="separator separator-dashed my-6 w-100"></div>
                <div class="d-flex flex-column gap-3 w-100 px-3">
                    <div class="d-flex align-items-center gap-2">
                        <i class="ki-duotone ki-calendar fs-3 text-muted"><span class="path1"></span><span class="path2"></span></i>
                        <span class="text-muted fs-7">Bergabung {{ $user->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="ki-duotone ki-shield-tick fs-3 {{ $user->is_active ? 'text-success' : 'text-danger' }}"><span class="path1"></span><span class="path2"></span></i>
                        <span class="fs-7 {{ $user->is_active ? 'text-success' : 'text-danger' }}">
                            {{ $user->is_active ? 'Akun Aktif' : 'Akun Nonaktif' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Profile Card-->

    <!--begin::Edit Form-->
    <div class="col-xl-8">
        <div class="card card-flush h-xl-100">
            <div class="card-header pt-7">
                <h3 class="card-title fw-bold">Edit Profil</h3>
            </div>
            <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <!--begin::Avatar-->
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Foto Profil</label>
                        <div class="col-lg-8">
                            <div class="image-input image-input-outline" data-kt-image-input="true">
                                <div class="image-input-wrapper w-125px h-125px"
                                    style="background-image: url('{{ $user->avatar ? asset('storage/' . $user->avatar) : 'assets/media/avatars/blank.png' }}')">
                                </div>
                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Ganti foto">
                                    <i class="ki-duotone ki-pencil fs-7"><span class="path1"></span><span class="path2"></span></i>
                                    <input type="file" name="avatar" accept=".png,.jpg,.jpeg"/>
                                    <input type="hidden" name="avatar_remove"/>
                                </label>
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Batalkan">
                                    <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span class="path2"></span></i>
                                </span>
                            </div>
                            @error('avatar')
                                <div class="text-danger mt-2 fs-7">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!--begin::Name-->
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Nama Lengkap</label>
                        <div class="col-lg-8">
                            <input type="text" name="name" class="form-control form-control-lg form-control-solid @error('name') is-invalid @enderror"
                                value="{{ old('name', $user->name) }}" required/>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!--begin::Email-->
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Email</label>
                        <div class="col-lg-8">
                            <input type="email" name="email" class="form-control form-control-lg form-control-solid @error('email') is-invalid @enderror"
                                value="{{ old('email', $user->email) }}" required/>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!--begin::Password-->
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                            Password Baru
                            <span class="ms-1" data-bs-toggle="tooltip" title="Kosongkan jika tidak ingin mengubah password">
                                <i class="ki-duotone ki-information-5 text-gray-500 fs-6"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                            </span>
                        </label>
                        <div class="col-lg-8">
                            <input type="password" name="password" class="form-control form-control-lg form-control-solid @error('password') is-invalid @enderror"
                                placeholder="Kosongkan jika tidak diubah"/>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!--begin::Confirm Password-->
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Konfirmasi Password</label>
                        <div class="col-lg-8">
                            <input type="password" name="password_confirmation"
                                class="form-control form-control-lg form-control-solid"
                                placeholder="Konfirmasi password baru"/>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-light me-3">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="ki-duotone ki-check fs-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!--end::Edit Form-->
</div>
@endsection
