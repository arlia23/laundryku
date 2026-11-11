
@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="mb-4">
        <h4 class="fw-bold mb-1">Edit Paket Laundry</h4>
        <p class="text-muted mb-0">
            Ubah informasi layanan dan harga paket laundry.
        </p>
    </div>

    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white py-3">
            <h6 class="mb-0 fw-bold">Form Edit Paket</h6>
        </div>

        <div class="card-body">

            <form action="{{ route('admin.paket.update', $paket->id) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Nama Paket
                    </label>

                    <select name="name"
                            class="form-select @error('name') is-invalid @enderror"
                            required>

                        <option value="">-- Pilih Paket Laundry --</option>

                        <option value="Cuci Kering"
                            {{ old('name', $paket->name) == 'Cuci Kering' ? 'selected' : '' }}>
                            Cuci Kering
                        </option>

                        <option value="Cuci Setrika"
                            {{ old('name', $paket->name) == 'Cuci Setrika' ? 'selected' : '' }}>
                            Cuci Setrika
                        </option>

                        <option value="Cuci Setrika Antar"
                            {{ old('name', $paket->name) == 'Cuci Setrika Antar' ? 'selected' : '' }}>
                            Cuci Setrika Antar
                        </option>

                    </select>

                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Deskripsi
                    </label>

                    <textarea name="description"
                              rows="4"
                              class="form-control @error('description') is-invalid @enderror"
                              placeholder="Masukkan deskripsi layanan...">{{ old('description', $paket->description) }}</textarea>

                    @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Harga per Kilogram (Rp)
                    </label>

                    <input type="number"
                           name="price"
                           class="form-control @error('price') is-invalid @enderror"
                           placeholder="Contoh: 5000"
                           min="1"
                           step="1"
                           value="{{ old('price', $paket->price) }}"
                           required>

                    @error('price')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        Durasi Pengerjaan (Hari)
                    </label>

                    <input type="number"
                           name="duration"
                           class="form-control @error('duration') is-invalid @enderror"
                           placeholder="Contoh: 1"
                           min="1"
                           step="1"
                           value="{{ old('duration', $paket->duration) }}"
                           required>

                    @error('duration')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="d-flex gap-2">

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>
                        Simpan Perubahan
                    </button>

                    <a href="{{ route('admin.paket.index') }}"
                       class="btn btn-secondary">
                        Kembali
                    </a>

                </div>

            </form>

        </div>
    </div>

</div>

@endsection
