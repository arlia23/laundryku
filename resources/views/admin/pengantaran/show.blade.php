 @extends('layouts.app')

@section('title', 'Detail Pengantaran - LaundryKu')
@section('page-title', 'Detail Pengantaran')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Detail Pengantaran</h4>
            <p class="text-muted mb-0">Informasi lengkap penugasan pengantaran.</p>
        </div>

        <a href="{{ route('admin.pengantaran.index') }}" class="btn btn-light border">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row g-4">

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Informasi Pesanan</h5>

                    <div class="mb-3">
                        <small class="text-muted">Kode Pesanan</small>
                        <div class="fw-semibold">{{ $item->order_code }}</div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Tanggal Pesanan</small>
                        <div>{{ \Carbon\Carbon::parse($item->order_date)->translatedFormat('d F Y') }}</div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Total Pesanan</small>
                        <div class="fw-bold text-primary">
                            Rp{{ number_format($item->total_price, 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Status Pesanan</small>
                        <div>{{ ucfirst($item->status_pesanan) }}</div>
                    </div>

                    <div>
                        <small class="text-muted">Status Pembayaran</small>
                        <div>{{ ucfirst($item->payment_status) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Informasi Pelanggan</h5>

                    <div class="mb-3">
                        <small class="text-muted">Nama Pelanggan</small>
                        <div class="fw-semibold">{{ $item->nama_pelanggan }}</div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Email</small>
                        <div>{{ $item->email_pelanggan }}</div>
                    </div>

                    <div>
                        <small class="text-muted">Nomor Telepon</small>
                        <div>{{ $item->telepon_pelanggan ?: '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

       
<div class="col-lg-6">
    <div class="card border-0 shadow-sm h-100">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-4">Informasi Kurir</h5>

            <div class="mb-3">
                <small class="text-muted">Nama Kurir Saat Ini</small>
                <div class="fw-semibold">
                    {{ $item->nama_kurir ?? 'Belum ditentukan' }}
                </div>
            </div>

            <div class="mb-4">
                <small class="text-muted">Nomor Telepon Kurir</small>
                <div>{{ $item->telepon_kurir ?: '-' }}</div>
            </div>

            @if(
                $item->status_pesanan !== 'cancelled' &&
                $item->pickup_status !== 'picked_up' &&
                $item->delivery_status !== 'delivered'
            )
                <hr>

                <form action="{{ route('admin.pengantaran.assignCourier', $item->id) }}"
                      method="POST">

                    @csrf
                    @method('PATCH')

                    <label class="form-label fw-semibold">
                        {{ $item->courier_id ? 'Ganti Kurir' : 'Tugaskan Kurir' }}
                    </label>

                    <select name="courier_id" class="form-select mb-3" required>
                        <option value="">-- Pilih Kurir --</option>

                        @foreach($kurir as $k)
                            <option value="{{ $k->id }}"
                                {{ $item->courier_id == $k->id ? 'selected' : '' }}>
                                {{ $k->name }} - {{ $k->phone }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-person-check me-1"></i>
                        {{ $item->courier_id ? 'Simpan Perubahan Kurir' : 'Tugaskan Kurir' }}
                    </button>
                </form>
            @else
                <div class="alert alert-info mb-0">
                    Penugasan kurir tidak dapat diubah karena pesanan sudah dibatalkan
                    atau proses pengantaran sudah berjalan.
                </div>
            @endif
        </div>
    </div>
</div>


        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Informasi Alamat</h5>

                    <div class="mb-3">
                        <small class="text-muted">Alamat Penjemputan</small>
                        <div>{{ $item->pickup_address }}</div>
                    </div>

                    <div>
                        <small class="text-muted">Alamat Pengantaran</small>
                        <div>{{ $item->delivery_address }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Status Pengantaran</h5>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <small class="text-muted">Penjemputan</small>
                            <div class="mt-2">
                                @if($item->pickup_status == 'picked_up')
                                    <span class="badge bg-success">Sudah Dijemput</span>
                                @else
                                    <span class="badge bg-warning text-dark">Menunggu Penjemputan</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted">Pengantaran</small>
                            <div class="mt-2">
                                @if($item->delivery_status == 'delivered')
                                    <span class="badge bg-success">Sudah Diantarkan</span>
                                @else
                                    <span class="badge bg-warning text-dark">Menunggu Pengantaran</span>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

</div>

@endsection