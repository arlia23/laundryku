
@extends('customer.layouts.app')

@section('title', 'Dashboard Customer - LaundryKu')
@section('page-title', 'Dashboard')

@section('content')

<div class="customer-dashboard">

    {{-- HEADER / WELCOME --}}
    <div class="welcome-card mb-4">
        <div class="welcome-content">
            <span class="welcome-label">
                <i class="bi bi-stars me-1"></i> CUSTOMER AREA
            </span>

            <h3>Halo, {{ Auth::user()->name }}! 👋</h3>

            <p>
                Selamat datang di LaundryKu.
                Kami siap membantu pakaianmu tetap bersih dan wangi.
            </p>

            <a href="{{ route('customer.pesanan.create') }}"
               class="btn btn-light welcome-button">
                <i class="bi bi-plus-circle me-2"></i>
                Buat Pesanan
            </a>
        </div>

        <div class="welcome-decoration">
            <i class="bi bi-basket2-fill"></i>
        </div>
    </div>

    {{-- RINGKASAN PESANAN --}}
    <div class="section-heading mb-3">
        <div>
            <h5>Ringkasan Pesanan</h5>
            <p>Pantau aktivitas laundry kamu.</p>
        </div>
    </div>

    <div class="row g-3 mb-4">

        <div class="col-6 col-xl-3">
            <div class="summary-card">
                <div class="summary-top">
                    <div class="summary-icon blue">
                        <i class="bi bi-receipt"></i>
                    </div>
                    <span class="summary-caption">Semua</span>
                </div>
                <div class="summary-label">Total Pesanan</div>
                <div class="summary-value">
                    {{ $ringkasan->total_pesanan ?? 0 }}
                </div>
                <small>Seluruh pesanan kamu</small>
            </div>
        </div>

        <div class="col-6 col-xl-3">
            <div class="summary-card">
                <div class="summary-top">
                    <div class="summary-icon orange">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                    <span class="summary-caption">Pending</span>
                </div>
                <div class="summary-label">Menunggu</div>
                <div class="summary-value">
                    {{ $ringkasan->menunggu ?? 0 }}
                </div>
                <small>Menunggu konfirmasi</small>
            </div>
        </div>

        <div class="col-6 col-xl-3">
            <div class="summary-card">
                <div class="summary-top">
                    <div class="summary-icon purple">
                        <i class="bi bi-arrow-repeat"></i>
                    </div>
                    <span class="summary-caption">Proses</span>
                </div>
                <div class="summary-label">Diproses</div>
                <div class="summary-value">
                    {{ $ringkasan->diproses ?? 0 }}
                </div>
                <small>Sedang dikerjakan</small>
            </div>
        </div>

        <div class="col-6 col-xl-3">
            <div class="summary-card">
                <div class="summary-top">
                    <div class="summary-icon green">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <span class="summary-caption">Selesai</span>
                </div>
                <div class="summary-label">Pesanan Selesai</div>
                <div class="summary-value">
                    {{ $ringkasan->selesai ?? 0 }}
                </div>
                <small>Pesanan telah selesai</small>
            </div>
        </div>

    </div>

    {{-- PESANAN TERBARU --}}
    <div class="content-card">

        <div class="content-card-header">
            <div>
                <h5>Pesanan Terbaru</h5>
                <p>Lihat perkembangan pesanan laundry kamu.</p>
            </div>

            <a href="{{ route('customer.pesanan.index') }}"
               class="btn btn-outline-primary btn-sm">
                Lihat Semua
                <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        @forelse($pesananTerbaru as $pesanan)

            @php
                $status = [
                    'pending' => ['Menunggu', 'warning'],
                    'confirmed' => ['Dikonfirmasi', 'info'],
                    'processing' => ['Sedang Diproses', 'primary'],
                    'ready' => ['Siap Diambil / Diantar', 'success'],
                    'completed' => ['Selesai', 'success'],
                    'cancelled' => ['Dibatalkan', 'danger'],
                ];

                $statusInfo = $status[$pesanan->status]
                    ?? ['Tidak diketahui', 'secondary'];
            @endphp

            <a href="{{ route('customer.pesanan.show', $pesanan->id) }}"
               class="order-item">

                <div class="order-icon">
                    <i class="bi bi-bag-check"></i>
                </div>

                <div class="order-info">
                    <div class="order-code">
                        {{ $pesanan->order_code }}
                    </div>

                    <div class="order-date">
                        <i class="bi bi-calendar3 me-1"></i>
                        {{ \Carbon\Carbon::parse($pesanan->order_date)->format('d M Y') }}
                    </div>
                </div>

                <div class="order-total">
                    <small>Total Pembayaran</small>
                    <strong>
                        Rp{{ number_format((float) $pesanan->total_price, 0, ',', '.') }}
                    </strong>
                </div>

                <div class="order-status">
                    <span class="badge-status status-{{ $statusInfo[1] }}">
                        {{ $statusInfo[0] }}
                    </span>
                </div>

                <div class="order-arrow">
                    <i class="bi bi-chevron-right"></i>
                </div>

            </a>

        @empty

            <div class="empty-state">
                <div class="empty-icon">
                    <i class="bi bi-basket3"></i>
                </div>

                <h6>Belum Ada Pesanan</h6>

                <p>
                    Kamu belum memiliki pesanan laundry.
                    Yuk, buat pesanan pertamamu!
                </p>

                <a href="{{ route('customer.pesanan.create') }}"
                   class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>
                    Buat Pesanan Pertama
                </a>
            </div>

        @endforelse

    </div>

