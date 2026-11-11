
@extends('layouts.app')

@section('title', 'Detail Kurir - LaundryKu')
@section('page-title', 'Detail Kurir')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="mb-4">
        <a href="{{ route('admin.kurir.index') }}"
           class="text-decoration-none text-muted">
            <i class="bi bi-arrow-left me-1"></i>
            Kembali ke Data Kurir
        </a>

        <h4 class="fw-bold mt-3 mb-1">Detail Kurir</h4>
        <p class="text-muted mb-0">
            Informasi lengkap akun kurir LaundryKu.
        </p>
    </div>

    <div class="row g-4">

        {{-- Profil Kurir --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">

                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center mx-auto mb-3"
                         style="width: 90px; height: 90px;">
                        <i class="bi bi-person-fill" style="font-size: 42px;"></i>
                    </div>

                    <h5 class="fw-bold mb-1">{{ $kurir->name }}</h5>

                    <p class="text-muted mb-3">{{ $kurir->email }}</p>

                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">
                        <i class="bi bi-truck me-1"></i>
                        Kurir LaundryKu
                    </span>

                    <hr class="my-4">

                    <div class="text-start">
                        <p class="text-muted small mb-1">ID Kurir</p>
                        <h6 class="fw-semibold">KUR-{{ str_pad($kurir->id, 4, '0', STR_PAD_LEFT) }}</h6>
                    </div>

                </div>
            </div>
        </div>

        {{-- Informasi Kurir --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-person-lines-fill text-primary me-2"></i>
                        Informasi Kurir
                    </h5>
                </div>

                <div class="card-body p-4">

                    <div class="row g-4">

                        <div class="col-md-6">
                            <p class="text-muted small mb-1">Nama Lengkap</p>
                            <h6 class="fw-semibold">{{ $kurir->name }}</h6>
                        </div>

                        <div class="col-md-6">
                            <p class="text-muted small mb-1">Alamat Email</p>
                            <h6 class="fw-semibold">{{ $kurir->email }}</h6>
                        </div>

                        <div class="col-md-6">
                            <p class="text-muted small mb-1">Nomor Telepon</p>
                            <h6 class="fw-semibold">
                                {{ $kurir->phone ?: 'Belum diisi' }}
                            </h6>
                        </div>

                        <div class="col-md-6">
                            <p class="text-muted small mb-1">Role Akun</p>
                            <h6 class="fw-semibold">Courier</h6>
                        </div>

                        <div class="col-12">
                            <p class="text-muted small mb-1">Alamat Lengkap</p>
                            <h6 class="fw-semibold">
                                {{ $kurir->address ?: 'Belum diisi' }}
                            </h6>
                        </div>

                        <div class="col-md-6">
                            <p class="text-muted small mb-1">Tanggal Bergabung</p>
                            <h6 class="fw-semibold">
                                {{ $kurir->created_at
                                    ? \Carbon\Carbon::parse($kurir->created_at)->translatedFormat('d F Y, H:i')
                                    : '-' }}
                            </h6>
                        </div>

                        <div class="col-md-6">
                            <p class="text-muted small mb-1">Terakhir Diperbarui</p>
                            <h6 class="fw-semibold">
                                {{ $kurir->updated_at
                                    ? \Carbon\Carbon::parse($kurir->updated_at)->translatedFormat('d F Y, H:i')
                                    : '-' }}
                            </h6>
                        </div>

                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-end gap-2">

                        <a href="{{ route('admin.kurir.index') }}"
                           class="btn btn-light border">
                            Kembali
                        </a>

                        <a href="{{ route('admin.kurir.edit', $kurir->id) }}"
                           class="btn btn-primary">
                            <i class="bi bi-pencil-square me-1"></i>
                            Edit Kurir
                        </a>

                    </div>

                </div>
            </div>
        </div>

    </div>

</div>

@endsection
