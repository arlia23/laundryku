
@extends('layouts.app')

@section('title', 'Tambah Mesin - LaundryKu')
@section('page-title', 'Tambah Mesin')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="mb-4">
        <a href="{{ route('admin.mesin.index') }}"
           class="text-decoration-none text-muted">
            <i class="bi bi-arrow-left me-1"></i>
            Kembali ke Data Mesin
        </a>

        <h4 class="fw-bold mt-3 mb-1">Tambah Mesin Laundry</h4>
        <p class="text-muted mb-0">
            Masukkan informasi mesin laundry yang akan ditambahkan.
        </p>
    </div>

    {{-- Form --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-0">Formulir Mesin</h5>
        </div>

        <div class="card-body p-4">

            <form action="{{ route('admin.mesin.store') }}" method="POST">
                @csrf

                <div class="row g-3">

                    {{-- Nama Mesin --}}
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-semibold">
                            Nama Mesin <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="name"
                               id="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}"
                               placeholder="Contoh: Mesin Cuci 1"
                               required>

                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Jenis Mesin --}}
                    <div class="col-md-6">
                        <label for="type" class="form-label fw-semibold">
                            Jenis Mesin <span class="text-danger">*</span>
                        </label>

                        <select name="type"
                                id="type"
                                class="form-select @error('type') is-invalid @enderror"
                                required>
                            <option value="">-- Pilih Jenis Mesin --</option>
                            <option value="Mesin Cuci" {{ old('type') == 'Mesin Cuci' ? 'selected' : '' }}>
                                Mesin Cuci
                            </option>
                            <option value="Mesin Pengering" {{ old('type') == 'Mesin Pengering' ? 'selected' : '' }}>
                                Mesin Pengering
                            </option>
                            <option value="Mesin Setrika" {{ old('type') == 'Mesin Setrika' ? 'selected' : '' }}>
                                Mesin Setrika
                            </option>
                        </select>

                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Status Mesin --}}
                    <div class="col-md-6">
                        <label for="status" class="form-label fw-semibold">
                            Status Mesin <span class="text-danger">*</span>
                        </label>

                        <select name="status"
                                id="status"
                                class="form-select @error('status') is-invalid @enderror"
                                required>
                            <option value="">-- Pilih Status --</option>
                            <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>
                                Tersedia
                            </option>
                            <option value="in_use" {{ old('status') == 'in_use' ? 'selected' : '' }}>
                                Sedang Digunakan
                            </option>
                            <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>
                                Dalam Perawatan
                            </option>
                        </select>

                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.mesin.index') }}"
                       class="btn btn-light border">
                        Batal
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>
                        Simpan Mesin
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection
