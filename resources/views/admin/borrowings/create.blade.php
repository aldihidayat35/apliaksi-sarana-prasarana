@extends('layouts.app')
@section('title', 'Form Peminjaman')
@section('page-title', 'Form Peminjaman Baru')

@section('breadcrumb')
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.borrowings.index') }}" class="text-muted text-hover-primary">Peminjaman</a></li>
    <li class="breadcrumb-item"><span class="bullet bg-gray-300 w-5px h-2px"></span></li>
    <li class="breadcrumb-item text-gray-900">Form Peminjaman</li>
</ul>
@endsection

@section('content')
<div class="card card-flush">
    <form action="{{ route('admin.borrowings.store') }}" method="POST">
        @csrf
        <div class="card-header">
            <h3 class="card-title">Form Peminjaman Barang</h3>
        </div>
        <div class="card-body">
            <div class="row g-5">
                <div class="col-md-6">
                    <label class="form-label required">Barang</label>
                    <select name="item_id" class="form-select @error('item_id') is-invalid @enderror">
                        <option value="">Pilih barang...</option>
                        @foreach($items as $item)
                            <option value="{{ $item->id }}" {{ old('item_id') == $item->id ? 'selected' : '' }}>
                                [{{ $item->code }}] {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('item_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <div class="form-text">Hanya barang yang tersedia (tidak dipinjam & tidak hilang)</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label required">Peminjam</label>
                    <select name="user_id" class="form-select @error('user_id') is-invalid @enderror">
                        <option value="">Pilih peminjam...</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->role_label }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label required">Tanggal Peminjaman</label>
                    <input type="date" name="borrow_date" class="form-control @error('borrow_date') is-invalid @enderror" value="{{ old('borrow_date', date('Y-m-d')) }}"/>
                    @error('borrow_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label required">Tanggal Harus Kembali</label>
                    <input type="date" name="expected_return_date" class="form-control @error('expected_return_date') is-invalid @enderror" value="{{ old('expected_return_date') }}"/>
                    @error('expected_return_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-12">
                    <label class="form-label">Tujuan Peminjaman</label>
                    <textarea name="purpose" class="form-control @error('purpose') is-invalid @enderror" rows="2" placeholder="Jelaskan tujuan peminjaman...">{{ old('purpose') }}</textarea>
                    @error('purpose') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-12">
                    <label class="form-label">Catatan</label>
                    <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="2">{{ old('notes') }}</textarea>
                    @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end gap-3">
            <a href="{{ route('admin.borrowings.index') }}" class="btn btn-light">Batal</a>
            <button type="submit" class="btn btn-primary">
                <i class="ki-duotone ki-check fs-2"></i> Simpan Peminjaman
            </button>
        </div>
    </form>
</div>
@endsection
