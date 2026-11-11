<aside class="sidebar">

    <div class="brand">
        <i class="bi bi-droplet-fill"></i>
        LaundryKu
    </div>

    <small class="text-uppercase text-secondary">Menu Utama</small>

    <a href="{{ route('admin.dashboard') }}" class="active">
        <i class="bi bi-grid me-2"></i>
        Dashboard
    </a>

    <a href="{{ route('admin.pelanggan.index') }}"
    class="{{ request()->routeIs('admin.pelanggan.*') ? 'active' : '' }}">
    <i class="bi bi-people me-2"></i>
    Pelanggan
    </a>

    <a href="{{ route('admin.pesanan.index') }}"
    class="{{ request()->routeIs('admin.pesanan.*') ? 'active' : '' }}">
    <i class="bi bi-receipt me-2"></i>
    Pesanan
    </a>

   <a href="{{ route('admin.paket.index') }}"
   class="{{ request()->routeIs('admin.paket.*') ? 'active' : '' }}">
    <i class="bi bi-box-seam me-2"></i>
    Paket Laundry
</a>
    <a href="{{ route('admin.mesin.index') }}">
    <i class="bi bi-gear me-2"></i>
    Mesin Laundry
</a>

    <a href="{{ route('admin.kurir.index') }}">
    <i class="bi bi-truck me-2"></i>
    Kurir
</a>
<a href="{{ route('admin.pengantaran.index') }}"
   class="{{ request()->routeIs('admin.pengantaran.*') ? 'active' : '' }}">
    <i class="bi bi-truck-flatbed me-2"></i>
    Pengantaran
</a>


    <hr class="border-secondary">

    <small class="text-uppercase text-secondary">Akun</small>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit"
                class="btn text-start text-light w-100 mt-2">
            <i class="bi bi-box-arrow-right me-2"></i>
            Logout
        </button>
    </form>

</aside>
