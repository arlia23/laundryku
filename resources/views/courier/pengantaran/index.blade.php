
@extends('courier.layouts.app')

@section('title', 'Tugas Pengantaran - LaundryKu')
@section('page-title', 'Tugas Pengantaran')

@section('content')


{{-- FILTER DAN PENCARIAN --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">

        <h5 class="fw-bold mb-3">
            <i class="bi bi-search text-primary me-2"></i>
            Cari Tugas Pengantaran
        </h5>

        <form action="{{ route('courier.pengantaran.index') }}" method="GET">
            <div class="row g-3 align-items-end">

                <div class="col-lg-4 col-md-6">
                    <label class="form-label fw-semibold">Cari Tugas</label>
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Kode pesanan atau nama pelanggan..."
                        value="{{ request('search') }}"
                    >
                </div>

                <div class="col-lg-3 col-md-6">
                    <label class="form-label fw-semibold">Status Tugas</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="pickup" {{ request('status') == 'pickup' ? 'selected' : '' }}>
                            Menunggu Penjemputan
                        </option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>
                            Sedang Diproses
                        </option>
                        <option value="ready" {{ request('status') == 'ready' ? 'selected' : '' }}>
                            Siap Diantar
                        </option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                            Selesai
                        </option>
                    </select>
                </div>

                <div class="col-lg-3 col-md-6">
                    <label class="form-label fw-semibold">Tanggal Pesanan</label>
                    <input
                        type="date"
                        name="tanggal"
                        class="form-control"
                        value="{{ request('tanggal') }}"
                    >
                </div>

                <div class="col-lg-2 col-md-6 d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1">
                        <i class="bi bi-search me-1"></i>
                        Cari
                    </button>

                    <a href="{{ route('courier.pengantaran.index') }}"
                       class="btn btn-outline-secondary"
                       title="Reset filter">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                </div>

            </div>
        </form>

    </div>
</div>

{{-- DAFTAR TUGAS --}}
<div class="card border-0 shadow-sm">

    <div class="card-header bg-white py-3">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h5 class="fw-bold mb-1">Daftar Tugas Saya</h5>
                <small class="text-muted">
                    Informasi seluruh tugas yang diberikan kepada kamu.
                </small>
            </div>

            <span class="badge bg-primary px-3 py-2">
                {{ $pengantaran->total() }} Tugas
            </span>
        </div>
    </div>

    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th class="ps-4">No.</th>
                        <th>Kode Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Tanggal</th>
                        <th>Total Harga</th>
                        <th>Status Tugas</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($pengantaran as $item)

                        @php
                            $nomorTelepon = preg_replace(
                                '/[^0-9]/',
                                '',
                                $item->telepon_pelanggan ?? ''
                            );

                            $nomorWhatsApp = $nomorTelepon;

                            if (str_starts_with($nomorWhatsApp, '0')) {
                                $nomorWhatsApp = '62' . substr($nomorWhatsApp, 1);
                            } elseif (str_starts_with($nomorWhatsApp, '8')) {
                                $nomorWhatsApp = '62' . $nomorWhatsApp;
                            }

                            if ($item->delivery_status === 'delivered') {
                                $statusTugas = 'Selesai';
                                $warnaStatus = 'success';
                            } elseif ($item->pickup_status === 'pending') {
                                $statusTugas = 'Menunggu Penjemputan';
                                $warnaStatus = 'warning';
                            } elseif ($item->status_pesanan === 'ready') {
                                $statusTugas = 'Siap Diantar';
                                $warnaStatus = 'primary';
                            } elseif ($item->status_pesanan === 'processing') {
                                $statusTugas = 'Sedang Diproses';
                                $warnaStatus = 'info';
                            } else {
                                $statusTugas = 'Dalam Proses Laundry';
                                $warnaStatus = 'secondary';
                            }
                        @endphp

                        <tr>
                            <td class="ps-4">
                                {{ $pengantaran->firstItem() + $loop->index }}
                            </td>

                            <td>
                                <span class="fw-bold text-primary">
                                    {{ $item->order_code }}
                                </span>
                            </td>

                            <td>
                                <div class="fw-semibold">
                                    {{ $item->nama_pelanggan }}
                                </div>
                                <small class="text-muted">
                                    {{ $item->telepon_pelanggan ?: 'Nomor belum tersedia' }}
                                </small>
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($item->order_date)->format('d-m-Y') }}
                            </td>

                            <td class="fw-bold">
                                Rp{{ number_format((float) $item->total_price, 0, ',', '.') }}
                            </td>

                            <td>
                                <span class="badge bg-{{ $warnaStatus }} {{ $warnaStatus === 'warning' || $warnaStatus === 'info' ? 'text-dark' : '' }}">
                                    {{ $statusTugas }}
                                </span>
                            </td>

                            <td class="text-center">
                                <button
                                    type="button"
                                    class="btn btn-sm btn-outline-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#detailTugas{{ $item->id }}"
                                >
                                    <i class="bi bi-eye me-1"></i>
                                    Detail
                                </button>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="bi bi-truck fs-1 text-muted"></i>

                                <h5 class="fw-bold mt-3">
                                    Tidak Ada Tugas
                                </h5>

                                <p class="text-muted mb-0">
                                    Belum ada tugas yang sesuai dengan pencarian atau filter kamu.
                                </p>

                                @if(request()->hasAny(['search', 'status', 'tanggal']))
                                    <a href="{{ route('courier.pengantaran.index') }}"
                                       class="btn btn-sm btn-outline-primary mt-3">
                                        Reset Pencarian
                                    </a>
                                @endif
                            </td>
                        </tr>

                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if($pengantaran->hasPages())
            <div class="p-3 border-top">
                {{ $pengantaran->links() }}
            </div>
        @endif

    </div>
