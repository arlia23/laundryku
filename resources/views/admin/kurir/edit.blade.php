
@extends('layouts.app')

@section('title', 'Edit Kurir - LaundryKu')
@section('page-title', 'Edit Kurir')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="mb-4">
        <a href="{{ route('admin.kurir.index') }}"
           class="text-decoration-none text-muted">
            <i class="bi bi-arrow-left me-1"></i>
            Kembali ke Data Kurir
        </a>

        <h4 class="fw-bold mt-3 mb-1">Edit Data Kurir</h4>
        <p class="text-muted mb-0">
            Perbarui informasi akun kurir LaundryKu.
        </p>
    </div>

    {{-- Form --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-0">
                <i class="bi bi-person-gear me-2 text-primary"></i>
                Formulir Edit Kurir
            </h5>
        </div>

        <div class="card-body p-4">

            <form action="{{ route('admin.kurir.update', $kurir->id) }}"
                  method="POST">

                @csrf
                @method('PUT')

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
                               value="{{ old('name', $kurir->name) }}"
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
                               value="{{ old('email', $kurir->email) }}"
                               required>

                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="col-md-6">
                        <label for="password" class="form-label fw-semibold">
                            Password Baru
                        </label>

                        <input type="password"
                               name="password"
                               id="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Kosongkan jika tidak ingin mengganti">

                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <small class="text-muted">
                            Isi minimal 8 karakter jika ingin mengganti password.
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
                               value="{{ old('phone', $kurir->phone) }}"
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
                                  placeholder="Masukkan alamat lengkap kurir">{{ old('address', $kurir->address) }}</textarea>

                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Password lama tetap digunakan jika dikosongkan.
                    </small>

                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.kurir.index') }}"
                           class="btn btn-light border">
                            Batal
                        </a>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>
                            Simpan Perubahan
                        </button>
                    </div>

                </div>

            </form>

        </div>
    </div>

</div>

@endsection
