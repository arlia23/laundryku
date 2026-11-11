
@extends('layouts.app')

@section('title', 'Tambah Kurir - LaundryKu')
@section('page-title', 'Tambah Kurir')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="mb-4">
        <a href="{{ route('admin.kurir.index') }}"
           class="text-decoration-none text-muted">
            <i class="bi bi-arrow-left me-1"></i>
            Kembali ke Data Kurir
        </a>

        <h4 class="fw-bold mt-3 mb-1">Tambah Kurir Baru</h4>
        <p class="text-muted mb-0">
            Buat akun baru untuk petugas kurir LaundryKu.
        </p>
    </div>

    {{-- Informasi Akun --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-0">
                <i class="bi bi-person-plus me-2 text-primary"></i>
                Formulir Kurir
            </h5>
        </div>

        <div class="card-body p-4">

            <form action="{{ route('admin.kurir.store') }}" method="POST">
                @csrf

                <div class="row g-3">

                    {{-- Nama --}}
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-semibold">
                            Nama Lengkap <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="name"
                               id="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}"
                               placeholder="Masukkan nama lengkap kurir"
                               required>

                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="col-md-6">
                        <label for="email" class="form-label fw-semibold">
                            Email <span class="text-danger">*</span>
                        </label>

                        <input type="email"
                               name="email"
                               id="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}"
                               placeholder="contoh@email.com"
                               required>

                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="col-md-6">
                        <label for="password" class="form-label fw-semibold">
                            Password <span class="text-danger">*</span>
                        </label>

                        <input type="password"
                               name="password"
                               id="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Minimal 8 karakter"
                               minlength="8"
                               required>

                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <small class="text-muted">
                            Password ini digunakan kurir untuk login.
                        </small>
                    </div>

                    {{-- Nomor Telepon --}}
                    <div class="col-md-6">
                        <label for="phone" class="form-label fw-semibold">
                            Nomor Telepon
                        </label>

                        <input type="text"
                               name="phone"
                               id="phone"
                               class="form-control @error('phone') is-invalid @enderror"
                               value="{{ old('phone') }}"
                               placeholder="Contoh: 081234567890">

                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Alamat --}}
                    <div class="col-12">
                        <label for="address" class="form-label fw-semibold">
                            Alamat
                        </label>

                        <textarea name="address"
                                  id="address"
                                  rows="3"
                                  class="form-control @error('address') is-invalid @enderror"
                                  placeholder="Masukkan alamat lengkap kurir">{{ old('address') }}</textarea>

                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Akun akan otomatis dibuat sebagai kurir.
                    </small>

                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.kurir.index') }}"
                           class="btn btn-light border">
                            Batal
                        </a>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>
                            Simpan Kurir
                        </button>
                    </div>

                </div>

            </form>

        </div>
    </div>

</div>

@endsection
