
@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h3 class="fw-bold mb-1">Tambah Pesanan</h3>
        <p class="text-muted mb-0">Masukkan data pesanan laundry baru.</p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <form action="{{ route('admin.pesanan.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Pelanggan</label>
                    <select name="customer_id"
                        class="form-select @error('customer_id') is-invalid @enderror"
                        required>
                        <option value="">-- Pilih Pelanggan --</option>

                        @foreach ($pelanggan as $item)
                            <option value="{{ $item->id }}"
                                {{ old('customer_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('customer_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Paket Laundry</label>
                    <select name="package_id" id="package_id"
                        class="form-select @error('package_id') is-invalid @enderror"
                        required>
                        <option value="">-- Pilih Paket Laundry --</option>

                        @foreach ($paket as $item)
                            <option value="{{ $item->id }}"
                                data-price="{{ $item->price }}"
                                {{ old('package_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->name }} - Rp{{ number_format($item->price, 0, ',', '.') }}/kg
                            </option>
                        @endforeach
                    </select>

                    @error('package_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Berat Cucian (Kg)</label>
                    <input type="number" name="quantity" id="quantity"
                        class="form-control @error('quantity') is-invalid @enderror"
                        placeholder="Contoh: 3"
                        min="1" step="1"
                        value="{{ old('quantity') }}"
                        required>

                    @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <small class="text-muted">
                        Masukkan berat cucian setelah ditimbang.
                    </small>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Tanggal Pesanan</label>
                    <input type="date" name="order_date"
                        class="form-control @error('order_date') is-invalid @enderror"
                        value="{{ old('order_date', date('Y-m-d')) }}"
                        required>

                    @error('order_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="alert alert-info">
                    <div class="fw-semibold">Perkiraan Total Harga</div>
                    <h4 class="mb-0 mt-2" id="total_price">Rp0</h4>
                    <small>Harga dihitung dari harga paket × berat cucian.</small>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>
                        Simpan Pesanan
                    </button>

                    <a href="{{ route('admin.pesanan.index') }}"
                        class="btn btn-secondary">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    const packageSelect = document.getElementById('package_id');
    const quantityInput = document.getElementById('quantity');
    const totalPrice = document.getElementById('total_price');

    function calculateTotal() {
        const selectedOption = packageSelect.options[packageSelect.selectedIndex];
        const price = Number(selectedOption.dataset.price || 0);
        const quantity = Number(quantityInput.value || 0);

        const total = price * quantity;

        totalPrice.textContent = 'Rp' + total.toLocaleString('id-ID');
    }

    packageSelect.addEventListener('change', calculateTotal);
    quantityInput.addEventListener('input', calculateTotal);

    calculateTotal();
</script>
@endsection
