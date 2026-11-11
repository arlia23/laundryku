
@extends('layouts.app')

@section('title', 'Dashboard Admin - LaundryKu')
@section('page-title', 'Dashboard')

@section('content')

<style>
    .laundry-dashboard {
        color: #263247;
    }

    .laundry-dashboard .welcome-banner {
        position: relative;
        overflow: hidden;
        padding: 30px;
        border-radius: 20px;
        color: white;
        background: linear-gradient(120deg, #243b80, #5269d9);
        box-shadow: 0 10px 30px rgba(53, 79, 173, .18);
    }

    .laundry-dashboard .welcome-banner::before,
    .laundry-dashboard .welcome-banner::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        background: rgba(255,255,255,.07);
    }

    .laundry-dashboard .welcome-banner::before {
        width: 230px;
        height: 230px;
        right: -55px;
        top: -110px;
    }

    .laundry-dashboard .welcome-banner::after {
        width: 150px;
        height: 150px;
        right: 130px;
        bottom: -105px;
    }

    .laundry-dashboard .welcome-content {
        position: relative;
        z-index: 1;
    }

    .laundry-dashboard .welcome-label {
        font-size: 13px;
        opacity: .8;
        letter-spacing: .5px;
    }

    .laundry-dashboard .welcome-title {
        font-size: 26px;
        font-weight: 750;
        margin: 8px 0;
    }

    .laundry-dashboard .welcome-description {
        font-size: 14px;
        opacity: .85;
        margin-bottom: 0;
    }

    .laundry-dashboard .welcome-icon {
        width: 85px;
        height: 85px;
        border-radius: 22px;
        background: rgba(255,255,255,.15);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 42px;
        color: white;
    }

    .laundry-dashboard .section-heading {
        font-size: 18px;
        font-weight: 750;
        color: #263247;
        margin-bottom: 5px;
    }

    .laundry-dashboard .section-description {
        font-size: 13px;
        color: #8993a4;
        margin-bottom: 0;
    }



/* ================================
   RINGKASAN BISNIS
================================ */

.laundry-dashboard .stat-card-new {
    background: #fff;
    border: 1px solid #e9edf4;
    border-radius: 16px;
    padding: 22px;
    min-height: 165px;
    height: 100%;
    display: flex;
    flex-direction: column;
    box-shadow: 0 4px 15px rgba(25, 42, 70, .04);
    transition: all .25s ease;
}

.laundry-dashboard .stat-card-new:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 25px rgba(25, 42, 70, .09);
    border-color: #dce3ef;
}

.laundry-dashboard .stat-top {
    display: flex;
    align-items: center;
    gap: 13px;
    margin-bottom: 20px;
}

.laundry-dashboard .stat-icon-new {
    width: 45px;
    height: 45px;
    min-width: 45px;
    border-radius: 13px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 21px;
}

.laundry-dashboard .stat-label {
    font-size: 13px;
    color: #7d899b;
    font-weight: 600;
    margin: 0;
}

.laundry-dashboard .stat-number {
    font-size: 30px;
    line-height: 1.3;
    font-weight: 750;
    color: #263247;
    margin-top: auto;
    margin-bottom: 0;
    overflow-wrap: anywhere;
}

.laundry-dashboard .stat-note {
    font-size: 12px;
    color: #9aa4b3;
    margin-top: 7px;
    margin-bottom: 0;
}

@media (max-width: 767px) {
    .laundry-dashboard .stat-card-new {
        min-height: 150px;
        padding: 17px;
    }

    .laundry-dashboard .stat-number {
        font-size: 25px;
    }

    .laundry-dashboard .stat-top {
        gap: 9px;
        margin-bottom: 17px;
    }
}


.laundry-dashboard .stat-note {
    font-size: 12px;
    color: #a0a8b5;
    margin-top: 7px;
    margin-bottom: 0;
}

