
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LaundryKu Customer')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #2563eb;
            --sidebar: #172554;
            --sidebar-hover: #263b72;
            --bg: #f5f7fb;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--bg);
            font-family: 'Segoe UI', sans-serif;
            color: #1e293b;
        }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: var(--sidebar);
            color: white;
            padding: 25px 18px;
            z-index: 1000;
            transition: .3s;
            overflow-y: auto;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 23px;
            font-weight: 800;
            padding: 5px 10px 35px;
        }

        .brand-icon {
            width: 42px;
            height: 42px;
            border-radius: 13px;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .menu-label {
            color: #94a3b8;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            margin: 15px 12px 12px;
        }

        .sidebar a,
        .sidebar-action {
            display: flex;
            align-items: center;
            gap: 13px;
            width: 100%;
            color: #cbd5e1;
            text-decoration: none;
            padding: 13px 14px;
            border: none;
            border-radius: 10px;
            margin-bottom: 7px;
            font-size: 14px;
            background: transparent;
            text-align: left;
            transition: .2s;
            cursor: pointer;
        }

        .sidebar a:hover,
        .sidebar a.active,
        .sidebar-action:hover {
            color: white;
            background: var(--sidebar-hover);
        }

        .sidebar a.active {
            background: var(--primary);
            box-shadow: 0 5px 15px rgba(37, 99, 235, .25);
        }

        .sidebar a i,
        .sidebar-action i {
            font-size: 18px;
        }

        .sidebar-bottom {
            margin-top: 35px;
            border-top: 1px solid rgba(255,255,255,.12);
            padding-top: 18px;
        }

        .logout-button {
            color: #fecaca;
        }

        .logout-button:hover {
            color: white;
            background: rgba(220, 38, 38, .2);
        }

        /* MAIN CONTENT */
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            transition: .3s;
        }

        .content-wrapper {
            padding: 30px;
        }

        /* TOPBAR: HANYA UNTUK TOMBOL MENU MOBILE */
        .mobile-topbar {
            display: none;
            height: 60px;
            background: white;
            align-items: center;
            padding: 0 18px;
            border-bottom: 1px solid #e9edf5;
        }

        .mobile-toggle {
            border: none;
            background: transparent;
            font-size: 27px;
            color: #1e293b;
            cursor: pointer;
        }

        .sidebar-overlay {
            display: none;
        }

        /* MODAL PROFIL */
        .profile-modal {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 2000;
            background: rgba(15, 23, 42, .55);
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .profile-modal.show {
            display: flex;
        }

        .profile-box {
            width: 100%;
            max-width: 430px;
            background: white;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .2);
            animation: profileShow .2s ease;
        }

        @keyframes profileShow {
            from {
                opacity: 0;
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .profile-header {
            position: relative;
            padding: 28px 25px;
            text-align: center;
            color: white;
            background: linear-gradient(120deg, #1d4ed8, #3b82f6);
        }

        .profile-close {
            position: absolute;
            top: 13px;
            right: 15px;
            border: none;
            background: transparent;
            color: white;
            font-size: 23px;
            cursor: pointer;
        }

        .profile-avatar {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            border-radius: 50%;
            background: white;
            color: #2563eb;
            font-size: 32px;
        }

        .profile-header h5 {
            margin-bottom: 5px;
            font-weight: 800;
        }

        .profile-header p {
            margin: 0;
            color: #dbeafe;
            font-size: 13px;
        }

        .profile-body {
            padding: 23px;
        }

        .profile-data {
            display: flex;
            align-items: flex-start;
            gap: 13px;
            padding: 13px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .profile-data:last-child {
            border-bottom: none;
        }

        .profile-data-icon {
            width: 38px;
            height: 38px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            background: #eff6ff;
            color: #2563eb;
            font-size: 17px;
        }

        .profile-data small {
            display: block;
            margin-bottom: 3px;
            color: #94a3b8;
            font-size: 11px;
        }

        .profile-data strong {
            color: #334155;
            font-size: 13px;
            font-weight: 650;
            overflow-wrap: anywhere;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .mobile-topbar {
                display: flex;
            }

            .content-wrapper {
                padding: 20px 15px;
            }

            .sidebar-overlay.show {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(15, 23, 42, .5);
                z-index: 999;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    {{-- SIDEBAR --}}
    <aside class="sidebar" id="sidebar">

        <div class="brand">
            <div class="brand-icon">
                <i class="bi bi-droplet-fill"></i>
            </div>
            LaundryKu
        </div>

        <div class="menu-label">MENU UTAMA</div>

        <a href="{{ route('customer.dashboard') }}"
           class="{{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid"></i>
            Dashboard
        </a>

        <a href="{{ route('customer.pesanan.create') }}"
           class="{{ request()->routeIs('customer.pesanan.create') ? 'active' : '' }}">
            <i class="bi bi-plus-circle"></i>
            Buat Pesanan
        </a>


        <div class="menu-label">AKTIVITAS</div>

        <a href="{{ route('customer.pesanan.index') }}"
           class="{{ request()->routeIs('customer.pesanan.index') || request()->routeIs('customer.pesanan.show') ? 'active' : '' }}">
            <i class="bi bi-receipt"></i>
            Pesanan Saya
        </a>

       <a href="{{ route('customer.riwayat.index') }}"
   class="{{ request()->routeIs('customer.riwayat.*') ? 'active' : '' }}">
    <i class="bi bi-clock-history"></i>
    <span>Riwayat Pesanan</span>
</a>

        <div class="sidebar-bottom">
            <div class="menu-label">AKUN</div>

            {{-- TOMBOL PROFIL --}}
            <button type="button" class="sidebar-action" id="openProfile">
                <i class="bi bi-person-circle"></i>
                Profil Saya
            </button>

            {{-- LOGOUT --}}
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="sidebar-action logout-button">
                    <i class="bi bi-box-arrow-right"></i>
                    Keluar
                </button>
            </form>
        </div>

    </aside>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    {{-- MAIN CONTENT --}}
    <main class="main-content">

        {{-- TOPBAR MOBILE SAJA --}}
        <header class="mobile-topbar">
            <button class="mobile-toggle" id="sidebarToggle" type="button">
                <i class="bi bi-list"></i>
            </button>
        </header>

        <section class="content-wrapper">
            @yield('content')
        </section>

    </main>

    {{-- MODAL PROFIL --}}
    <div class="profile-modal" id="profileModal">
        <div class="profile-box">

            <div class="profile-header">
                <button type="button" class="profile-close" id="closeProfile">
                    <i class="bi bi-x-lg"></i>
                </button>

                <div class="profile-avatar">
                    <i class="bi bi-person-fill"></i>
                </div>

                <h5>{{ Auth::user()->name }}</h5>
                <p>Informasi Akun Pelanggan LaundryKu</p>
            </div>

            <div class="profile-body">

                <div class="profile-data">
                    <div class="profile-data-icon">
                        <i class="bi bi-person"></i>
                    </div>
                    <div>
                        <small>Nama Lengkap</small>
                        <strong>{{ Auth::user()->name }}</strong>
                    </div>
                </div>

                <div class="profile-data">
                    <div class="profile-data-icon">
                        <i class="bi bi-envelope"></i>
                    </div>
                    <div>
                        <small>Email</small>
                        <strong>{{ Auth::user()->email }}</strong>
                    </div>
                </div>

                <div class="profile-data">
                    <div class="profile-data-icon">
                        <i class="bi bi-telephone"></i>
                    </div>
                    <div>
                        <small>Nomor Telepon</small>
                        <strong>{{ Auth::user()->phone ?: '-' }}</strong>
                    </div>
                </div>

                <div class="profile-data">
                    <div class="profile-data-icon">
                        <i class="bi bi-geo-alt"></i>
                    </div>
                    <div>
                        <small>Alamat</small>
                        <strong>{{ Auth::user()->address ?: '-' }}</strong>
                    </div>
                </div>

                <button type="button" class="btn btn-primary w-100 mt-3"
                        id="doneProfile">
                    Tutup
                </button>

            </div>
        </div>
    </div>

    <script>
        // SIDEBAR MOBILE
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggle = document.getElementById('sidebarToggle');

        if (toggle) {
            toggle.addEventListener('click', function () {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            });
        }

        overlay.addEventListener('click', function () {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        });

        // MODAL PROFIL
        const profileModal = document.getElementById('profileModal');
        const openProfile = document.getElementById('openProfile');
        const closeProfile = document.getElementById('closeProfile');
        const doneProfile = document.getElementById('doneProfile');

        openProfile.addEventListener('click', function () {
            profileModal.classList.add('show');

            // Tutup sidebar otomatis pada layar HP
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        });

        function hideProfile() {
            profileModal.classList.remove('show');
        }

        closeProfile.addEventListener('click', hideProfile);
        doneProfile.addEventListener('click', hideProfile);

        profileModal.addEventListener('click', function (event) {
            if (event.target === profileModal) {
                hideProfile();
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                hideProfile();
            }
        });
    </script>

    @stack('scripts')

</body>
</html>
