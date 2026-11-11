 @extends('layouts.app')

@section('title', 'Tambah Pengantaran - LaundryKu')
@section('page-title', 'Tambah Pengantaran')

@section('content')

<div class="container-fluid">

    <div class="mb-4">
        <h4 class="fw-bold mb-1">Tambah Pengantaran</h4>
        <p class="text-muted mb-0">Pilih pesanan layanan antar dan tentukan kurir yang bertugas.</p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if($pesanan->isEmpty())
                <div class="alert alert-info mb-0">
                    Belum ada pesanan layanan Cuci Setrika Antar yang bisa ditugaskan.
                </div>
            @else

                <form action="{{ route('admin.pengantaran.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pesanan Pelanggan</label>
                        <select name="order_id" class="form-select" required>
                            <option value="">-- Pilih Pesanan --</option>

                            @foreach($pesanan as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('order_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->order_code }} - {{ $item->nama_pelanggan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pilih Kurir</label>
                        <select name="courier_id" class="form-select" required>
                            <option value="">-- Pilih Kurir --</option>

                            @foreach($kurir as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('courier_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Alamat Penjemputan</label>
                        <textarea name="pickup_address"
                                  class="form-control"
                                  rows="3"
                                  placeholder="Masukkan alamat penjemputan"
                                  required>{{ old('pickup_address') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Alamat Pengantaran</label>
                        <textarea name="delivery_address"
                                  class="form-control"
                                  rows="3"
                                  placeholder="Masukkan alamat tujuan pengantaran"
                                  required>{{ old('delivery_address') }}</textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>
                            Simpan Pengantaran
                        </button>

                        <a href="{{ route('admin.pengantaran.index') }}"
                           class="btn btn-light border">
                            Kembali
                        </a>
                    </div>

                </form>

            @endif

        </div>
    </div>

</div>

@endsection