
@extends('customer.layouts.app')

@section('title', 'Buat Pesanan - LaundryKu')
@section('page-title', 'Buat Pesanan')

@section('content')

<div class="page-heading">
    <div>
        <h4>Buat Pesanan Baru</h4>
        <p>Pilih layanan laundry yang kamu inginkan.</p>
    </div>

    <a href="{{ route('customer.pesanan.index') }}" class="back-link">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<form action="{{ route('customer.pesanan.store') }}" method="POST" id="orderForm">
    @csrf

    <div class="row g-4">

        <div class="col-lg-8">
            <div class="form-panel">

                <div class="section-heading">
                    <div class="section-icon">
                        <i class="bi bi-basket2"></i>
                    </div>
                    <div>
                        <h5>Pilih Paket Laundry</h5>
                        <p>Tentukan paket sesuai kebutuhanmu.</p>
                    </div>
                </div>

                <div class="row g-3">

                    @forelse($paket as $item)
                        <div class="col-md-6">

                            <label class="package-option">
                                <input
                                    type="radio"
                                    name="package_id"
                                    value="{{ $item->id }}"
                                    data-name="{{ $item->name }}"
                                    class="package-radio"
                                    {{ old('package_id') == $item->id ? 'checked' : '' }}
                                    required
                                >

                                <div class="package-content">
                                    <div class="package-top">
                                        <strong>{{ $item->name }}</strong>
                                        <i class="bi bi-check-circle-fill"></i>
                                    </div>

                                    <p>{{ $item->description }}</p>

                                    <div class="package-price">
                                        Rp{{ number_format($item->price, 0, ',', '.') }}
                                        <small>/kg</small>
                                    </div>

                                    <small class="duration">
                                        <i class="bi bi-clock"></i>
                                        {{ $item->duration }} hari pengerjaan
                                    </small>
                                </div>
                            </label>

                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-muted">Belum ada paket tersedia.</p>
                        </div>
                    @endforelse

                </div>

                <div id="deliveryFields" class="delivery-fields mt-4" style="display:none;">

                    <div class="section-heading mb-3">
                        <div class="section-icon delivery-icon">
                            <i class="bi bi-truck"></i>
                        </div>
                        <div>
                            <h5>Informasi Antar-Jemput</h5>
                            <p>Lengkapi alamat penjemputan dan pengantaran.</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat Penjemputan <span>*</span></label>
                        <textarea
                            name="pickup_address"
                            id="pickup_address"
                            class="form-control"
                            rows="3"
                            placeholder="Masukkan alamat lengkap penjemputan..."
                        >{{ old('pickup_address') }}</textarea>
                    </div>

                    <div class="mb-0">
                        <label class="form-label">Alamat Pengantaran <span>*</span></label>
                        <textarea
                            name="delivery_address"
                            id="delivery_address"
                            class="form-control"
                            rows="3"
                            placeholder="Masukkan alamat lengkap pengantaran..."
                        >{{ old('delivery_address') }}</textarea>
                    </div>

                    <div class="delivery-info mt-3">
                        <i class="bi bi-info-circle-fill"></i>
                        Admin akan menentukan kurir untuk menjemput dan mengantarkan pakaianmu.
                    </div>

                </div>

                <div class="admin-info mt-4">
                    <i class="bi bi-shield-check"></i>
                    <div>
                        <strong>Penimbangan oleh Admin</strong>
                        <p>
                            Kamu tidak perlu memasukkan berat atau harga.
                            Admin akan menimbang pakaian dan menentukan total biaya.
                        </p>
                    </div>
                </div>

                <button type="submit" class="btn-submit" id="submitOrder">
                    <i class="bi bi-check-circle"></i>
                    Kirim Pesanan
                </button>

            </div>
        </div>

        <div class="col-lg-4">
            <div class="summary-panel">

                <div class="summary-top-icon">
                    <i class="bi bi-receipt"></i>
                </div>

                <h5>Ringkasan Pesanan</h5>
                <p>Paket yang kamu pilih akan ditampilkan di sini.</p>

                <div class="summary-line"></div>

                <small>Paket Pilihan</small>
                <h6 id="summaryPackage">Belum dipilih</h6>

                <div class="summary-line"></div>

                <div class="summary-status">
                    <i class="bi bi-hourglass-split"></i>
                    <div>
                        <strong>Menunggu Penimbangan</strong>
                        <p>Harga akhir ditentukan setelah pakaian ditimbang Admin.</p>
                    </div>
                </div>

            </div>
        </div>

    </div>
</form>

