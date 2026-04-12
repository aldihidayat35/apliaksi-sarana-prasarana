@extends('layouts.app')
@section('title', 'Registrasi Baru')
@section('page-title', 'Registrasi Sarana Baru')

@section('breadcrumb')
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.registrations.index') }}" class="text-muted text-hover-primary">Registrasi</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-gray-900">Registrasi Baru</li>
</ul>
@endsection

@section('content')
<div class="card card-flush">
    <form action="{{ route('admin.registrations.store') }}" method="POST">
        @csrf
        <div class="card-header">
            <h3 class="card-title">Form Registrasi Sarana</h3>
        </div>
        <div class="card-body">
            @if($items->isEmpty())
            <div class="alert alert-warning d-flex align-items-center">
                <i class="ki-duotone ki-information-2 fs-2hx text-warning me-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                <div>Semua barang sudah diregistrasi. <a href="{{ route('admin.items.create') }}">Tambahkan barang baru</a> terlebih dahulu.</div>
            </div>
            @else
            <div class="row g-5">
                <div class="col-md-12">
                    <label class="form-label required">Pilih Barang</label>
                    <select name="item_id" class="form-select @error('item_id') is-invalid @enderror">
                        <option value="">Pilih barang yang akan diregistrasi...</option>
                        @foreach($items as $item)
                            <option value="{{ $item->id }}" {{ old('item_id') == $item->id ? 'selected' : '' }}>
                                [{{ $item->code }}] {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('item_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <div class="form-text">Hanya barang yang belum diregistrasi yang ditampilkan</div>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Catatan</label>
                    <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3" placeholder="Catatan registrasi (opsional)">{{ old('notes') }}</textarea>
                    @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            @endif
        </div>
        <div class="card-footer d-flex justify-content-end gap-3">
            <a href="{{ route('admin.registrations.index') }}" class="btn btn-light">Batal</a>
            @if(!$items->isEmpty())
            <button type="submit" class="btn btn-primary">
                <i class="ki-duotone ki-scan-barcode fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span></i> Generate QR & Registrasi
            </button>
            @endif
        </div>
    </form>
</div>
@endsection
