
@extends('customer.layouts.app')

@section('title', 'Paket Laundry - LaundryKu')
@section('page-title', 'Paket Laundry')

@section('content')

<div class="package-header mb-4">
    <div>
        <span class="package-label">LAYANAN KAMI</span>
        <h3 class="fw-bold mt-2">Pilih Paket Laundry Favoritmu</h3>
        <p class="text-muted mb-0">
            Temukan layanan laundry yang sesuai dengan kebutuhanmu.
        </p>
    </div>

    <div class="package-header-icon">
        <i class="bi bi-basket2-fill"></i>
    </div>
</div>

<div class="row g-4">

    @forelse($paket as $item)

        <div class="col-md-6 col-xl-4">

            <div class="package-card h-100">

                <div class="package-icon">
                    <i class="bi bi-droplet-half"></i>
                </div>

                <h5 class="fw-bold mt-3">
                    {{ $item->name }}
                </h5>

                <p class="text-muted package-description">
                    {{ $item->description ?: 'Layanan laundry berkualitas untuk pakaianmu.' }}
                </p>

                <div class="package-price">
                    Rp{{ number_format((float) $item->price, 0, ',', '.') }}
                    <span>/ kg</span>
                </div>

                <div class="package-duration">
                    <i class="bi bi-clock me-2"></i>
                    Estimasi {{ $item->duration }} hari
                </div>

                <div class="package-divider"></div>

                <div class="package-feature">
                    <i class="bi bi-check-circle-fill"></i>
                    Ditangani dengan profesional
                </div>

                <div class="package-feature">
                    <i class="bi bi-check-circle-fill"></i>
                    Pakaian bersih dan wangi
                </div>

                @if($item->name === 'Cuci Setrika Antar')
                    <div class="package-feature">
                        <i class="bi bi-check-circle-fill"></i>
                        Layanan antar-jemput
                    </div>
                @endif

                <button type="button" class="btn btn-primary w-100 mt-4"
                    onclick="Swal.fire({
                        icon: 'info',
                        title: 'Paket Dipilih',
                        text: 'Fitur pemesanan paket ini akan kita aktifkan pada tahap berikutnya.',
                        confirmButtonText: 'Mengerti',
                        confirmButtonColor: '#2563eb'
                    })">
                    <i class="bi bi-bag-plus me-2"></i>
                    Pilih Paket
                </button>

            </div>

        </div>

    @empty

        <div class="col-12">
            <div class="empty-package">
                <i class="bi bi-box-seam"></i>
                <h5 class="fw-bold mt-3">Belum Ada Paket Laundry</h5>
                <p class="text-muted mb-0">
                    Paket laundry belum tersedia saat ini.
                </p>
            </div>
        </div>

    @endforelse

</div>

<style>
    .package-header {
        background: white;
        border: 1px solid #edf0f5;
        border-radius: 17px;
        padding: 27px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .package-label {
        font-size: 11px;
        letter-spacing: 2px;
        color: #2563eb;
        font-weight: 800;
    }

    .package-header-icon {
        width: 65px;
        height: 65px;
        background: #dbeafe;
        color: #2563eb;
        border-radius: 17px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
    }

    .package-card {
        background: white;
        border: 1px solid #edf0f5;
        border-radius: 17px;
        padding: 25px;
        transition: .25s;
    }

    .package-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(15, 23, 42, .08);
        border-color: #bfdbfe;
    }

    .package-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 25px;
    }

    .package-description {
        min-height: 45px;
        font-size: 13px;
        line-height: 1.7;
    }

    .package-price {
        font-size: 27px;
        font-weight: 800;
        color: #2563eb;
        margin-top: 20px;
    }

    .package-price span {
        font-size: 13px;
        font-weight: 500;
        color: #64748b;
    }

    .package-duration {
        color: #64748b;
        font-size: 13px;
        margin-top: 7px;
    }

    .package-divider {
        border-top: 1px solid #edf0f5;
        margin: 20px 0;
    }

    .package-feature {
        font-size: 13px;
        margin-bottom: 12px;
        color: #475569;
    }

    .package-feature i {
        color: #16a34a;
        margin-right: 7px;
    }

    .empty-package {
        text-align: center;
        padding: 65px 20px;
        background: white;
        border-radius: 17px;
    }

    .empty-package > i {
        font-size: 50px;
        color: #94a3b8;
    }
</style>

@endsection
