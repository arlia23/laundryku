
@extends('customer.layouts.app')

@section('title', 'Pesanan Saya - LaundryKu')

@section('content')

{{-- Baris Ringkasan dan Tombol --}}
<div class="summary-row">

    {{-- Total Pesanan --}}
    <div class="summary-strip">
        <div class="summary-icon">
            <i class="bi bi-receipt"></i>
        </div>

        <div>
            <small>Total Pesanan</small>
            <h5>{{ $pesanan->total() }} <span>pesanan</span></h5>
        </div>
    </div>

    {{-- Tombol Buat Pesanan --}}
    <div class="top-actions">
        <a href="{{ route('customer.pesanan.create') }}" class="btn-create">
            <i class="bi bi-plus-lg"></i>
            Buat Pesanan
        </a>
    </div>

</div>
{{-- Panel Pesanan --}}
<div class="orders-panel">

    {{-- Filter Pesanan --}}
    <div class="filter-area">

        <form action="{{ route('customer.pesanan.index') }}"
              method="GET"
              id="filterForm">

            <div class="filter-grid">

                {{-- Cari Kode Pesanan --}}
                <div class="filter-group">
                    <label for="searchInput">Cari Pesanan</label>

                    <div class="filter-input">
                        <i class="bi bi-search"></i>

                        <input
                            type="text"
                            name="search"
                            id="searchInput"
                            placeholder="Masukkan kode pesanan..."
                            value="{{ request('search') }}"
                            autocomplete="off"
                        >
                    </div>
                </div>

                {{-- Filter Tanggal --}}
                <div class="filter-group">
                    <label for="tanggalInput">Tanggal Pesanan</label>

                    <div class="filter-input">
                        <i class="bi bi-calendar3"></i>

                        <input
                            type="date"
                            name="tanggal"
                            id="tanggalInput"
                            value="{{ request('tanggal') }}"
                        >
                    </div>
                </div>

                {{-- Reset Filter --}}
                <div class="filter-action">
                    <label>&nbsp;</label>

                    <a href="{{ route('customer.pesanan.index') }}"
                       class="btn-reset"
                       title="Reset pencarian">
                        <i class="bi bi-arrow-counterclockwise"></i>
                        Reset
                    </a>
                </div>

            </div>

        </form>

        @if(request('search') || request('tanggal'))
            <div class="filter-result">
                <i class="bi bi-funnel-fill"></i>
                Filter sedang diterapkan.

                @if(request('search'))
                    <span>Kode: {{ request('search') }}</span>
                @endif

                @if(request('tanggal'))
                    <span>
                        Tanggal:
                        {{ \Carbon\Carbon::parse(request('tanggal'))->format('d/m/Y') }}
                    </span>
                @endif
            </div>
        @endif

    </div>

    {{-- Tabel Pesanan --}}
    <div class="table-responsive">

        <table class="table order-table align-middle mb-0">

            <thead>
                <tr>
                    <th class="text-center">NO</th>
                    <th>KODE PESANAN</th>
                    <th>PAKET</th>
                    <th>TANGGAL</th>
                    <th>BERAT</th>
                    <th>TOTAL HARGA</th>
                    <th>STATUS</th>
                    <th>PEMBAYARAN</th>
                    <th class="text-center">AKSI</th>
                </tr>
            </thead>

            <tbody>

                @forelse($pesanan as $item)

                    <tr>

                        {{-- Nomor --}}
                        <td class="text-center">
                            <span class="number-badge">
                                {{ $pesanan->firstItem() + $loop->index }}
                            </span>
                        </td>

                        {{-- Kode --}}
                        <td>
                            <span class="order-code">
                                {{ $item->order_code }}
                            </span>
                        </td>

                        {{-- Paket --}}
                        <td>
                            <div class="package-name">
                                {{ $item->nama_paket }}
                            </div>
                        </td>

                        {{-- Tanggal --}}
                        <td>
                            {{ \Carbon\Carbon::parse($item->order_date)->format('d/m/Y') }}
                        </td>

                        {{-- Berat --}}
                        <td>
                            @if($item->quantity > 0)
                                {{ $item->quantity }} kg
                            @else
                                <span class="text-muted">Belum ditimbang</span>
                            @endif
                        </td>

                        {{-- Harga --}}
                        <td>
                            <strong class="price-text">
                                @if($item->total_price > 0)
                                    Rp{{ number_format($item->total_price, 0, ',', '.') }}
                                @else
                                    Belum ditentukan
                                @endif
                            </strong>
                        </td>

                        {{-- Status --}}
                        <td>
                            @php
                                $statusClass = [
                                    'pending' => 'status-pending',
                                    'confirmed' => 'status-confirmed',
                                    'processing' => 'status-processing',
                                    'ready' => 'status-ready',
                                    'completed' => 'status-completed',
                                    'cancelled' => 'status-cancelled',
                                ][$item->status] ?? 'status-pending';

                                $statusLabel = [
                                    'pending' => 'Menunggu',
                                    'confirmed' => 'Dikonfirmasi',
                                    'processing' => 'Diproses',
                                    'ready' => 'Siap Diambil',
                                    'completed' => 'Selesai',
                                    'cancelled' => 'Dibatalkan',
                                ][$item->status] ?? ucfirst($item->status);
                            @endphp

                            <span class="status-badge {{ $statusClass }}">
                                {{ $statusLabel }}
                            </span>
                        </td>

                        {{-- Pembayaran --}}
                        <td>
                            @if($item->payment_status == 'paid')
                                <span class="payment-paid">
                                    <i class="bi bi-check-circle-fill"></i>
                                    Lunas
                                </span>
                            @else
                                <span class="payment-unpaid">
                                    <i class="bi bi-clock"></i>
                                    Belum Bayar
                                </span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td class="text-center">
                            <a href="{{ route('customer.pesanan.show', $item->id) }}"
                               class="btn-detail">
                                <i class="bi bi-eye"></i>
                                Detail & Lacak
                            </a>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="9">

                            <div class="empty-state">
                                <i class="bi bi-bag-x"></i>

                                @if(request('search') || request('tanggal'))

                                    <h6>Pesanan Tidak Ditemukan</h6>

                                    <p>
                                        Tidak ada pesanan yang sesuai dengan filter pencarian.
                                    </p>

                                    <a href="{{ route('customer.pesanan.index') }}">
                                        Tampilkan semua pesanan
                                    </a>

                                @else

                                    <h6>Belum Ada Pesanan</h6>

                                    <p>
                                        Kamu belum membuat pesanan laundry.
                                    </p>

                                    <a href="{{ route('customer.pesanan.create') }}">
                                        Buat pesanan sekarang
                                    </a>

                                @endif
                            </div>

                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    {{-- Pagination --}}
    @if($pesanan->hasPages())
        <div class="pagination-area">
            {{ $pesanan->links('pagination::bootstrap-5') }}
        </div>
    @endif

