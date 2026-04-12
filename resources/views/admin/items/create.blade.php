@extends('layouts.app')
@section('title', 'Tambah Barang')
@section('page-title', 'Tambah Barang')

@section('breadcrumb')
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.items.index') }}" class="text-muted text-hover-primary">Inventaris</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-gray-900">Tambah Barang</li>
</ul>
@endsection

@section('content')
<div class="card card-flush">
    <form action="{{ route('admin.items.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-header">
            <h3 class="card-title">Form Tambah Barang</h3>
        </div>
        <div class="card-body">
            <div class="row g-5">
                <div class="col-md-6">
                    <label class="form-label required">Kode Barang</label>
                    <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code') }}" placeholder="Contoh: BRG-001"/>
                    @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label required">Nama Barang</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"/>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label required">Kategori</label>
                    <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label required">Lokasi</label>
                    <select name="location_id" class="form-select @error('location_id') is-invalid @enderror">
                        <option value="">Pilih Lokasi</option>
                        @foreach($locations as $loc)
                            <option value="{{ $loc->id }}" {{ old('location_id') == $loc->id ? 'selected' : '' }}>{{ $loc->name }}</option>
                        @endforeach
                    </select>
                    @error('location_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label required">Kondisi</label>
                    <select name="condition" class="form-select @error('condition') is-invalid @enderror">
                        <option value="baik" {{ old('condition') == 'baik' ? 'selected' : '' }}>Baik</option>
                        <option value="rusak_ringan" {{ old('condition') == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                        <option value="rusak_berat" {{ old('condition') == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                        <option value="hilang" {{ old('condition') == 'hilang' ? 'selected' : '' }}>Hilang</option>
                    </select>
                    @error('condition') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label required">Jumlah</label>
                    <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity', 1) }}" min="1"/>
                    @error('quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Harga (Rp)</label>
                    <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', 0) }}" min="0"/>
                    @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tanggal Perolehan</label>
                    <input type="date" name="acquisition_date" class="form-control @error('acquisition_date') is-invalid @enderror" value="{{ old('acquisition_date') }}"/>
                    @error('acquisition_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Sumber Perolehan</label>
                    <input type="text" name="acquisition_source" class="form-control @error('acquisition_source') is-invalid @enderror" value="{{ old('acquisition_source') }}" placeholder="Contoh: Pembelian, Hibah, dll"/>
                    @error('acquisition_source') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Foto Barang</label>
                    <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/*"/>
                    @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-12">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description') }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end gap-3">
            <a href="{{ route('admin.items.index') }}" class="btn btn-light">Batal</a>
            <button type="submit" class="btn btn-primary">
                <i class="ki-duotone ki-check fs-2"></i> Simpan
            </button>
        </div>
    </form>
</div>
@endsection