</div>

<style>
    .customer-dashboard {
        color: #1e293b;
    }

    /* WELCOME */
    .welcome-card {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        min-height: 220px;
        padding: 32px 38px;
        overflow: hidden;
        border-radius: 20px;
        color: #fff;
        background: linear-gradient(115deg, #1e40af, #2563eb 65%, #60a5fa);
        box-shadow: 0 12px 30px rgba(37, 99, 235, .14);
    }

    .welcome-content {
        position: relative;
        z-index: 2;
        max-width: 620px;
    }

    .welcome-label {
        display: inline-block;
        margin-bottom: 10px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1.8px;
        color: #dbeafe;
    }

    .welcome-card h3 {
        margin-bottom: 9px;
        font-size: 28px;
        font-weight: 800;
    }

    .welcome-card p {
        max-width: 500px;
        margin-bottom: 18px;
        color: #dbeafe;
        line-height: 1.7;
    }

    .welcome-button {
        padding: 10px 18px;
        border: 0;
        border-radius: 10px;
        color: #1d4ed8;
        font-weight: 700;
        transition: .2s;
    }

    .welcome-button:hover {
        color: #1e40af;
        background: #eff6ff;
        transform: translateY(-2px);
    }

    .welcome-decoration {
        position: absolute;
        right: 55px;
        top: 50%;
        transform: translateY(-50%);
        color: rgba(255, 255, 255, .14);
        font-size: 150px;
        pointer-events: none;
    }

    /* SECTION HEADING */
    .section-heading h5,
    .content-card-header h5 {
        margin-bottom: 5px;
        font-size: 17px;
        font-weight: 800;
        color: #1e293b;
    }

    .section-heading p,
    .content-card-header p {
        margin-bottom: 0;
        font-size: 13px;
        color: #94a3b8;
    }

    /* SUMMARY */
    .summary-card {
        height: 100%;
        padding: 20px;
        background: #fff;
        border: 1px solid #edf0f5;
        border-radius: 16px;
        transition: .2s ease;
    }

    .summary-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(15, 23, 42, .06);
    }

    .summary-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 17px;
    }

    .summary-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        border-radius: 13px;
        font-size: 20px;
    }

    .summary-icon.blue {
        background: #eff6ff;
        color: #2563eb;
    }

    .summary-icon.orange {
        background: #fff7ed;
        color: #ea580c;
    }

    .summary-icon.purple {
        background: #f5f3ff;
        color: #7c3aed;
    }

    .summary-icon.green {
        background: #ecfdf5;
        color: #059669;
    }

    .summary-caption {
        padding: 5px 9px;
        border-radius: 20px;
        background: #f8fafc;
        color: #94a3b8;
        font-size: 10px;
        font-weight: 700;
    }

    .summary-label {
        color: #64748b;
        font-size: 13px;
    }

    .summary-value {
        margin: 5px 0;
        color: #1e293b;
        font-size: 29px;
        font-weight: 800;
    }

    .summary-card small {
        color: #94a3b8;
        font-size: 11px;
    }

    /* CONTENT */
    .content-card {
        padding: 25px;
        background: #fff;
        border: 1px solid #edf0f5;
        border-radius: 17px;
    }

    .content-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 20px;
    }

    .content-card-header .btn {
        border-radius: 9px;
        font-weight: 600;
    }

    /* ORDER ITEM */
    .order-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 17px 12px;
        border-top: 1px solid #f1f5f9;
        text-decoration: none;
        color: inherit;
        transition: .2s ease;
    }

    .order-item:hover {
        background: #f8fbff;
        color: inherit;
        border-radius: 12px;
    }

    .order-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        width: 45px;
        height: 45px;
        border-radius: 13px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 20px;
    }

    .order-info {
        flex: 1;
        min-width: 130px;
    }

    .order-code {
        margin-bottom: 5px;
        color: #1e293b;
        font-size: 14px;
        font-weight: 750;
    }

    .order-date {
        color: #94a3b8;
        font-size: 12px;
    }

    .order-total {
        min-width: 145px;
        text-align: right;
    }

    .order-total small {
        display: block;
        margin-bottom: 5px;
        color: #94a3b8;
        font-size: 11px;
    }

    .order-total strong {
        color: #1e293b;
        font-size: 13px;
    }

    .badge-status {
        display: inline-block;
        padding: 7px 11px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .status-warning {
        color: #92400e;
        background: #fef3c7;
    }

    .status-info {
        color: #075985;
        background: #e0f2fe;
    }

    .status-primary {
        color: #1d4ed8;
        background: #dbeafe;
    }

    .status-success {
        color: #047857;
        background: #d1fae5;
    }

    .status-danger {
        color: #b91c1c;
        background: #fee2e2;
    }

    .status-secondary {
        color: #475569;
        background: #e2e8f0;
    }

    .order-arrow {
        color: #cbd5e1;
        font-size: 15px;
        transition: .2s;
    }

    .order-item:hover .order-arrow {
        color: #2563eb;
        transform: translateX(3px);
    }

    /* EMPTY STATE */
    .empty-state {
        padding: 45px 15px;
        text-align: center;
    }

    .empty-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 78px;
        height: 78px;
        margin: 0 auto 17px;
        border-radius: 50%;
        background: #eff6ff;
        color: #3b82f6;
        font-size: 32px;
    }

    .empty-state h6 {
        color: #1e293b;
        font-size: 16px;
        font-weight: 800;
    }

    .empty-state p {
        max-width: 350px;
        margin: 8px auto 18px;
        color: #94a3b8;
        font-size: 13px;
        line-height: 1.7;
    }

    .empty-state .btn {
        padding: 10px 17px;
        border-radius: 9px;
        font-weight: 600;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .welcome-card {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: space-between;
    min-height: 220px;
    padding: 32px 38px;
    overflow: hidden;
    border-radius: 20px;
    color: white;

    background-color: #2563eb;
    background-image:
        radial-gradient(circle, rgba(255,255,255,.20) 2px, transparent 2.5px),
        linear-gradient(115deg, #1e40af, #2563eb 65%, #60a5fa);

    background-size: 22px 22px, cover;
    background-position: right top, center;

    box-shadow: 0 12px 30px rgba(37, 99, 235, .14);
}

        .welcome-decoration {
            right: 15px;
            font-size: 95px;
        }

        .content-card {
            padding: 18px;
        }

        .order-item {
            flex-wrap: wrap;
            gap: 12px;
        }

        .order-info {
            flex: 1;
        }

        .order-total {
            min-width: auto;
            margin-left: 57px;
            text-align: left;
        }

        .order-status {
            margin-left: auto;
        }

        .order-arrow {
            display: none;
        }
    }

    @media (max-width: 420px) {
        .welcome-decoration {
            opacity: .5;
            right: -15px;
        }

        .welcome-card h3 {
            font-size: 20px;
        }

        .summary-card {
            padding: 15px;
        }

        .summary-value {
            font-size: 25px;
        }

        .content-card-header {
            align-items: flex-start;
        }
    }
</style>

@endsection
