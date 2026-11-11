
@extends('courier.layouts.app')

@section('title', 'Dashboard Kurir - LaundryKu')
@section('page-title', 'Dashboard Kurir')

@section('content')

{{-- HEADER --}}
<div class="mb-4">
    <h4 class="fw-bold mb-1">
        Selamat Datang, {{ auth()->user()->name }}!
    </h4>
    <p class="text-muted mb-0">
        Pantau aktivitas penjemputan dan pengantaran laundry kamu.
    </p>
</div>

{{-- RINGKASAN TUGAS --}}
<div class="row g-3 mb-4">

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-3 bg-primary bg-opacity-10 p-3 me-3">
                    <i class="bi bi-truck text-primary fs-3"></i>
                </div>
                <div>
                    <p class="text-muted mb-1 small">Total Tugas</p>
                    <h3 class="fw-bold mb-0">{{ $totalTugas }}</h3>
                    <small class="text-muted">Seluruh penugasan</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-3 bg-warning bg-opacity-10 p-3 me-3">
                    <i class="bi bi-box-seam text-warning fs-3"></i>
                </div>
                <div>
                    <p class="text-muted mb-1 small">Menunggu Jemput</p>
                    <h3 class="fw-bold mb-0">{{ $menungguPenjemputan }}</h3>
                    <small class="text-muted">Belum dijemput</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-3 bg-info bg-opacity-10 p-3 me-3">
                    <i class="bi bi-bicycle text-info fs-3"></i>
                </div>
                <div>
                    <p class="text-muted mb-1 small">Siap Diantar</p>
                    <h3 class="fw-bold mb-0">{{ $menungguPengantaran }}</h3>
                    <small class="text-muted">Menunggu pengantaran</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-3 bg-success bg-opacity-10 p-3 me-3">
                    <i class="bi bi-check-circle text-success fs-3"></i>
                </div>
                <div>
                    <p class="text-muted mb-1 small">Tugas Selesai</p>
                    <h3 class="fw-bold mb-0">{{ $tugasSelesai }}</h3>
                    <small class="text-muted">Berhasil diantarkan</small>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- INFORMASI TUGAS --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="d-flex align-items-start">
            <div class="rounded-3 bg-primary bg-opacity-10 p-3 me-3">
                <i class="bi bi-info-circle text-primary fs-3"></i>
            </div>

            <div>
                <h6 class="fw-bold mb-2">Informasi Tugas Kurir</h6>
                <p class="text-muted mb-0">
                    Periksa tugas penjemputan dan pengantaran secara berkala.
                    Pastikan pakaian sudah dijemput sebelum dikirim ke laundry
                    dan pastikan pakaian diterima pelanggan sebelum menyelesaikan tugas.
                </p>
            </div>
        </div>
    </div>
</div>

{{-- TUGAS TERBARU --}}
<div class="card border-0 shadow-sm">

    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h5 class="fw-bold mb-1">Tugas Terbaru</h5>
            <small class="text-muted">Lima penugasan terbaru untuk kamu</small>
        </div>

        <a href="{{ route('courier.pengantaran.index') }}"
           class="btn btn-sm btn-primary">
            Lihat Semua
            <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>

    <div class="card-body p-3 p-md-4">

        @forelse($tugasTerbaru as $item)

            <div class="border rounded-3 p-3 mb-3">

                {{-- HEADER PESANAN --}}
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">

                    <div>
                        <span class="text-muted small">Nomor Pesanan</span>
                        <h6 class="fw-bold text-primary mb-0">
                            {{ $item->order_code }}
                        </h6>
                    </div>

                    {{-- STATUS TUGAS --}}
                    <div>
                        @if($item->delivery_status === 'delivered')
                            <span class="badge bg-success">
                                <i class="bi bi-check-circle me-1"></i>
                                Selesai
                            </span>

                        @elseif($item->pickup_status === 'pending')
                            <span class="badge bg-warning text-dark">
                                <i class="bi bi-box-seam me-1"></i>
                                Menunggu Penjemputan
                            </span>

                        @elseif($item->status_pesanan === 'ready' && $item->delivery_status === 'pending')
                            <span class="badge bg-info text-dark">
                                <i class="bi bi-bicycle me-1"></i>
                                Siap Diantar
                            </span>

                        @elseif($item->pickup_status === 'picked_up')
                            <span class="badge bg-primary">
                                <i class="bi bi-arrow-repeat me-1"></i>
                                Dalam Proses Laundry
                            </span>

                        @else
                            <span class="badge bg-secondary">
                                {{ ucfirst($item->status_pesanan) }}
                            </span>
                        @endif
                    </div>

                </div>

                <hr class="my-3">

                {{-- INFORMASI PELANGGAN --}}
                <div class="mb-3">

                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-person-circle text-primary me-2 fs-5"></i>
                        <div>
                            <small class="text-muted d-block">Nama Pelanggan</small>
                            <span class="fw-semibold">
                                {{ $item->nama_pelanggan }}
                            </span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center">
                        <i class="bi bi-telephone text-primary me-2 fs-5"></i>
                        <div>
                            <small class="text-muted d-block">Nomor Telepon</small>

                            @if($item->telepon_pelanggan)
                                <a href="tel:{{ $item->telepon_pelanggan }}"
                                   class="text-decoration-none">
                                    {{ $item->telepon_pelanggan }}
                                </a>
                            @else
                                <span class="text-muted">Belum tersedia</span>
                            @endif
                        </div>
                    </div>

                </div>

                {{-- ALAMAT PICKUP --}}
                <div class="bg-light rounded-3 p-3 mb-2">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-geo-alt-fill text-warning fs-5 me-2"></i>
                        <div>
                            <small class="text-muted d-block fw-semibold">
                                Alamat Penjemputan
                            </small>
                            <span class="small">
                                {{ $item->pickup_address }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- ALAMAT DELIVERY --}}
                <div class="bg-light rounded-3 p-3 mb-3">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-geo-fill text-success fs-5 me-2"></i>
                        <div>
                            <small class="text-muted d-block fw-semibold">
                                Alamat Pengantaran
                            </small>
                            <span class="small">
                                {{ $item->delivery_address }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- INFORMASI PESANAN --}}
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                    <div>
                        <small class="text-muted d-block">Tanggal Pesanan</small>
                        <span class="small fw-semibold">
                            {{ \Carbon\Carbon::parse($item->order_date)->format('d M Y') }}
                        </span>
                    </div>

                    <div class="text-end">
                        <small class="text-muted d-block">Total Pesanan</small>
                        <span class="fw-bold text-primary">
                            Rp{{ number_format($item->total_price, 0, ',', '.') }}
                        </span>
                    </div>

                </div>

            </div>

        @empty

            <div class="text-center py-5">
                <div class="mb-3">
                    <i class="bi bi-truck fs-1 text-muted"></i>
                </div>

                <h6 class="fw-bold">Belum Ada Tugas</h6>

                <p class="text-muted mb-3">
                    Saat ini belum ada penugasan pengantaran untuk kamu.
                    Tugas baru dari admin akan muncul di sini.
                </p>

                <a href="{{ route('courier.pengantaran.index') }}"
                   class="btn btn-outline-primary btn-sm">
                    Periksa Daftar Tugas
                </a>
            </div>

        @endforelse

    </div>
</div>

@endsection
