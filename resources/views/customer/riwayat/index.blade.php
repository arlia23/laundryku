
@extends('customer.layouts.app')

@section('title', 'Riwayat Pesanan - LaundryKu')
@section('page-title', 'Riwayat Pesanan')

@section('content')

<div class="history-page">

    <div class="history-header">
        <div>
            <h4>Riwayat Pesanan</h4>
            <p>Daftar laundry yang sudah selesai dan lunas.</p>
        </div>

        <div class="history-total">
            <i class="bi bi-check-circle-fill"></i>
            {{ $pesanan->total() }} Pesanan
        </div>
    </div>

    <div class="history-card">

        @forelse($pesanan as $item)

            <a href="{{ route('customer.pesanan.show', $item->id) }}"
               class="history-item">

                <div class="history-icon">
                    <i class="bi bi-bag-check-fill"></i>
                </div>

                <div class="history-info">
                    <strong>{{ $item->order_code }}</strong>
                    <small>
                        <i class="bi bi-calendar3 me-1"></i>
                        {{ \Carbon\Carbon::parse($item->order_date)->format('d M Y') }}
                    </small>
                    <span>{{ $item->nama_paket }}</span>
                </div>

                <div class="history-price">
                    <small>Total Pembayaran</small>
                    <strong>
                        Rp{{ number_format((float) $item->total_price, 0, ',', '.') }}
                    </strong>
                    <div class="history-badges">
                        <span class="badge bg-success">Selesai</span>
                        <span class="badge bg-primary">Lunas</span>
                    </div>
                </div>

                <i class="bi bi-chevron-right history-arrow"></i>

            </a>

        @empty

            <div class="empty-history">
                <div class="empty-icon">
                    <i class="bi bi-clock-history"></i>
                </div>

                <h5>Belum Ada Riwayat Pesanan</h5>
                <p>
                    Pesanan yang sudah selesai dan lunas
                    akan muncul di halaman ini.
                </p>

                <a href="{{ route('customer.pesanan.index') }}"
                   class="btn btn-primary">
                    Lihat Pesanan Saya
                </a>
            </div>

        @endforelse

        @if($pesanan->hasPages())
            <div class="history-pagination">
                {{ $pesanan->links() }}
            </div>
        @endif

    </div>

</div>

<style>
.history-page {
    color: #1e293b;
}

.history-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    margin-bottom: 22px;
}

.history-header h4 {
    font-size: 21px;
    font-weight: 800;
    margin-bottom: 5px;
}

.history-header p {
    color: #94a3b8;
    font-size: 13px;
    margin: 0;
}

.history-total {
    background: #dcfce7;
    color: #15803d;
    padding: 9px 14px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 700;
}

.history-card {
    background: #fff;
    border: 1px solid #edf0f5;
    border-radius: 16px;
    padding: 10px 22px;
}

.history-item {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 19px 10px;
    border-bottom: 1px solid #f1f5f9;
    color: inherit;
    text-decoration: none;
    transition: .2s;
}

.history-item:last-of-type {
    border-bottom: none;
}

.history-item:hover {
    background: #f8fbff;
    color: inherit;
    border-radius: 12px;
}

.history-icon {
    width: 46px;
    height: 46px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 13px;
    background: #dcfce7;
    color: #16a34a;
    font-size: 21px;
}

.history-info {
    flex: 1;
    min-width: 0;
}

.history-info strong,
.history-info small,
.history-info span {
    display: block;
}

.history-info strong {
    font-size: 14px;
    margin-bottom: 5px;
}

.history-info small,
.history-info span {
    color: #94a3b8;
    font-size: 12px;
    margin-bottom: 4px;
}

.history-price {
    text-align: right;
}

.history-price small {
    display: block;
    color: #94a3b8;
    font-size: 11px;
    margin-bottom: 4px;
}

.history-price strong {
    font-size: 13px;
}

.history-badges {
    display: flex;
    justify-content: flex-end;
    gap: 5px;
    margin-top: 7px;
}

.history-badges .badge {
    font-size: 10px;
    font-weight: 600;
}

.history-arrow {
    color: #94a3b8;
}

.empty-history {
    text-align: center;
    padding: 55px 15px;
}

.empty-icon {
    width: 75px;
    height: 75px;
    margin: 0 auto 18px;
    border-radius: 50%;
    background: #eff6ff;
    color: #3b82f6;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 30px;
}

.empty-history h5 {
    font-weight: 800;
    font-size: 17px;
}

.empty-history p {
    color: #94a3b8;
    font-size: 13px;
    margin: 8px auto 18px;
}

.history-pagination {
    padding: 15px 0 5px;
}

@media (max-width: 576px) {
    .history-header {
        align-items: flex-start;
    }

    .history-card {
        padding: 8px 12px;
    }

    .history-item {
        flex-wrap: wrap;
        gap: 11px;
    }

    .history-price {
        margin-left: 57px;
        text-align: left;
    }

    .history-badges {
        justify-content: flex-start;
    }

    .history-arrow {
        display: none;
    }
}
</style>

@endsection