@media (max-width: 767px) {
    .laundry-dashboard .stat-card-new {
        padding: 17px;
        min-height: 145px;
    }

    .laundry-dashboard .stat-number {
        font-size: 23px;
    }
}


    .laundry-dashboard .finance-card {
        border-radius: 17px;
        padding: 23px;
        color: white;
        height: 100%;
        position: relative;
        overflow: hidden;
    }

    .laundry-dashboard .finance-card::after {
        content: "";
        position: absolute;
        width: 130px;
        height: 130px;
        border-radius: 50%;
        right: -40px;
        bottom: -55px;
        background: rgba(255,255,255,.10);
    }

    .laundry-dashboard .finance-income {
        background: linear-gradient(130deg, #119b72, #23b88c);
    }

    .laundry-dashboard .finance-unpaid {
        background: linear-gradient(130deg, #df8a24, #f2b44e);
    }

    .laundry-dashboard .finance-orders {
        background: linear-gradient(130deg, #4359c7, #687be9);
    }

    .laundry-dashboard .finance-icon {
        width: 43px;
        height: 43px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: rgba(255,255,255,.17);
        font-size: 21px;
    }

    .laundry-dashboard .finance-label {
        font-size: 13px;
        opacity: .85;
        margin: 17px 0 7px;
    }

    .laundry-dashboard .finance-value {
        font-size: 25px;
        font-weight: 750;
        margin-bottom: 8px;
        overflow-wrap: anywhere;
    }

    .laundry-dashboard .finance-note {
        font-size: 12px;
        opacity: .85;
        margin-bottom: 0;
    }

    .laundry-dashboard .dashboard-panel {
        background: #fff;
        border: 1px solid #edf0f5;
        border-radius: 17px;
        box-shadow: 0 4px 15px rgba(25, 42, 70, .035);
    }

    .laundry-dashboard .table {
        margin-bottom: 0;
    }

    .laundry-dashboard .table thead th {
        background: #f7f8fc;
        color: #788397;
        font-size: 12px;
        font-weight: 650;
        text-transform: uppercase;
        letter-spacing: .4px;
        padding: 15px 17px;
        border-bottom: 1px solid #edf0f5;
        white-space: nowrap;
    }

    .laundry-dashboard .table tbody td {
        padding: 16px 17px;
        font-size: 13px;
        border-bottom: 1px solid #f0f2f6;
        color: #4b566a;
        white-space: nowrap;
    }

    .laundry-dashboard .table tbody tr:last-child td {
        border-bottom: none;
    }

    .laundry-dashboard .order-code {
        font-weight: 700;
        color: #354db2;
    }

    .laundry-dashboard .customer-avatar {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: #edf0ff;
        color: #5269d9;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        margin-right: 9px;
    }

    .laundry-dashboard .badge-status {
        padding: 7px 10px;
        font-size: 11px;
        border-radius: 7px;
        font-weight: 650;
    }

    .laundry-dashboard .empty-state {
        padding: 45px 15px;
        text-align: center;
        color: #a0a8b5;
    }

    .laundry-dashboard .empty-state i {
        font-size: 38px;
        display: block;
        margin-bottom: 12px;
    }

    @media (max-width: 767px) {
        .laundry-dashboard .welcome-banner {
            padding: 23px;
        }

        .laundry-dashboard .welcome-title {
            font-size: 21px;
        }

        .laundry-dashboard .welcome-icon {
            display: none;
        }

        .laundry-dashboard .stat-number {
            font-size: 23px;
        }

        .laundry-dashboard .finance-value {
            font-size: 21px;
        }
    }
</style>

<div class="laundry-dashboard">

    {{-- Welcome Banner --}}
    <div class="welcome-banner mb-5">
        <div class="welcome-content d-flex justify-content-between align-items-center">
            <div>
                <div class="welcome-label">
                    LAUNDRYKU ADMIN DASHBOARD
                </div>

                <h3 class="welcome-title">
                    Halo, {{ auth()->user()->name }}! 👋
                </h3>

                <p class="welcome-description">
                    Selamat datang kembali. Kelola operasional laundry dengan lebih mudah.
                </p>
            </div>

            <div class="welcome-icon">
                <i class="bi bi-shop"></i>
            </div>
        </div>
    </div>

  

{{-- Statistik Umum --}}
<div class="mb-3">
    <h5 class="section-heading">Ringkasan Bisnis</h5>
    <p class="section-description">
        Gambaran umum aktivitas LaundryKu.
    </p>
</div>

<div class="row g-3 mb-4">

    {{-- Pelanggan --}}
    <div class="col-12 col-sm-6 col-xl-4">
        <div class="stat-card-new">
            <div class="stat-top">
                <div class="stat-icon-new bg-primary-subtle text-primary">
                    <i class="bi bi-people"></i>
                </div>
                <p class="stat-label">Total Pelanggan</p>
            </div>
            <h3 class="stat-number">{{ $stats['customers'] }}</h3>
            <p class="stat-note">Pelanggan terdaftar di LaundryKu</p>
        </div>
    </div>

    {{-- Pesanan --}}
    <div class="col-12 col-sm-6 col-xl-4">
        <div class="stat-card-new">
            <div class="stat-top">
                <div class="stat-icon-new bg-success-subtle text-success">
                    <i class="bi bi-bag-check"></i>
                </div>
                <p class="stat-label">Total Pesanan</p>
            </div>
            <h3 class="stat-number">{{ $stats['orders'] }}</h3>
            <p class="stat-note">Seluruh pesanan yang tercatat</p>
        </div>
    </div>

    {{-- Mesin --}}
    <div class="col-12 col-sm-6 col-xl-4">
        <div class="stat-card-new">
            <div class="stat-top">
                <div class="stat-icon-new bg-warning-subtle text-warning">
                    <i class="bi bi-gear"></i>
                </div>
                <p class="stat-label">Mesin Laundry</p>
            </div>
            <h3 class="stat-number">{{ $stats['machines'] }}</h3>
            <p class="stat-note">Jumlah mesin yang terdaftar</p>
        </div>
    </div>

    {{-- Paket --}}
    <div class="col-12 col-sm-6 col-xl-4">
        <div class="stat-card-new">
            <div class="stat-top">
                <div class="stat-icon-new bg-info-subtle text-info">
                    <i class="bi bi-box-seam"></i>
                </div>
                <p class="stat-label">Paket Laundry</p>
            </div>
            <h3 class="stat-number">{{ $stats['packages'] }}</h3>
            <p class="stat-note">Pilihan layanan tersedia</p>
        </div>
    </div>

    {{-- Kurir --}}
    <div class="col-12 col-sm-6 col-xl-4">
        <div class="stat-card-new">
            <div class="stat-top">
                <div class="stat-icon-new bg-danger-subtle text-danger">
                    <i class="bi bi-truck"></i>
                </div>
                <p class="stat-label">Total Kurir</p>
            </div>
            <h3 class="stat-number">{{ $stats['couriers'] }}</h3>
            <p class="stat-note">Kurir terdaftar di LaundryKu</p>
        </div>
    </div>

    {{-- Nilai Pesanan --}}
    <div class="col-12 col-sm-6 col-xl-4">
        <div class="stat-card-new">
            <div class="stat-top">
                <div class="stat-icon-new bg-secondary-subtle text-secondary">
                    <i class="bi bi-wallet2"></i>
                </div>
                <p class="stat-label">Nilai Pesanan Aktif</p>
            </div>
            <h3 class="stat-number">
                Rp{{ number_format($stats['total_order_value'], 0, ',', '.') }}
            </h3>
            <p class="stat-note">Tidak termasuk pesanan batal</p>
        </div>
    </div>

</div>



    {{-- Ringkasan Keuangan --}}
    <div class="mb-3">
        <h5 class="section-heading">Ringkasan Keuangan</h5>
        <p class="section-description">
            Pantau pemasukan dan tagihan LaundryKu.
        </p>
    </div>

    <div class="row g-3 mb-4">

        {{-- Pendapatan --}}
        <div class="col-md-6 col-xl-4">
            <div class="finance-card finance-income">
                <div class="finance-icon">
                    <i class="bi bi-wallet2"></i>
                </div>
                <p class="finance-label">Pendapatan Diterima</p>
                <h3 class="finance-value">
                    Rp{{ number_format($stats['paid_income'], 0, ',', '.') }}
                </h3>
                <p class="finance-note">
                    <i class="bi bi-check-circle me-1"></i>
                    {{ $stats['paid_orders'] }} transaksi lunas
                </p>
            </div>
        </div>

        {{-- Belum Bayar --}}
        <div class="col-md-6 col-xl-4">
            <div class="finance-card finance-unpaid">
                <div class="finance-icon">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <p class="finance-label">Tagihan Belum Dibayar</p>
                <h3 class="finance-value">
                    Rp{{ number_format($stats['unpaid_total'], 0, ',', '.') }}
                </h3>
                <p class="finance-note">
                    <i class="bi bi-clock me-1"></i>
                    {{ $stats['unpaid_orders'] }} transaksi belum lunas
                </p>
            </div>
        </div>

        {{-- Transaksi Aktif --}}
        <div class="col-md-6 col-xl-4">
            <div class="finance-card finance-orders">
                <div class="finance-icon">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>
                <p class="finance-label">Total Transaksi Aktif</p>
                <h3 class="finance-value">
                    {{ $stats['paid_orders'] + $stats['unpaid_orders'] }}
                </h3>
                <p class="finance-note">
                    <i class="bi bi-receipt me-1"></i>
                    Transaksi tidak dibatalkan
                </p>
            </div>
        </div>

    </div>

    {{-- Pesanan Terbaru --}}
    <div class="dashboard-panel">

        <div class="p-4 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="section-heading mb-1">Pesanan Terbaru</h5>
                <p class="section-description">
                    Lima transaksi terakhir LaundryKu.
                </p>
            </div>

            <a href="{{ route('admin.pesanan.index') }}"
               class="btn btn-outline-primary btn-sm">
                Lihat Semua
                <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="table-responsive">
            <table class="table align-middle">

                <thead>
                    <tr>
                        <th>Kode Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Tanggal</th>
                        <th>Total Harga</th>
                        <th>Status Pesanan</th>
                        <th>Pembayaran</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($latestOrders as $order)

                        @php
                            $statusClass = [
                                'pending' => 'bg-warning-subtle text-warning-emphasis',
                                'confirmed' => 'bg-info-subtle text-info-emphasis',
                                'processing' => 'bg-primary-subtle text-primary',
                                'ready' => 'bg-success-subtle text-success',
                                'completed' => 'bg-secondary-subtle text-secondary',
                                'cancelled' => 'bg-danger-subtle text-danger',
                            ];

                            $statusLabel = [
                                'pending' => 'Pending',
                                'confirmed' => 'Dikonfirmasi',
                                'processing' => 'Diproses',
                                'ready' => 'Siap Diambil',
                                'completed' => 'Selesai',
                                'cancelled' => 'Dibatalkan',
                            ];
                        @endphp

                        <tr>
                            <td>
                                <span class="order-code">
                                    {{ $order->order_code }}
                                </span>
                            </td>

                            <td>
                                <span class="customer-avatar">
                                    {{ strtoupper(substr($order->nama_pelanggan, 0, 1)) }}
                                </span>
                                {{ $order->nama_pelanggan }}
                            </td>

                            <td>
                                {{ $order->order_date
                                    ? \Carbon\Carbon::parse($order->order_date)->format('d/m/Y')
                                    : '-' }}
                            </td>

                            <td class="fw-semibold">
                                Rp{{ number_format($order->total_price, 0, ',', '.') }}
                            </td>

                            <td>
                                <span class="badge badge-status {{ $statusClass[$order->status] ?? 'bg-secondary-subtle text-secondary' }}">
                                    {{ $statusLabel[$order->status] ?? ucfirst($order->status) }}
                                </span>
                            </td>

                            <td>
                                @if ($order->payment_status === 'paid')
                                    <span class="badge badge-status bg-success-subtle text-success">
                                        <i class="bi bi-check-circle me-1"></i>
                                        Lunas
                                    </span>
                                @else
                                    <span class="badge badge-status bg-warning-subtle text-warning-emphasis">
                                        <i class="bi bi-clock me-1"></i>
                                        Belum Bayar
                                    </span>
                                @endif
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="bi bi-inbox"></i>
                                    <div class="fw-semibold">Belum ada pesanan</div>
                                    <small>Pesanan yang masuk akan ditampilkan di sini.</small>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        <div class="px-4 py-3 border-top d-flex justify-content-between align-items-center">
            <small class="text-muted">
                Menampilkan maksimal 5 pesanan terbaru.
            </small>

            <a href="{{ route('admin.pesanan.index') }}"
               class="text-decoration-none small fw-semibold">
                Kelola Pesanan
                <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

    </div>

</div>

@endsection
