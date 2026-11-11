
@extends('layouts.app')

@section('title', 'Data Pesanan - LaundryKu')
@section('page-title', 'Manajemen Pesanan')

@section('content')

<div class="container-fluid">

    {{-- Header Halaman --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Data Pesanan</h3>
            <p class="text-muted mb-0">Kelola seluruh pesanan laundry.</p>
        </div>

        <a href="{{ route('admin.pesanan.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>
            Tambah Pesanan
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            {{-- Form Pencarian dan Filter --}}
            <form action="{{ route('admin.pesanan.index') }}" method="GET" class="mb-4">

                <div class="row g-3">

                    {{-- Pencarian --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Cari Pesanan</label>
                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Kode, nama, atau email pelanggan..."
                            value="{{ request('search') }}">
                    </div>

                    {{-- Filter Status Pesanan --}}
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Status Pesanan</label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Diproses</option>
                            <option value="ready" {{ request('status') == 'ready' ? 'selected' : '' }}>Siap Diambil</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>

                    {{-- Filter Pembayaran --}}
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Pembayaran</label>
                        <select name="payment_status" class="form-select">
                            <option value="">Semua</option>
                            <option value="unpaid" {{ request('payment_status') == 'unpaid' ? 'selected' : '' }}>Belum Bayar</option>
                            <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Lunas</option>
                        </select>
                    </div>

                    {{-- Filter Tanggal --}}
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Tanggal Pesanan</label>
                        <input
                            type="date"
                            name="order_date"
                            class="form-control"
                            value="{{ request('order_date') }}">
                    </div>

                    {{-- Tombol Filter --}}
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="bi bi-search me-1"></i>
                            Cari
                        </button>

                        <a
                            href="{{ route('admin.pesanan.index') }}"
                            class="btn btn-outline-secondary"
                            title="Reset Filter">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    </div>

                </div>
            </form>

            <hr>

            {{-- Tabel Pesanan --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Kode Pesanan</th>
                            <th>Pelanggan</th>
                            <th>Tanggal</th>
                            <th>Total Harga</th>
                            <th>Status Pesanan</th>
                            <th>Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($pesanan as $item)
                            <tr>

                                <td>
                                    {{ $pesanan->firstItem() + $loop->index }}
                                </td>

                                <td class="fw-semibold">
                                    {{ $item->order_code }}
                                </td>

                                <td>
                                    {{ $item->nama_pelanggan }}
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($item->order_date)->format('d-m-Y') }}
                                </td>

                                <td class="fw-semibold">
                                    Rp{{ number_format($item->total_price, 0, ',', '.') }}
                                </td>

                                {{-- Status Pesanan --}}
                                <td>
                                    @php
                                        $statusClass = [
                                            'pending' => 'bg-warning text-dark',
                                            'confirmed' => 'bg-info text-dark',
                                            'processing' => 'bg-primary',
                                            'ready' => 'bg-success',
                                            'completed' => 'bg-secondary',
                                            'cancelled' => 'bg-danger',
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

                                    <span class="badge {{ $statusClass[$item->status] ?? 'bg-secondary' }}">
                                        {{ $statusLabel[$item->status] ?? ucfirst($item->status) }}
                                    </span>
                                </td>

                                {{-- Status Pembayaran --}}
                                <td>
                                    @if ($item->payment_status === 'paid')
                                        <span class="badge bg-success">Lunas</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Belum Bayar</span>
                                    @endif
                                </td>

                                {{-- Aksi --}}
                                <td>
                                    <div class="d-flex flex-wrap gap-1">

                                        {{-- Detail --}}
                                        <a
                                            href="{{ route('admin.pesanan.show', $item->id) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye me-1"></i>
                                            Detail
                                        </a>

                                        {{-- Batalkan Pesanan --}}
                                        @if ($item->status !== 'cancelled')
                                            <form
                                                action="{{ route('admin.pesanan.cancel', $item->id) }}"
                                                method="POST"
                                                class="form-batalkan-pesanan"
                                                data-kode="{{ $item->order_code }}"
                                                data-pelanggan="{{ $item->nama_pelanggan }}">

                                                @csrf
                                                @method('PATCH')

                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="bi bi-x-circle me-1"></i>
                                                    Batalkan
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-muted small align-self-center">
                                                Sudah dibatalkan
                                            </span>
                                        @endif

                                    </div>
                                </td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                    Tidak ada data pesanan yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

           {{-- Pagination --}}
<div class="mt-3">
    {{ $pesanan->links('pagination::bootstrap-5') }}
</div>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.form-batalkan-pesanan').forEach(function(form) {

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const formIni = this;
            const kode = formIni.dataset.kode;
            const pelanggan = formIni.dataset.pelanggan;

            Swal.fire({
                title: 'Batalkan Pesanan?',
                html: `
                    <div class="mb-3">
                        <div class="rounded-3 bg-danger bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3"
                             style="width: 65px; height: 65px;">
                            <i class="bi bi-exclamation-triangle-fill text-danger fs-2"></i>
                        </div>

                        <p class="mb-2">Apakah kamu yakin ingin membatalkan pesanan ini?</p>

                        <div class="bg-light rounded-3 p-3 text-start">
                            <div class="mb-2">
                                <small class="text-muted d-block">Kode Pesanan</small>
                                <strong>${escapeHtml(kode)}</strong>
                            </div>

                            <div>
                                <small class="text-muted d-block">Nama Pelanggan</small>
                                <strong>${escapeHtml(pelanggan)}</strong>
                            </div>
                        </div>

                        <p class="text-danger small mt-3 mb-0">
                            <i class="bi bi-info-circle me-1"></i>
                            Pesanan akan ditandai sebagai dibatalkan.
                        </p>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '<i class="bi bi-x-circle me-1"></i> Ya, Batalkan',
                cancelButtonText: 'Tidak Jadi',
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                reverseButtons: true,
                focusCancel: true,
                customClass: {
                    popup: 'rounded-4',
                    title: 'fw-bold',
                    confirmButton: 'rounded-3 px-4',
                    cancelButton: 'rounded-3 px-4'
                }
            }).then(function(result) {
                if (result.isConfirmed) {
                    formIni.submit();
                }
            });
        });

    });

    function escapeHtml(text) {
        const element = document.createElement('div');
        element.textContent = text;
        return element.innerHTML;
    }

});
</script>
@endpush