</div>

<style>
    /* Header */
    .summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    margin-bottom: 5px;
    margin-top: 20px;
    width: 100%;
}

.summary-strip {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 18px 22px;
    background: white;
    border: 1px solid #edf0f5;
    border-radius: 15px;
    min-width: 300px;
    margin-bottom: 0;
}

.top-actions {
    display: flex;
    justify-content: flex-end;
    align-items: center;
}

.btn-create {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    background: #2563eb;
    color: white;
    padding: 16px 24px;
    border-radius: 13px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 700;
    box-shadow: 0 5px 12px rgba(37, 99, 235, 0.15);
    transition: .2s;
}

.btn-create:hover {
    background: #1d4ed8;
    color: white;
    transform: translateY(-2px);
}

@media(max-width: 576px) {
    .summary-row {
        align-items: stretch;
        flex-direction: column;
    }

    .summary-strip {
        width: 100%;
        min-width: 0;
    }

    .top-actions {
        justify-content: flex-start;
    }
}
    .top-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
        margin-bottom: 22px;
    }

    .top-label {
        font-size: 10px;
        font-weight: 750;
        letter-spacing: 1px;
        color: #2563eb;
    }

    .top-actions-info h5 {
        margin: 4px 0 0;
        font-size: 17px;
        font-weight: 750;
        color: #1e293b;
    }

    .btn-create {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: #2563eb;
        color: white;
        padding: 11px 17px;
        border-radius: 9px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 650;
        transition: .2s;
        box-shadow: 0 4px 10px rgba(37, 99, 235, .15);
    }

    .btn-create:hover {
        background: #1d4ed8;
        color: white;
        transform: translateY(-2px);
    }

    /* Ringkasan */
    .summary-strip {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 18px 22px;
        background: white;
        border: 1px solid #edf0f5;
        border-radius: 12px;
        margin-bottom: 22px;
        width: fit-content;
        min-width: 220px;
    }

    .summary-icon {
        width: 45px;
        height: 45px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 11px;
        font-size: 21px;
    }

    .summary-strip small {
        color: #94a3b8;
    }

    .summary-strip h5 {
        margin: 3px 0 0;
        font-weight: 750;
        color: #1e293b;
    }

    .summary-strip h5 span {
        font-size: 12px;
        font-weight: 400;
        color: #94a3b8;
    }

    /* Panel */
    .orders-panel {
        background: white;
        border: 1px solid #edf0f5;
        border-radius: 13px;
        overflow: hidden;
    }

    .panel-heading {
        padding: 20px 23px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #edf0f5;
    }

    .panel-heading h5 {
        font-size: 16px;
        font-weight: 750;
        color: #1e293b;
        margin-bottom: 5px;
    }

    .panel-heading p {
        color: #94a3b8;
        font-size: 13px;
        margin: 0;
    }

    .panel-heading > i {
        font-size: 21px;
        color: #94a3b8;
    }

    /* Filter */
    .filter-area {
        padding: 20px;
        background: #fff;
        border-bottom: 1px solid #edf0f5;
    }

    .filter-grid {
        display: grid;
        grid-template-columns: minmax(240px, 1.5fr) minmax(200px, 1fr) auto;
        align-items: end;
        gap: 15px;
    }

    .filter-group label,
    .filter-action label {
        display: block;
        color: #334155;
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 9px;
    }

    .filter-input {
        display: flex;
        align-items: center;
        gap: 10px;
        height: 48px;
        padding: 0 14px;
        border: 1px solid #dbe2ea;
        border-radius: 9px;
        background: #fff;
        transition: .2s;
    }

    .filter-input:focus-within {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .08);
    }

    .filter-input i {
        color: #94a3b8;
        font-size: 16px;
    }

    .filter-input input {
        width: 100%;
        min-width: 0;
        border: none;
        outline: none;
        background: transparent;
        color: #334155;
        font-size: 13px;
    }

    .filter-input input::placeholder {
        color: #a0aec0;
    }

    .filter-input input[type="date"] {
        cursor: pointer;
    }

    .btn-reset {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        height: 48px;
        padding: 0 17px;
        border: 1px solid #cbd5e1;
        border-radius: 9px;
        color: #64748b;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        transition: .2s;
    }

    .btn-reset:hover {
        background: #f1f5f9;
        color: #334155;
        border-color: #94a3b8;
    }

    .filter-result {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 9px;
        margin-top: 14px;
        color: #64748b;
        font-size: 11px;
    }

    .filter-result > i {
        color: #2563eb;
    }

    .filter-result span {
        background: #eff6ff;
        color: #2563eb;
        padding: 5px 9px;
        border-radius: 6px;
        font-weight: 600;
    }

    /* Tabel */
    .order-table {
        min-width: 1100px;
    }

    .order-table thead th {
        background: #f8fafc;
        color: #64748b;
        font-size: 10px;
        font-weight: 750;
        letter-spacing: .4px;
        padding: 15px 13px;
        white-space: nowrap;
        border-bottom: 1px solid #edf0f5;
    }

    .order-table tbody td {
        padding: 17px 13px;
        font-size: 12px;
        color: #475569;
        border-bottom: 1px solid #f1f5f9;
        white-space: nowrap;
    }

    .order-table tbody tr:last-child td {
        border-bottom: none;
    }

    .order-table tbody tr:hover {
        background: #fafcff;
    }

    .number-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 27px;
        height: 27px;
        border-radius: 8px;
        background: #eff6ff;
        color: #2563eb;
        font-weight: 700;
    }

    .order-code {
        color: #2563eb;
        font-weight: 750;
    }

    .package-name {
        font-weight: 650;
        color: #334155;
    }

    .price-text {
        color: #2563eb;
    }

    /* Tombol Detail */
    .btn-detail {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 9px 12px;
        border-radius: 7px;
        background: #2563eb;
        color: white;
        text-decoration: none;
        font-size: 11px;
        font-weight: 600;
        transition: .2s;
    }

    .btn-detail:hover {
        background: #1d4ed8;
        color: white;
    }

    /* Status */
    .status-badge,
    .payment-paid,
    .payment-unpaid {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 700;
    }

    .status-pending {
        background: #fff7ed;
        color: #c2410c;
    }

    .status-confirmed {
        background: #eff6ff;
        color: #1d4ed8;
    }

    .status-processing {
        background: #ede9fe;
        color: #6d28d9;
    }

    .status-ready {
        background: #ecfdf5;
        color: #047857;
    }

    .status-completed {
        background: #dcfce7;
        color: #15803d;
    }

    .status-cancelled {
        background: #fef2f2;
        color: #dc2626;
    }

    .payment-paid {
        background: #ecfdf5;
        color: #047857;
    }

    .payment-unpaid {
        background: #fff7ed;
        color: #c2410c;
    }

    /* Data Kosong */
    .empty-state {
        text-align: center;
        padding: 55px 15px;
    }

    .empty-state i {
        font-size: 45px;
        color: #cbd5e1;
    }

    .empty-state h6 {
        margin-top: 12px;
        font-weight: 700;
        color: #334155;
    }

    .empty-state p {
        color: #94a3b8;
        font-size: 13px;
    }

    .empty-state a {
        color: #2563eb;
        text-decoration: none;
        font-weight: 650;
        font-size: 13px;
    }

    /* Pagination */
    .pagination-area {
        padding: 18px 22px;
        border-top: 1px solid #edf0f5;
        display: flex;
        justify-content: flex-end;
    }

    .pagination-area nav {
        width: 100%;
    }

    .pagination-area .pagination {
        justify-content: flex-end;
        margin-bottom: 0;
        gap: 5px;
    }

    .pagination-area .page-link {
        border-radius: 7px;
        color: #2563eb;
        font-size: 12px;
        padding: 7px 12px;
    }

    .pagination-area .page-item.active .page-link {
        background: #2563eb;
        border-color: #2563eb;
        color: white;
    }

    /* Tampilan layar kecil */
    @media(max-width: 768px) {
        .filter-grid {
            grid-template-columns: 1fr;
            gap: 13px;
        }

        .filter-action label {
            display: none;
        }

        .btn-reset {
            width: 100%;
        }
    }

    @media(max-width: 576px) {
        .summary-strip {
            width: 100%;
        }

        .panel-heading {
            padding: 17px;
        }

        .top-actions-info h5 {
            font-size: 15px;
        }
    }
</style>

@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Pencarian otomatis dengan jeda 500 milidetik
    const filterForm = document.getElementById('filterForm');
    const searchInput = document.getElementById('searchInput');
    const tanggalInput = document.getElementById('tanggalInput');

    let filterTimer;

    function submitFilter() {
        clearTimeout(filterTimer);

        filterTimer = setTimeout(function () {
            filterForm.submit();
        }, 500);
    }

    // Otomatis mencari ketika kode diketik
    searchInput.addEventListener('input', function () {
        submitFilter();
    });

    // Otomatis mencari ketika tanggal dipilih
    tanggalInput.addEventListener('change', function () {
        clearTimeout(filterTimer);
        filterForm.submit();
    });
</script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: @json(session('success')),
        confirmButtonText: 'Oke',
        confirmButtonColor: '#2563eb',
        timer: 3000,
        timerProgressBar: true
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Terjadi Kesalahan',
        text: @json(session('error')),
        confirmButtonColor: '#2563eb'
    });
</script>
@endif

@endpush
