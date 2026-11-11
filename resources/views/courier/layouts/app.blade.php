
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'LaundryKu - Kurir')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background: #f5f7fb;
            font-family: Arial, sans-serif;
            margin: 0;
            color: #1e293b;
        }

        /* ================= SIDEBAR ================= */

        .sidebar {
            width: 250px;
            height: 100vh;
            background: #172554;
            position: fixed;
            top: 0;
            left: 0;
            padding: 25px 18px;
            color: white;
            z-index: 1000;
        }

        .brand {
            font-size: 23px;
            font-weight: 700;
            margin-bottom: 35px;
            padding-left: 10px;
        }

        .brand i {
            color: #38bdf8;
            margin-right: 8px;
        }

        .sidebar small {
            color: #94a3b8;
            display: block;
            margin: 20px 10px 10px;
            font-size: 11px;
            letter-spacing: 1px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #cbd5e1;
            text-decoration: none;
            padding: 12px 14px;
            border-radius: 8px;
            margin-bottom: 6px;
            transition: .2s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #2563eb;
            color: white;
        }

        .sidebar a i {
            font-size: 18px;
        }

        /* ================= MAIN CONTENT ================= */

        .main-content {
            margin-left: 250px;
            min-height: 100vh;
        }

        /* ================= TOPBAR ================= */

        .topbar {
            background: #ffffff;
            min-height: 76px;
            padding: 12px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: none;
            box-shadow: 0 2px 12px rgba(15, 23, 42, 0.04);
        }

        .topbar h5 {
            color: #172554;
            font-size: 21px;
            font-weight: 700;
        }

        /* Tombol profil tanpa border */

        .user-info {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 6px 8px;
            background: transparent !important;
            border: 0 !important;
            outline: none !important;
            box-shadow: none !important;
            color: #1e293b;
            font-size: 15px;
            font-weight: 700;
            border-radius: 30px;
            cursor: pointer;
            transition: background .2s ease;
        }

        .user-info:hover {
            background: #f1f5f9 !important;
        }

        .user-info:focus,
        .user-info:active,
        .user-info:focus-visible {
            border: 0 !important;
            outline: none !important;
            box-shadow: none !important;
        }

        .user-avatar {
            width: 43px;
            height: 43px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #eff6ff;
            color: #2563eb;
            font-size: 23px;
            flex-shrink: 0;
        }

        .user-info .user-name {
            color: #172554;
        }

        .user-info .bi-chevron-down {
            font-size: 12px;
            color: #94a3b8;
            margin-left: 2px;
        }

        /* ================= CONTENT ================= */

        .content {
            padding: 30px;
        }

        /* ================= MODAL PROFIL ================= */

        #profilKurir .modal-dialog {
            max-width: 500px;
        }

        #profilKurir .modal-content {
            border: none;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(15, 23, 42, .20);
        }

        #profilKurir .modal-header {
            background: linear-gradient(120deg, #1e40af, #2563eb);
            color: white;
            padding: 22px 26px;
            border: none;
        }

        #profilKurir .modal-header h5 {
            font-size: 19px;
            font-weight: 700;
        }

        #profilKurir .modal-header .btn-close {
            filter: brightness(0) invert(1);
            opacity: 1;
        }

        #profilKurir .profile-top {
            text-align: center;
            padding: 10px 0 25px;
        }

        #profilKurir .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: #eff6ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            margin: auto;
            box-shadow: 0 8px 25px rgba(37, 99, 235, .13);
        }

        #profilKurir .profile-name {
            color: #172554;
            font-size: 21px;
            font-weight: 700;
            margin-top: 15px;
            margin-bottom: 8px;
        }

        #profilKurir .profile-role {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: #eff6ff;
            color: #2563eb;
            border-radius: 30px;
            padding: 7px 16px;
            font-size: 12px;
            font-weight: 700;
        }

        #profilKurir .profile-detail {
            display: flex;
            flex-direction: column;
            gap: 11px;
        }

        #profilKurir .profile-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 13px 15px;
            background: #f8fafc;
            border-radius: 13px;
        }

        #profilKurir .profile-icon {
            width: 43px;
            height: 43px;
            flex-shrink: 0;
            border-radius: 12px;
            background: #eaf2ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 19px;
        }

        #profilKurir .profile-item > div:last-child {
            min-width: 0;
            flex: 1;
        }

        #profilKurir .profile-item small {
            display: block;
            color: #94a3b8;
            font-size: 12px;
            margin-bottom: 4px;
        }

        #profilKurir .profile-item p {
            color: #1e293b;
            font-weight: 600;
            font-size: 14px;
            margin: 0;
            overflow-wrap: anywhere;
        }

        #profilKurir .modal-footer {
            padding: 0 24px 24px;
            border: none;
        }

        #profilKurir .profile-close {
            padding: 12px;
            font-weight: 600;
            color: white;
            background: #2563eb;
            border: none;
            border-radius: 11px;
            transition: .2s;
        }

        #profilKurir .profile-close:hover {
            background: #1d4ed8;
        }

        /* ================= RESPONSIVE ================= */

        @media (max-width: 768px) {

            .sidebar {
                width: 70px;
                padding: 20px 10px;
            }

            .brand {
                font-size: 0;
                padding-left: 10px;
            }

            .brand i {
                font-size: 25px;
            }

            .sidebar small,
            .sidebar a span {
                display: none;
            }

            .sidebar a {
                justify-content: center;
                padding: 13px 5px;
            }

            .sidebar a i {
                font-size: 21px;
            }

            .main-content {
                margin-left: 70px;
            }

            .content {
                padding: 18px 12px;
            }

            .topbar {
                padding: 12px 15px;
            }

            .topbar h5 {
                font-size: 17px;
            }

            .user-info {
                gap: 7px;
                padding: 5px;
            }

            .user-avatar {
                width: 38px;
                height: 38px;
                font-size: 20px;
            }

            .user-info .user-name {
                font-size: 13px;
            }

            #profilKurir .modal-dialog {
                margin: 12px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    {{-- SIDEBAR --}}
    <aside class="sidebar">

        <div class="brand">
            <i class="bi bi-droplet-fill"></i>
            LaundryKu
        </div>

        <small>MENU KURIR</small>

        <a href="{{ route('courier.dashboard') }}"
           class="{{ request()->routeIs('courier.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('courier.pengantaran.index') }}"
           class="{{ request()->routeIs('courier.pengantaran.*') ? 'active' : '' }}">
            <i class="bi bi-truck"></i>
            <span>Pengantaran</span>
        </a>

        <div class="mt-5">
            <small>AKUN</small>

            <a href="#"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>

    </aside>

    {{-- KONTEN UTAMA --}}
    <main class="main-content">

        {{-- TOPBAR HANYA DI DASHBOARD --}}
        @if(!request()->routeIs('courier.pengantaran.index'))

            <header class="topbar">

                <h5 class="fw-bold mb-0">
                    @yield('page-title', 'Dashboard Kurir')
                </h5>

                {{-- TOMBOL PROFIL --}}
                <button type="button"
                        class="user-info"
                        data-bs-toggle="modal"
                        data-bs-target="#profilKurir">

                    <div class="user-avatar">
                        <i class="bi bi-person-fill"></i>
                    </div>

                    <span class="user-name">
                        {{ auth()->user()->name }}
                    </span>

                    <i class="bi bi-chevron-down"></i>

                </button>

            </header>

            {{-- POPUP PROFIL KURIR --}}
            <div class="modal fade" id="profilKurir" tabindex="-1" aria-labelledby="judulProfilKurir" aria-hidden="true">

                <div class="modal-dialog modal-dialog-centered">

                    <div class="modal-content">

                        <div class="modal-header">

                            <h5 class="mb-0" id="judulProfilKurir">
                                <i class="bi bi-person-badge me-2"></i>
                                Profil Saya
                            </h5>

                            <button type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal"
                                    aria-label="Tutup">
                            </button>

                        </div>

                        <div class="modal-body p-4">

                            {{-- IDENTITAS KURIR --}}
                            <div class="profile-top">

                                <div class="profile-avatar">
                                    <i class="bi bi-person-fill"></i>
                                </div>

                                <h5 class="profile-name">
                                    {{ auth()->user()->name }}
                                </h5>

                                <span class="profile-role">
                                    <i class="bi bi-truck"></i>
                                    Kurir LaundryKu
                                </span>

                            </div>

                            {{-- INFORMASI DATA DIRI --}}
                            <div class="profile-detail">

                                <div class="profile-item">

                                    <div class="profile-icon">
                                        <i class="bi bi-person"></i>
                                    </div>

                                    <div>
                                        <small>Nama Lengkap</small>
                                        <p>{{ auth()->user()->name }}</p>
                                    </div>

                                </div>

                                <div class="profile-item">

                                    <div class="profile-icon">
                                        <i class="bi bi-envelope"></i>
                                    </div>

                                    <div>
                                        <small>Email</small>
                                        <p>{{ auth()->user()->email }}</p>
                                    </div>

                                </div>

                                <div class="profile-item">

                                    <div class="profile-icon">
                                        <i class="bi bi-telephone"></i>
                                    </div>

                                    <div>
                                        <small>Nomor Telepon</small>
                                        <p>{{ auth()->user()->phone ?: 'Belum diisi' }}</p>
                                    </div>

                                </div>

                                <div class="profile-item">

                                    <div class="profile-icon">
                                        <i class="bi bi-geo-alt"></i>
                                    </div>

                                    <div>
                                        <small>Alamat</small>
                                        <p>{{ auth()->user()->address ?: 'Belum diisi' }}</p>
                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="modal-footer">

                            <button type="button"
                                    class="btn profile-close w-100"
                                    data-bs-dismiss="modal">
                                Tutup
                            </button>

                        </div>

                    </div>

                </div>

            </div>

        @endif

        {{-- ISI HALAMAN --}}
        <section class="content">
            @yield('content')
        </section>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

</body>
</html>
