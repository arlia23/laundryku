
@extends('customer.layouts.app')

@section('title', 'Detail Pesanan - LaundryKu')
@section('page-title', 'Detail Pesanan')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Detail Pesanan</h3>
            <p class="text-muted mb-0">
                Pantau perkembangan pesanan laundry kamu.
            </p>
        </div>

        <a href="{{ route('customer.pesanan.index') }}"
           class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Kembali
        </a>
    </div>

    @php
        $statusLabels = [
            'pending' => 'Menunggu Konfirmasi',
            'confirmed' => 'Pesanan Dikonfirmasi',
            'processing' => 'Sedang Dicuci',
            'ready' => 'Siap Diantar / Diambil',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];

        $steps = [
            'pending' => [
                'icon' => 'bi-receipt',
                'title' => 'Pesanan Dibuat',
                'description' => 'Pesanan berhasil dikirim dan menunggu Admin.',
            ],
            'confirmed' => [
                'icon' => 'bi-check-circle',
                'title' => 'Pesanan Dikonfirmasi',
                'description' => 'Admin telah menerima pesanan kamu.',
            ],
            'processing' => [
                'icon' => 'bi-water',
                'title' => 'Sedang Dicuci',
                'description' => 'Pakaian sedang dalam proses laundry.',
            ],
            'ready' => [
                'icon' => 'bi-box-seam',
                'title' => 'Siap Diantar / Diambil',
                'description' => 'Pakaian sudah selesai diproses.',
            ],
            'completed' => [
                'icon' => 'bi-check2-all',
                'title' => 'Pesanan Selesai',
                'description' => 'Pesanan telah selesai diterima.',
            ],
        ];

        $statusOrder = [
            'pending',
            'confirmed',
            'processing',
            'ready',
            'completed',
        ];

        $currentIndex = array_search($pesanan->status, $statusOrder);

        $isCancelled = $pesanan->status === 'cancelled';
    @endphp

    {{-- INFORMASI PESANAN --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                <div>
                    <span class="text-muted small">Kode Pesanan</span>
                    <h4 class="fw-bold mb-1">{{ $pesanan->order_code }}</h4>
                    <span class="text-muted small">
                        <i class="bi bi-calendar3 me-1"></i>
                        {{ \Carbon\Carbon::parse($pesanan->order_date)->format('d M Y') }}
                    </span>
                </div>

                @if($isCancelled)
                    <span class="badge bg-danger rounded-pill px-3 py-2">
                        Pesanan Dibatalkan
                    </span>
                @else
                    <span class="badge bg-primary rounded-pill px-3 py-2">
                        {{ $statusLabels[$pesanan->status] ?? ucfirst($pesanan->status) }}
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="row g-4">

{{-- NOTIFIKASI PEMBAYARAN PAKET ANTAR --}}
@php
    $paketAntar = $detail->contains('nama_paket', 'Cuci Setrika Antar');
@endphp

@if($paketAntar && !$isCancelled && $pesanan->payment_status !== 'paid')

    @if($pesanan->total_price <= 0)
        <div class="col-12">
            <div class="alert alert-primary border-0 shadow-sm d-flex align-items-start gap-3 mb-0">
                <i class="bi bi-info-circle-fill fs-3"></i>
                <div>
                    <strong>Menunggu Penimbangan</strong>
                    <p class="mb-0 mt-1">
                        Silakan tunggu Admin menimbang pakaian dan menentukan total tagihan kamu.
                        Setelah itu, kamu dapat melakukan pembayaran langsung kepada Admin.
                    </p>
                </div>
            </div>
        </div>
    @else
        <div class="col-12">
            <div class="alert alert-warning border-0 shadow-sm d-flex align-items-start gap-3 mb-0">
                <i class="bi bi-wallet2 fs-3"></i>
                <div>
                    <strong>Pembayaran Diperlukan</strong>
                    <p class="mb-0 mt-1">
                        Silakan lakukan pembayaran sebesar
                        <strong>Rp{{ number_format($pesanan->total_price, 0, ',', '.') }}</strong>
                        langsung kepada Admin sebelum pakaian mulai diproses.
                    </p>
                </div>
            </div>
        </div>
    @endif

@endif


        {{-- TIMELINE --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-1">Perkembangan Pesanan</h5>
                    <p class="text-muted small mb-0">
                        Status terbaru proses laundry kamu.
                    </p>
                </div>

                <div class="card-body p-4">

                    @if($isCancelled)

                        <div class="alert alert-danger">
                            <i class="bi bi-x-circle-fill me-2"></i>
                            Pesanan ini telah dibatalkan.
                        </div>

                    @else

                        <div class="tracking-timeline">
                            @foreach($steps as $key => $step)
                                @php
                                    $stepIndex = array_search($key, $statusOrder);
                                    $isDone = $currentIndex !== false && $stepIndex <= $currentIndex;
                                    $isCurrent = $pesanan->status === $key;
                                @endphp

                                <div class="tracking-step {{ $isDone ? 'done' : '' }} {{ $isCurrent ? 'current' : '' }}">

                                    <div class="tracking-icon">
                                        <i class="bi {{ $step['icon'] }}"></i>
                                    </div>

                                    <div class="tracking-content">
                                        <h6 class="fw-bold mb-1">
                                            {{ $step['title'] }}
                                            @if($isCurrent)
                                                <span class="badge bg-primary ms-1">Saat Ini</span>
                                            @endif
                                        </h6>

                                        <p class="text-muted small mb-0">
                                            {{ $step['description'] }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    @endif
                </div>
            </div>
        </div>

        {{-- RINGKASAN --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0">Ringkasan Pesanan</h5>
                </div>

                <div class="card-body px-4 pb-4">

                    @foreach($detail as $item)
                        <div class="mb-3">
                            <span class="text-muted small">Paket Laundry</span>
                            <h6 class="fw-bold mb-0">{{ $item->nama_paket }}</h6>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Berat</span>
                            <strong>
                                {{ $item->quantity > 0 ? $item->quantity . ' kg' : 'Belum ditimbang' }}
                            </strong>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Harga per Kg</span>
                            <strong>
                                Rp{{ number_format($item->price, 0, ',', '.') }}
                            </strong>
                        </div>
                    @endforeach

                    <hr>

                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold">Total Harga</span>
                        <h5 class="fw-bold text-primary mb-0">
                            @if($pesanan->total_price > 0)
                                Rp{{ number_format($pesanan->total_price, 0, ',', '.') }}
                            @else
                                Menunggu Penimbangan
                            @endif
                        </h5>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Pembayaran</span>

                        @if($pesanan->payment_status === 'paid')
                            <span class="badge bg-success">Lunas</span>
                        @else
                            <span class="badge bg-warning text-dark">Belum Dibayar</span>
                        @endif
                    </div>


{{-- PEMBAYARAN DAN UPLOAD BUKTI TRANSFER --}}
@php
    $paketAntar = $detail->contains('nama_paket', 'Cuci Setrika Antar');
    $buktiPath = null;

    foreach (['jpg', 'jpeg', 'png'] as $extension) {
        $path = "payment-proofs/order-{$pesanan->id}.{$extension}";

        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
            $buktiPath = $path;
            break;
        }
    }
@endphp

@if($paketAntar && !$isCancelled && $pesanan->payment_status !== 'paid' && $pesanan->total_price > 0)

    <hr class="my-4">

    <div class="mb-3">
        <h6 class="fw-bold mb-2">
            <i class="bi bi-bank me-2"></i>
            Informasi Rekening Pembayaran
        </h6>

        <div class="p-3 rounded-3 bg-light border">
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Bank</span>
                <strong>BCA</strong>
            </div>

            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Nomor Rekening</span>
                <strong>7634567830</strong>
            </div>

            <div class="d-flex justify-content-between">
                <span class="text-muted">Atas Nama</span>
                <strong>LaundryKu</strong>
            </div>

            <hr>

            <div class="d-flex justify-content-between">
                <strong>Total Transfer</strong>
                <strong class="text-primary">
                    Rp{{ number_format($pesanan->total_price, 0, ',', '.') }}
                </strong>
            </div>
        </div>
    </div>

    <div class="alert alert-warning small">
        <i class="bi bi-info-circle-fill me-1"></i>
        Silakan transfer sesuai nominal di atas, kemudian unggah foto bukti transfer.
        Pakaian akan diproses setelah pembayaran dikonfirmasi Admin.
    </div>

    @if($buktiPath)
        <div class="mb-3">
            <label class="fw-bold mb-2">Bukti Transfer yang Sudah Dikirim</label>

            <img
                src="{{ asset('storage/' . $buktiPath) }}"
                alt="Bukti Transfer"
                class="img-fluid rounded border"
                style="max-height: 250px; width: 100%; object-fit: contain;"
            >

            <div class="small text-success mt-2">
                <i class="bi bi-check-circle-fill me-1"></i>
                Bukti transfer sudah diunggah dan menunggu verifikasi Admin.
            </div>
        </div>
    @endif

    <form
        action="{{ route('customer.pesanan.payment-proof', $pesanan->id) }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf

        <div class="mb-3">
            <label class="form-label fw-semibold">
                {{ $buktiPath ? 'Ganti Foto Bukti Transfer' : 'Upload Foto Bukti Transfer' }}
            </label>

            <input
                type="file"
                name="bukti_pembayaran"
                class="form-control"
                accept=".jpg,.jpeg,.png,image/jpeg,image/png"
                required
            >

            <small class="text-muted">
                Format JPG, JPEG, atau PNG. Maksimal 2 MB.
            </small>

            @error('bukti_pembayaran')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100">
            <i class="bi bi-cloud-arrow-up me-1"></i>
            {{ $buktiPath ? 'Ganti Bukti Transfer' : 'Kirim Bukti Transfer' }}
        </button>
    </form>

@endif


                </div>
            </div>

            {{-- INFORMASI PENGANTARAN --}}
            @if($pengantaran)
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-truck me-2"></i>
                            Informasi Pengantaran
                        </h5>
                    </div>

                    <div class="card-body px-4 pb-4">
                        <div class="mb-3">
                            <span class="text-muted small">Alamat Penjemputan</span>
                            <p class="fw-semibold mb-0">
                                {{ $pengantaran->pickup_address }}
                            </p>
                        </div>

                        <div class="mb-3">
                            <span class="text-muted small">Alamat Pengantaran</span>
                            <p class="fw-semibold mb-0">
                                {{ $pengantaran->delivery_address }}
                            </p>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Penjemputan</span>
                            @if($pengantaran->pickup_status === 'picked_up')
                                <span class="badge bg-success">Sudah Dijemput</span>
                            @else
                                <span class="badge bg-warning text-dark">Menunggu Penjemputan</span>
                            @endif
                        </div>

                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Pengantaran</span>
                            @if($pengantaran->delivery_status === 'delivered')
                                <span class="badge bg-success">Sudah Diantar</span>
                            @else
                                <span class="badge bg-warning text-dark">Belum Diantar</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

<style>
    .tracking-timeline {
        position: relative;
        padding-left: 10px;
    }

    .tracking-step {
        display: flex;
        gap: 18px;
        position: relative;
        padding-bottom: 32px;
        opacity: .45;
    }

    .tracking-step:last-child {
        padding-bottom: 0;
    }

    .tracking-step:not(:last-child)::after {
        content: '';
        position: absolute;
        left: 20px;
        top: 45px;
        width: 2px;
        height: calc(100% - 45px);
        background: #dee2e6;
    }

    .tracking-step.done:not(:last-child)::after {
        background: #198754;
    }

    .tracking-icon {
        width: 42px;
        height: 42px;
        min-width: 42px;
        border-radius: 50%;
        background: #e9ecef;
        color: #6c757d;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        z-index: 1;
    }

    .tracking-step.done {
        opacity: 1;
    }

    .tracking-step.done .tracking-icon {
        background: #d1e7dd;
        color: #198754;
    }

    .tracking-step.current .tracking-icon {
        background: #696cff;
        color: white;
        box-shadow: 0 0 0 5px rgba(105,108,255,.12);
    }

    .tracking-step.current .tracking-content h6 {
        color: #696cff;
    }

    @media(max-width:576px) {
        .tracking-step {
            gap: 12px;
        }
    }
</style>
@endsection
