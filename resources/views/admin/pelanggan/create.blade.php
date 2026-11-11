
@extends('layouts.app')

@section('title', 'Tambah Pelanggan - LaundryKu')
@section('page-title', 'Tambah Pelanggan')

@section('content')

<div class="mb-4">
    <h4 class="fw-bold mb-1">Tambah Pelanggan</h4>
    <p class="text-muted mb-0">
        Masukkan informasi pelanggan baru LaundryKu.
    </p>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 14px;">
    <div class="card-body p-4">

        <form action="{{ route('admin.pelanggan.store') }}"
              method="POST">

            @csrf

            {{-- Nama --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">
                    Nama Lengkap <span class="text-danger">*</span>
                </label>

                <input type="text"
                       name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       placeholder="Masukkan nama pelanggan"
                       value="{{ old('name') }}">

                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">
                    Email <span class="text-danger">*</span>
                </label>

                <input type="email"
                       name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       placeholder="contoh@email.com"
                       value="{{ old('email') }}">

                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">
                    Password <span class="text-danger">*</span>
                </label>

                <input type="password"
                       name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="Minimal 8 karakter">

                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Telepon --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">
                    Nomor Telepon
                </label>

                <input type="text"
                       name="phone"
                       class="form-control @error('phone') is-invalid @enderror"
                       placeholder="Contoh: 081234567890"
                       value="{{ old('phone') }}">

                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Alamat --}}
            <div class="mb-4">
                <label class="form-label fw-semibold">
                    Alamat
                </label>

                <textarea name="address"
                          rows="3"
                          class="form-control @error('address') is-invalid @enderror"
                          placeholder="Masukkan alamat pelanggan">{{ old('address') }}</textarea>

                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <hr>

            <div class="d-flex justify-content-end gap-2">

                <a href="{{ route('admin.pelanggan.index') }}"
                   class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Kembali
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>
                    Simpan Pelanggan
                </button>

            </div>

        </form>

    </div>
</div>

@endsection
 