<style>
    .page-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 24px;
    }

    .page-heading h4 {
        font-weight: 750;
        color: #1e293b;
        margin-bottom: 5px;
    }

    .page-heading p {
        font-size: 13px;
        color: #94a3b8;
        margin: 0;
    }

    .back-link {
        color: #64748b;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
    }

    .form-panel, .summary-panel {
        background: white;
        border: 1px solid #edf0f5;
        border-radius: 13px;
        padding: 25px;
    }

    .section-heading {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 23px;
    }

    .section-icon, .summary-top-icon {
        width: 43px;
        height: 43px;
        background: #eff6ff;
        color: #2563eb;
        border-radius: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .section-heading h5 {
        font-size: 15px;
        font-weight: 750;
        margin-bottom: 4px;
    }

    .section-heading p {
        font-size: 12px;
        color: #94a3b8;
        margin: 0;
    }

    .package-option {
        display: block;
        height: 100%;
        cursor: pointer;
    }

    .package-radio {
        position: absolute;
        opacity: 0;
    }

    .package-content {
        border: 1px solid #e2e8f0;
        border-radius: 11px;
        padding: 17px;
        height: 100%;
        transition: .2s;
    }

    .package-content:hover {
        border-color: #93c5fd;
    }

    .package-radio:checked + .package-content {
        border: 1.5px solid #2563eb;
        background: #f8fbff;
    }

    .package-top {
        display: flex;
        justify-content: space-between;
        gap: 8px;
        color: #334155;
    }

    .package-top i {
        color: #2563eb;
        opacity: 0;
    }

    .package-radio:checked + .package-content .package-top i {
        opacity: 1;
    }

    .package-content p {
        font-size: 12px;
        color: #94a3b8;
        margin: 12px 0;
        min-height: 34px;
    }

    .package-price {
        color: #2563eb;
        font-size: 17px;
        font-weight: 750;
    }

    .package-price small {
        font-size: 11px;
        font-weight: 400;
    }

    .duration {
        display: block;
        color: #94a3b8;
        font-size: 11px;
        margin-top: 8px;
    }

    .delivery-fields {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 20px;
        border-radius: 11px;
    }

    .delivery-icon {
        background: #ecfdf5;
        color: #059669;
    }

    .form-label {
        font-size: 12px;
        font-weight: 650;
        color: #475569;
    }

    .form-label span {
        color: #ef4444;
    }

    .form-control {
        border-color: #e2e8f0;
        font-size: 13px;
        padding: 11px 13px;
    }

    .form-control:focus {
        border-color: #60a5fa;
        box-shadow: 0 0 0 3px rgba(37,99,235,.08);
    }

    .delivery-info {
        padding: 12px;
        background: #eff6ff;
        border-radius: 8px;
        color: #1d4ed8;
        font-size: 11px;
        line-height: 1.6;
    }

    .admin-info {
        display: flex;
        gap: 12px;
        padding: 15px;
        border-radius: 10px;
        background: #f0fdf4;
        color: #15803d;
    }

    .admin-info > i {
        font-size: 19px;
    }

    .admin-info strong {
        font-size: 12px;
    }

    .admin-info p {
        margin: 4px 0 0;
        font-size: 11px;
        line-height: 1.6;
    }

    .btn-submit {
        width: 100%;
        border: 0;
        background: #2563eb;
        color: white;
        border-radius: 9px;
        padding: 13px;
        font-size: 13px;
        font-weight: 650;
        margin-top: 22px;
        transition: .2s;
    }

    .btn-submit:hover {
        background: #1d4ed8;
    }

    .summary-panel {
        position: sticky;
        top: 90px;
    }

    .summary-top-icon {
        width: 48px;
        height: 48px;
        font-size: 22px;
    }

    .summary-panel h5 {
        font-size: 16px;
        font-weight: 750;
        margin-top: 17px;
    }

    .summary-panel > p {
        font-size: 12px;
        color: #94a3b8;
    }

    .summary-line {
        border-top: 1px dashed #e2e8f0;
        margin: 20px 0;
    }

    .summary-panel small {
        color: #94a3b8;
    }

    .summary-panel h6 {
        font-weight: 700;
        margin-top: 7px;
    }

    .summary-status {
        display: flex;
        gap: 10px;
        background: #eff6ff;
        color: #1d4ed8;
        padding: 13px;
        border-radius: 9px;
    }

    .summary-status > i {
        font-size: 17px;
    }

    .summary-status strong {
        font-size: 11px;
    }

    .summary-status p {
        font-size: 10px;
        line-height: 1.6;
        margin: 4px 0 0;
    }

    @media(max-width: 576px) {
        .form-panel, .summary-panel {
            padding: 18px;
        }
    }
</style>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const packageRadios = document.querySelectorAll('.package-radio');
    const deliveryFields = document.getElementById('deliveryFields');
    const pickupAddress = document.getElementById('pickup_address');
    const deliveryAddress = document.getElementById('delivery_address');
    const summaryPackage = document.getElementById('summaryPackage');
    const orderForm = document.getElementById('orderForm');

    function updatePackage() {
        const selected = document.querySelector('.package-radio:checked');

        if (!selected) {
            summaryPackage.textContent = 'Belum dipilih';
            deliveryFields.style.display = 'none';
            pickupAddress.required = false;
            deliveryAddress.required = false;
            return;
        }

        const isDelivery = selected.dataset.name === 'Cuci Setrika Antar';

        summaryPackage.textContent = selected.dataset.name;
        deliveryFields.style.display = isDelivery ? 'block' : 'none';

        pickupAddress.required = isDelivery;
        deliveryAddress.required = isDelivery;
    }

    packageRadios.forEach(radio => {
        radio.addEventListener('change', updatePackage);
    });

    updatePackage();

    orderForm.addEventListener('submit', function(e) {
        const selected = document.querySelector('.package-radio:checked');

        if (!selected) {
            e.preventDefault();

            Swal.fire({
                icon: 'warning',
                title: 'Paket Belum Dipilih',
                text: 'Silakan pilih paket laundry terlebih dahulu.',
                confirmButtonColor: '#2563eb'
            });

            return;
        }

        if (
            selected.dataset.name === 'Cuci Setrika Antar' &&
            (!pickupAddress.value.trim() || !deliveryAddress.value.trim())
        ) {
            e.preventDefault();

            Swal.fire({
                icon: 'warning',
                title: 'Alamat Belum Lengkap',
                text: 'Silakan isi alamat penjemputan dan pengantaran.',
                confirmButtonColor: '#2563eb'
            });
        }
    });
</script>

@if($errors->any())
<script>
    Swal.fire({
        icon: 'error',
        title: 'Data Belum Lengkap',
        html: @json(implode('<br>', $errors->all())),
        confirmButtonColor: '#2563eb'
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal Membuat Pesanan',
        text: @json(session('error')),
        confirmButtonColor: '#2563eb'
    });
</script>
@endif
@endpush
