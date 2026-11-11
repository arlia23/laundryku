
@extends('layouts.app')

@section('title', 'Detail Pesanan - LaundryKu')
@section('page-title', 'Detail Pesanan')

@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Detail Pesanan</h3>
            <p class="text-muted mb-0">Informasi lengkap transaksi laundry.</p>
        </div>

        <a href="{{ route('admin.pesanan.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Kembali
        </a>
    </div>

    <div class="row g-4">

        {{-- Informasi Pesanan --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white fw-bold py-3">
                    <i class="bi bi-receipt me-2 text-primary"></i>
                    Informasi Pesanan
                </div>

                <div class="card-body">

                    <div class="mb-3">
                        <small class="text-muted">Kode Pesanan</small>
                        <div class="fw-semibold">{{ $pesanan->order_code }}</div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Tanggal Pesanan</small>
                        <div class="fw-semibold">
                            {{ \Carbon\Carbon::parse($pesanan->order_date)->format('d-m-Y') }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Status Pesanan</small>
                        <div>
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

                            <span class="badge {{ $statusClass[$pesanan->status] ?? 'bg-secondary' }}">
                                {{ $statusLabel[$pesanan->status] ?? ucfirst($pesanan->status) }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <small class="text-muted">Status Pembayaran</small>
                        <div>
                            @if ($pesanan->payment_status === 'paid')
                                <span class="badge bg-success">Lunas</span>
                            @else
                                <span class="badge bg-warning text-dark">Belum Bayar</span>
                            @endif
                        </div>
                    </div>


{{-- BUKTI TRANSFER CUSTOMER --}}
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

@if($paketAntar)
    <hr>

    <div class="mb-3">
        <h6 class="fw-bold">
            <i class="bi bi-image me-2 text-primary"></i>
            Bukti Transfer Customer
        </h6>

        @if($buktiPath)
            <div class="border rounded-3 p-3">
                <img
                    src="{{ asset('storage/' . $buktiPath) }}"
                    alt="Bukti Transfer Customer"
                    class="img-fluid rounded mb-3"
                    style="width: 100%; max-height: 350px; object-fit: contain;"
                >

                @if($pesanan->payment_status === 'paid')
                    <span class="badge bg-success">
                        <i class="bi bi-check-circle me-1"></i>
                        Pembayaran Sudah Dikonfirmasi
                    </span>
                @else
                    <span class="badge bg-warning text-dark">
                        <i class="bi bi-clock me-1"></i>
                        Menunggu Verifikasi Admin
                    </span>
                @endif
            </div>
        @else
            <div class="alert alert-secondary mb-0">
                <i class="bi bi-exclamation-circle me-2"></i>
                Customer belum mengunggah bukti transfer.
            </div>
        @endif
    </div>
@endif


                    <hr>

                    {{-- Form Pembayaran --}}
                    @if ($pesanan->status !== 'cancelled')
                        <form action="{{ route('admin.pesanan.updatePayment', $pesanan->id) }}"
                              method="POST"
                              id="form-pembayaran"
                              data-kode="{{ $pesanan->order_code }}">

                            @csrf
                            @method('PATCH')

                            <label class="form-label fw-semibold">
                                <i class="bi bi-wallet2 me-1"></i>
                                Ubah Status Pembayaran
                            </label>

                            <select name="payment_status" class="form-select mb-3" required>
                                <option value="unpaid"
                                    {{ $pesanan->payment_status == 'unpaid' ? 'selected' : '' }}>
                                    Belum Bayar
                                </option>

                                <option value="paid"
                                    {{ $pesanan->payment_status == 'paid' ? 'selected' : '' }}>
                                    Lunas
                                </option>
                            </select>

                            @error('payment_status')
                                <div class="text-danger small mb-2">{{ $message }}</div>
                            @enderror

                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-cash-coin me-1"></i>
                                Simpan Pembayaran
                            </button>
                        </form>
                    @else
                        <div class="alert alert-danger mb-0">
                            <i class="bi bi-exclamation-circle me-1"></i>
                            Pembayaran tidak dapat diproses karena pesanan sudah dibatalkan.
                        </div>
                    @endif

                    <hr>

                    {{-- Form Status Pesanan --}}
                    @if ($pesanan->status !== 'cancelled')
                        <form action="{{ route('admin.pesanan.updateStatus', $pesanan->id) }}"
                              method="POST"
                              id="form-status-pesanan"
                              data-kode="{{ $pesanan->order_code }}"
                              data-status-awal="{{ $pesanan->status }}">

                            @csrf
                            @method('PATCH')

                            <label class="form-label fw-semibold">
                                <i class="bi bi-arrow-repeat me-1"></i>
                                Ubah Status Pesanan
                            </label>

                            <select name="status" class="form-select mb-3" required>
                                <option value="pending" {{ $pesanan->status == 'pending' ? 'selected' : '' }}>
                                    Pending
                                </option>
                                <option value="confirmed" {{ $pesanan->status == 'confirmed' ? 'selected' : '' }}>
                                    Confirmed
                                </option>
                                <option value="processing" {{ $pesanan->status == 'processing' ? 'selected' : '' }}>
                                    Processing
                                </option>
                                <option value="ready" {{ $pesanan->status == 'ready' ? 'selected' : '' }}>
                                    Ready
                                </option>
                                <option value="completed" {{ $pesanan->status == 'completed' ? 'selected' : '' }}>
                                    Completed
                                </option>
                                <option value="cancelled">
                                    Cancelled
                                </option>
                            </select>

                            @error('status')
                                <div class="text-danger small mb-2">{{ $message }}</div>
                            @enderror

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-arrow-repeat me-1"></i>
                                Simpan Status
                            </button>
                        </form>
                    @else
                        <div class="alert alert-danger mb-0">
                            <i class="bi bi-exclamation-circle me-1"></i>
                            Pesanan ini sudah dibatalkan dan tidak dapat diubah lagi.
                        </div>
                    @endif

                </div>
            </div>
        </div>

        {{-- Informasi Pelanggan --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white fw-bold py-3">
                    <i class="bi bi-person-circle me-2 text-primary"></i>
                    Informasi Pelanggan
                </div>

                <div class="card-body">

                    <div class="mb-3">
                        <small class="text-muted">Nama Pelanggan</small>
                        <div class="fw-semibold">{{ $pesanan->nama_pelanggan }}</div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Email</small>
                        <div>{{ $pesanan->email_pelanggan }}</div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Nomor Telepon</small>
                        <div>{{ $pesanan->telepon_pelanggan }}</div>
                    </div>

                    <div>
                        <small class="text-muted">Alamat</small>
                        <div>{{ $pesanan->alamat_pelanggan }}</div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Rincian Laundry --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold py-3">
                    <i class="bi bi-basket2 me-2 text-primary"></i>
                    Rincian Laundry
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">

                            <thead class="table-light">
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Paket</th>
                                    <th>Berat (Kg)</th>
                                    <th>Harga/Kg</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($detail as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama_paket }}</td>
                                        <td>{{ $item->quantity }} Kg</td>
                                        <td>
                                            Rp{{ number_format($item->price, 0, ',', '.') }}
                                        </td>
                                        <td>
                                            Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th colspan="4" class="text-end">Total Harga</th>
                                    <th>
                                        Rp{{ number_format($pesanan->total_price, 0, ',', '.') }}
                                    </th>
                                </tr>
                            </tfoot>

                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    {{-- PENIMBANGAN PAKAIAN --}}
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">
            <i class="bi bi-speedometer2 me-2"></i>
            Penimbangan Pakaian
        </h5>

        @if (($detail[0]->quantity ?? 0) > 0)
            <span class="badge bg-success">Sudah Ditimbang</span>
        @else
            <span class="badge bg-warning text-dark">Belum Ditimbang</span>
        @endif
    </div>

    <div class="card-body">

        <div class="alert alert-info">
            <i class="bi bi-info-circle me-2"></i>
            Berat pakaian dan total harga ditentukan oleh admin setelah pakaian diterima dan ditimbang.
        </div>

        @if (($detail[0]->quantity ?? 0) > 0)
            <div class="mb-3">
                <span class="text-muted">Berat saat ini:</span>
                <h4 class="fw-bold">{{ $detail[0]->quantity }} kg</h4>
            </div>
        @endif

        @if ($pesanan->status !== 'cancelled' && $pesanan->payment_status !== 'paid')

            <form action="{{ route('admin.pesanan.updateWeighing', $pesanan->id) }}"
                  method="POST"
                  id="form-penimbangan">

                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Berat Pakaian (Kg)
                    </label>

                    <input
                        type="number"
                        name="quantity"
                        class="form-control @error('quantity') is-invalid @enderror"
                        min="1"
                        max="1000"
                        step="1"
                        value="{{ old('quantity', $detail[0]->quantity ?? '') }}"
                        placeholder="Masukkan berat pakaian"
                        required
                    >

                    @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <small class="text-muted">
                        Masukkan berat dalam kilogram (bilangan bulat).
                    </small>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>
                    Simpan Hasil Timbangan
                </button>
            </form>

        @elseif ($pesanan->status === 'cancelled')

            <div class="alert alert-danger mb-0">
                Pesanan dibatalkan. Penimbangan tidak dapat dilakukan.
            </div>

        @else

            <div class="alert alert-warning mb-0">
                Pesanan sudah dibayar. Penimbangan tidak dapat diubah.
            </div>

        @endif
    </div>
</div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Konfirmasi perubahan pembayaran
    const formPembayaran = document.getElementById('form-pembayaran');

    if (formPembayaran) {
        formPembayaran.addEventListener('submit', function(e) {
            e.preventDefault();

            const form = this;
            const status = form.querySelector('[name="payment_status"]').value;
            const kode = form.dataset.kode;

            Swal.fire({
                title: 'Simpan Pembayaran?',
                html: `
                    <p>Apakah kamu yakin ingin mengubah pembayaran pesanan:</p>
                    <strong>${escapeHtml(kode)}</strong>
                    <div class="mt-3">
                        Status pembayaran menjadi
                        <strong class="${status === 'paid' ? 'text-success' : 'text-warning'}">
                            ${status === 'paid' ? 'LUNAS' : 'BELUM BAYAR'}
                        </strong>
                    </div>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: '<i class="bi bi-check-circle me-1"></i> Ya, Simpan',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#16a34a',
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
                    form.submit();
                }
            });
        });
    }

    // Konfirmasi perubahan status pesanan
    const formStatus = document.getElementById('form-status-pesanan');

    if (formStatus) {
        formStatus.addEventListener('submit', function(e) {
            e.preventDefault();

            const form = this;
            const status = form.querySelector('[name="status"]').value;
            const kode = form.dataset.kode;

            const dibatalkan = status === 'cancelled';

            Swal.fire({
                title: dibatalkan ? 'Batalkan Pesanan?' : 'Ubah Status Pesanan?',
                html: `
                    <p>Konfirmasi perubahan status pesanan:</p>
                    <strong>${escapeHtml(kode)}</strong>
                    <div class="mt-3">
                        Status baru:
                        <strong class="${dibatalkan ? 'text-danger' : 'text-primary'}">
                            ${escapeHtml(status.toUpperCase())}
                        </strong>
                    </div>
                    ${dibatalkan ? `
                        <p class="text-danger small mt-3 mb-0">
                            <i class="bi bi-exclamation-triangle me-1"></i>
                            Pesanan yang dibatalkan tidak dapat diubah kembali melalui halaman ini.
                        </p>
                    ` : ''}
                `,
                icon: dibatalkan ? 'warning' : 'question',
                showCancelButton: true,
                confirmButtonText: dibatalkan
                    ? '<i class="bi bi-x-circle me-1"></i> Ya, Batalkan'
                    : '<i class="bi bi-check-circle me-1"></i> Ya, Ubah Status',
                cancelButtonText: 'Tidak Jadi',
                confirmButtonColor: dibatalkan ? '#dc2626' : '#2563eb',
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
                    form.submit();
                }
            });
        });
    }

    function escapeHtml(text) {
        const element = document.createElement('div');
        element.textContent = text;
        return element.innerHTML;
    }

});
const formPenimbangan = document.getElementById('form-penimbangan');

if (formPenimbangan) {
    formPenimbangan.addEventListener('submit', function(e) {
        e.preventDefault();

        const berat = this.querySelector('[name="quantity"]').value;

        Swal.fire({
            title: 'Simpan Hasil Timbangan?',
            text: `Berat pakaian yang akan disimpan: ${berat} kg`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Simpan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#696cff',
            cancelButtonColor: '#8592a3'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
}
</script>

@endpush
