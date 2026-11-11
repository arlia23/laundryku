
@extends('layouts.app')

@section('title', 'Edit Pelanggan - LaundryKu')
@section('page-title', 'Edit Pelanggan')

@section('content')

<div class="mb-4">
    <h4 class="fw-bold mb-1">Edit Pelanggan</h4>
    <p class="text-muted mb-0">
        Perbarui informasi pelanggan LaundryKu.
    </p>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 14px;">
    <div class="card-body p-4">

        <form action="{{ route('admin.pelanggan.update', $pelanggan->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">
                    Nama Lengkap <span class="text-danger">*</span>
                </label>

                <input type="text"
                       name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $pelanggan->name) }}"
                       required>

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
                       value="{{ old('email', $pelanggan->email) }}"
                       required>

                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">
                    Password Baru
                </label>

                <input type="password"
                       name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="Kosongkan jika tidak ingin mengganti password">

                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                <small class="text-muted">
                    Password lama tidak akan berubah jika kolom ini dikosongkan.
                </small>
            </div>

            {{-- Telepon --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">
                    Nomor Telepon
                </label>

                <input type="text"
                       name="phone"
                       class="form-control @error('phone') is-invalid @enderror"
                       value="{{ old('phone', $pelanggan->phone) }}">

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
                          class="form-control @error('address') is-invalid @enderror">{{ old('address', $pelanggan->address) }}</textarea>

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
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>
</div>

@endsection