</div>


{{-- POPUP DETAIL SETIAP TUGAS --}}
@foreach($pengantaran as $item)

    @php
        $nomorTelepon = preg_replace(
            '/[^0-9]/',
            '',
            $item->telepon_pelanggan ?? ''
        );

        $nomorWhatsApp = $nomorTelepon;

        if (str_starts_with($nomorWhatsApp, '0')) {
            $nomorWhatsApp = '62' . substr($nomorWhatsApp, 1);
        } elseif (str_starts_with($nomorWhatsApp, '8')) {
            $nomorWhatsApp = '62' . $nomorWhatsApp;
        }

        if ($item->delivery_status === 'delivered') {
            $statusTugas = 'Selesai';
            $warnaStatus = 'success';
        } elseif ($item->pickup_status === 'pending') {
            $statusTugas = 'Menunggu Penjemputan';
            $warnaStatus = 'warning';
        } elseif ($item->status_pesanan === 'ready') {
            $statusTugas = 'Siap Diantar';
            $warnaStatus = 'primary';
        } elseif ($item->status_pesanan === 'processing') {
            $statusTugas = 'Sedang Diproses';
            $warnaStatus = 'info';
        } else {
            $statusTugas = 'Dalam Proses Laundry';
            $warnaStatus = 'secondary';
        }
    @endphp

    <div class="modal fade" id="detailTugas{{ $item->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow">

                <div class="modal-header bg-primary text-white">
                    <div>
                        <h5 class="modal-title fw-bold">
                            <i class="bi bi-receipt me-2"></i>
                            Detail Tugas Pengantaran
                        </h5>
                        <small>{{ $item->order_code }}</small>
                    </div>

                    <button type="button"
                            class="btn-close btn-close-white"
                            data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body p-4">

                    {{-- STATUS --}}
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                        <div>
                            <small class="text-muted d-block">Status Tugas</small>
                            <span class="badge bg-{{ $warnaStatus }} mt-1">
                                {{ $statusTugas }}
                            </span>
                        </div>

                        <div class="text-end">
                            <small class="text-muted d-block">Tanggal Pesanan</small>
                            <strong>
                                {{ \Carbon\Carbon::parse($item->order_date)->format('d M Y') }}
                            </strong>
                        </div>
                    </div>

                    {{-- INFORMASI PELANGGAN --}}
                    <div class="border rounded-3 p-3 mb-3">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-person-circle text-primary me-2"></i>
                            Informasi Pelanggan
                        </h6>

                        <div class="mb-2">
                            <small class="text-muted d-block">Nama Pelanggan</small>
                            <strong>{{ $item->nama_pelanggan }}</strong>
                        </div>

                        <div>
                            <small class="text-muted d-block">Nomor Telepon</small>

                            <strong>
                                {{ $item->telepon_pelanggan ?: 'Belum tersedia' }}
                            </strong>

                            @if($nomorTelepon)
                                <div class="d-flex flex-wrap gap-2 mt-2">
                                    <a href="tel:{{ $nomorTelepon }}"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-telephone me-1"></i>
                                        Telepon
                                    </a>

                                    <a href="https://wa.me/{{ $nomorWhatsApp }}"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-whatsapp me-1"></i>
                                        WhatsApp
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- INFORMASI PESANAN --}}
                    <div class="border rounded-3 p-3 mb-3">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-bag-check text-primary me-2"></i>
                            Informasi Pesanan
                        </h6>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <small class="text-muted d-block">Kode Pesanan</small>
                                <strong>{{ $item->order_code }}</strong>
                            </div>

                            <div class="col-md-6">
                                <small class="text-muted d-block">Status Pesanan</small>
                                <strong>{{ ucfirst($item->status_pesanan) }}</strong>
                            </div>

                            <div class="col-md-6">
                                <small class="text-muted d-block">Pembayaran</small>
                                <strong>
                                    {{ $item->payment_status === 'paid' ? 'Lunas' : 'Belum Bayar' }}
                                </strong>
                            </div>

                            <div class="col-md-6">
                                <small class="text-muted d-block">Total Harga</small>
                                <strong class="text-success">
                                    Rp{{ number_format((float) $item->total_price, 0, ',', '.') }}
                                </strong>
                            </div>
                        </div>
                    </div>

                    {{-- ALAMAT PENJEMPUTAN --}}
                    <div class="border rounded-3 p-3 mb-3">
                        <h6 class="fw-bold mb-2">
                            <i class="bi bi-geo-alt-fill text-warning me-2"></i>
                            Alamat Penjemputan
                        </h6>

                        <p class="text-muted mb-2">
                            {{ $item->pickup_address ?: 'Alamat belum tersedia.' }}
                        </p>

                        @if($item->pickup_address)
                            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($item->pickup_address) }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-map me-1"></i>
                                Buka Google Maps
                            </a>
                        @endif
                    </div>

                    {{-- ALAMAT PENGANTARAN --}}
                    <div class="border rounded-3 p-3 mb-3">
                        <h6 class="fw-bold mb-2">
                            <i class="bi bi-house-fill text-success me-2"></i>
                            Alamat Pengantaran
                        </h6>

                        <p class="text-muted mb-2">
                            {{ $item->delivery_address ?: 'Alamat belum tersedia.' }}
                        </p>

                        @if($item->delivery_address)
                            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($item->delivery_address) }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-map me-1"></i>
                                Buka Google Maps
                            </a>
                        @endif
                    </div>

                    {{-- STATUS PENJEMPUTAN DAN PENGANTARAN --}}
                    <div class="border rounded-3 p-3">
                        <h6 class="fw-bold mb-3">Progres Tugas</h6>

                        <div class="mb-3">
                            <small class="text-muted d-block">Penjemputan</small>

                            @if($item->pickup_status === 'picked_up')
                                <span class="text-success fw-semibold">
                                    <i class="bi bi-check-circle-fill me-1"></i>
                                    Sudah Dijemput
                                </span>
                            @else
                                <span class="text-warning fw-semibold">
                                    <i class="bi bi-clock-fill me-1"></i>
                                    Menunggu Penjemputan
                                </span>
                            @endif
                        </div>

                        <div>
                            <small class="text-muted d-block">Pengantaran</small>

                            @if($item->delivery_status === 'delivered')
                                <span class="text-success fw-semibold">
                                    <i class="bi bi-check-circle-fill me-1"></i>
                                    Sudah Diantarkan
                                </span>
                            @elseif($item->status_pesanan === 'ready' && $item->pickup_status === 'picked_up')
                                <span class="text-primary fw-semibold">
                                    <i class="bi bi-truck me-1"></i>
                                    Siap Diantarkan
                                </span>
                            @else
                                <span class="text-muted fw-semibold">
                                    <i class="bi bi-hourglass-split me-1"></i>
                                    Belum Diantarkan
                                </span>
                            @endif
                        </div>
                    </div>

                </div>

                {{-- FOOTER DAN TOMBOL AKSI --}}
                <div class="modal-footer d-flex justify-content-between flex-wrap gap-2">

                    <button type="button"
                            class="btn btn-light"
                            data-bs-dismiss="modal">
                        Tutup
                    </button>

                    <div class="d-flex flex-wrap gap-2">

                        @if($item->pickup_status === 'pending')

                            <form action="{{ route('courier.pengantaran.pickup', $item->id) }}"
                                  method="POST"
                                  class="form-konfirmasi"
                                  data-title="Konfirmasi Penjemputan"
                                  data-message="Apakah pakaian pelanggan sudah dijemput?"
                                  data-button="Ya, Sudah Dijemput"
                                  data-color="#2563eb">

                                @csrf
                                @method('PATCH')

                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-box-seam me-1"></i>
                                    Konfirmasi Penjemputan
                                </button>
                            </form>

                        @elseif($item->delivery_status === 'pending' && $item->status_pesanan === 'ready')

                            <form action="{{ route('courier.pengantaran.delivery', $item->id) }}"
                                  method="POST"
                                  class="form-konfirmasi"
                                  data-title="Konfirmasi Pengantaran"
                                  data-message="Apakah pakaian sudah diterima pelanggan?"
                                  data-button="Ya, Sudah Diantarkan"
                                  data-color="#16a34a">

                                @csrf
                                @method('PATCH')

                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Konfirmasi Pengantaran
                                </button>
                            </form>

                        @elseif($item->delivery_status === 'delivered')

                            <button class="btn btn-outline-success" disabled>
                                <i class="bi bi-check-circle me-1"></i>
                                Pesanan Selesai
                            </button>

                        @else

                            <button class="btn btn-outline-secondary" disabled>
                                <i class="bi bi-hourglass-split me-1"></i>
                                Menunggu Laundry Selesai
                            </button>

                        @endif

                    </div>
                </div>

            </div>
        </div>
    </div>

@endforeach

@endsection


{{-- SWEETALERT --}}
@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // Konfirmasi aksi kurir
    document.querySelectorAll('.form-konfirmasi').forEach(function(form) {

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const formIni = this;

            Swal.fire({
                title: formIni.dataset.title,
                text: formIni.dataset.message,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: formIni.dataset.button,
                cancelButtonText: 'Batal',
                confirmButtonColor: formIni.dataset.color,
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

    // Notifikasi berhasil
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: @json(session('success')),
            confirmButtonText: 'Oke, Mengerti',
            confirmButtonColor: '#16a34a',
            customClass: {
                popup: 'rounded-4',
                confirmButton: 'rounded-3 px-4'
            }
        });
    @endif

    // Notifikasi gagal
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Terjadi Kesalahan!',
            text: @json(session('error')),
            confirmButtonText: 'Tutup',
            confirmButtonColor: '#dc2626',
            customClass: {
                popup: 'rounded-4',
                confirmButton: 'rounded-3 px-4'
            }
        });
    @endif

});
</script>

@endpush
