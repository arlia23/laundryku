
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register - LaundryKu</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            background: #f4f7fc;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
            color: #172554;
        }

        .register-wrapper {
            width: 100%;
            max-width: 1100px;
            min-height: 700px;
            background: #fff;
            display: grid;
            grid-template-columns: .9fr 1.1fr;
            border-radius: 26px;
            overflow: hidden;
            box-shadow: 0 25px 70px rgba(30, 64, 175, .12);
            animation: appear .7s ease;
        }

        /* BAGIAN BRANDING */

        .brand-panel {
            position: relative;
            overflow: hidden;
            padding: 55px 45px;
            background: linear-gradient(145deg, #123b91, #1765db 65%, #2695ef);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .brand-panel::before {
            content: "";
            position: absolute;
            width: 370px;
            height: 370px;
            border: 1px solid rgba(255,255,255,.13);
            border-radius: 50%;
            right: -160px;
            top: -100px;
        }

        .brand-panel::after {
            content: "";
            position: absolute;
            width: 300px;
            height: 300px;
            border: 1px solid rgba(255,255,255,.13);
            border-radius: 50%;
            left: -150px;
            bottom: -100px;
        }

        .brand-content,
        .brand-footer {
            position: relative;
            z-index: 2;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 13px;
            font-size: 25px;
            font-weight: 800;
            letter-spacing: -.8px;
        }

        .brand-logo-icon {
            width: 48px;
            height: 48px;
            border-radius: 15px;
            background: rgba(255,255,255,.17);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;
            border: 1px solid rgba(255,255,255,.2);
        }

        .brand-heading {
            margin-top: 110px;
        }

        .eyebrow {
            display: inline-block;
            padding: 8px 14px;
            border-radius: 30px;
            background: rgba(255,255,255,.15);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 23px;
        }

        .brand-heading h1 {
            font-size: 38px;
            line-height: 1.25;
            font-weight: 800;
            letter-spacing: -1.3px;
        }

        .brand-heading p {
            margin-top: 20px;
            font-size: 15px;
            line-height: 1.9;
            color: rgba(255,255,255,.82);
        }

        .benefit-list {
            margin-top: 38px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .benefit-item {
            display: flex;
            align-items: center;
            gap: 14px;
            font-size: 14px;
            color: rgba(255,255,255,.92);
        }

        .benefit-icon {
            width: 40px;
            height: 40px;
            flex-shrink: 0;
            border-radius: 12px;
            background: rgba(255,255,255,.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 19px;
        }

        .brand-footer {
            margin-top: 45px;
            font-size: 12px;
            color: rgba(255,255,255,.7);
        }

        /* FORM REGISTER */

        .form-panel {
            padding: 48px 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-heading {
            margin-bottom: 28px;
        }

        .welcome {
            color: #2563eb;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 1.3px;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .form-heading h2 {
            font-size: 31px;
            font-weight: 800;
            letter-spacing: -1px;
            color: #172554;
        }

        .form-heading p {
            color: #8491a7;
            font-size: 14px;
            margin-top: 9px;
            line-height: 1.7;
        }

        .error-box {
            background: #fff1f2;
            color: #be123c;
            border: 1px solid #fecdd3;
            padding: 13px 15px;
            border-radius: 12px;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .error-box p + p {
            margin-top: 5px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 17px;
        }

        .form-group {
            margin-bottom: 17px;
            min-width: 0;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: #334155;
            margin-bottom: 9px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper > i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 17px;
            transition: .2s;
            pointer-events: none;
        }

        .input-wrapper input,
        .input-wrapper textarea {
            width: 100%;
            border: 1.5px solid #e2e8f0;
            background: #f8fafc;
            border-radius: 11px;
            outline: none;
            padding: 0 43px;
            font-family: inherit;
            font-size: 13px;
            color: #1e293b;
            transition: .25s;
        }

        .input-wrapper input {
            height: 49px;
        }

        .input-wrapper textarea {
            height: 85px;
            resize: vertical;
            padding-top: 13px;
            padding-bottom: 12px;
            padding-left: 43px;
        }

        .input-wrapper input::placeholder,
        .input-wrapper textarea::placeholder {
            color: #a0aec0;
        }

        .input-wrapper input:focus,
        .input-wrapper textarea:focus {
            border-color: #3b82f6;
            background: white;
            box-shadow: 0 0 0 4px rgba(59,130,246,.1);
        }

        .input-wrapper:focus-within > i {
            color: #2563eb;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: none;
            color: #94a3b8;
            cursor: pointer;
            font-size: 17px;
            padding: 5px;
        }

        .toggle-password:hover {
            color: #2563eb;
        }

        .register-button {
            width: 100%;
            height: 53px;
            margin-top: 5px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(110deg, #2563eb, #1677e9);
            color: white;
            font-family: inherit;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 8px 20px rgba(37,99,235,.22);
            transition: .25s;
        }

        .register-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(37,99,235,.3);
        }

        .register-button:active {
            transform: scale(.99);
        }

        .login-text {
            text-align: center;
            margin-top: 22px;
            font-size: 13px;
            color: #94a3b8;
        }

        .login-text a {
            color: #2563eb;
            font-weight: 800;
            text-decoration: none;
            margin-left: 4px;
        }

        .login-text a:hover {
            text-decoration: underline;
        }

        .secure-note {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 7px;
            margin-top: 28px;
            font-size: 11px;
            color: #a0aec0;
        }

        .secure-note i {
            color: #16a34a;
        }

        @keyframes appear {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* RESPONSIVE */

        @media (max-width: 900px) {
            body {
                padding: 20px;
            }

            .register-wrapper {
                max-width: 570px;
                grid-template-columns: 1fr;
            }

            .brand-panel {
                padding: 35px;
                min-height: 330px;
            }

            .brand-heading {
                margin-top: 45px;
            }

            .brand-heading h1 {
                font-size: 29px;
            }

            .benefit-list {
                display: none;
            }

            .brand-footer {
                margin-top: 30px;
            }

            .form-panel {
                padding: 40px 35px;
            }
        }

        @media (max-width: 520px) {
            body {
                padding: 12px;
            }

            .register-wrapper {
                border-radius: 19px;
            }

            .brand-panel {
                padding: 28px 25px;
                min-height: 285px;
            }

            .brand-logo {
                font-size: 21px;
            }

            .brand-heading {
                margin-top: 35px;
            }

            .brand-heading h1 {
                font-size: 26px;
            }

            .form-panel {
                padding: 35px 23px;
            }

            .form-heading h2 {
                font-size: 27px;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .form-group.full {
                grid-column: auto;
            }
        }
    </style>
</head>

<body>

<div class="register-wrapper">

    <!-- BAGIAN BRANDING -->
    <section class="brand-panel">

        <div class="brand-content">

            <div class="brand-logo">
                <div class="brand-logo-icon">
                    <i class="bi bi-droplet-fill"></i>
                </div>
                <span>LaundryKu</span>
            </div>

            <div class="brand-heading">

                <span class="eyebrow">
                    <i class="bi bi-stars"></i>
                    JOIN OUR COMMUNITY
                </span>

                <h1>
                    Mulai Lebih Mudah
                    Bersama LaundryKu.
                </h1>

                <p>
                    Buat akun sekarang dan nikmati kemudahan
                    memesan layanan laundry dalam satu tempat.
                </p>

                <div class="benefit-list">

                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="bi bi-lightning-charge"></i>
                        </div>
                        <span>Pemesanan laundry lebih praktis</span>
                    </div>

                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="bi bi-clipboard-check"></i>
                        </div>
                        <span>Pantau status pesanan dengan mudah</span>
                    </div>

                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="bi bi-truck"></i>
                        </div>
                        <span>Layanan penjemputan dan pengantaran</span>
                    </div>

                </div>

            </div>

        </div>

        <div class="brand-footer">
            © {{ date('Y') }} LaundryKu. All rights reserved.
        </div>

    </section>


    <!-- BAGIAN FORM REGISTER -->
    <section class="form-panel">

        <div class="form-heading">

            <div class="welcome">Buat Akun Baru</div>

            <h2>Daftar LaundryKu</h2>

            <p>
                Lengkapi data diri kamu untuk membuat akun pelanggan.
            </p>

        </div>


        @if ($errors->any())
            <div class="error-box">
                <strong>
                    <i class="bi bi-exclamation-circle-fill me-1"></i>
                    Periksa kembali data kamu:
                </strong>

                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif


        <form action="{{ url('/register') }}" method="POST">

            @csrf

            <div class="form-grid">

                <!-- NAMA -->
                <div class="form-group full">

                    <label for="name">Nama Lengkap</label>

                    <div class="input-wrapper">
                        <i class="bi bi-person"></i>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Masukkan nama lengkap"
                            autocomplete="name"
                            required
                        >
                    </div>

                </div>


                <!-- EMAIL -->
                <div class="form-group full">

                    <label for="email">Alamat Email</label>

                    <div class="input-wrapper">
                        <i class="bi bi-envelope"></i>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="contoh@email.com"
                            autocomplete="email"
                            required
                        >
                    </div>

                </div>


                <!-- PASSWORD -->
                <div class="form-group">

                    <label for="password">Password</label>

                    <div class="input-wrapper">
                        <i class="bi bi-lock"></i>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Buat password"
                            autocomplete="new-password"
                            required
                        >

                        <button
                            type="button"
                            class="toggle-password"
                            data-target="password"
                            aria-label="Tampilkan password"
                        >
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>

                </div>


                <!-- KONFIRMASI PASSWORD -->
                <div class="form-group">

                    <label for="password_confirmation">
                        Konfirmasi Password
                    </label>

                    <div class="input-wrapper">
                        <i class="bi bi-shield-lock"></i>

                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="Ulangi password"
                            autocomplete="new-password"
                            required
                        >

                        <button
                            type="button"
                            class="toggle-password"
                            data-target="password_confirmation"
                            aria-label="Tampilkan konfirmasi password"
                        >
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>

                </div>


                <!-- TELEPON -->
                <div class="form-group full">

                    <label for="phone">Nomor Telepon</label>

                    <div class="input-wrapper">
                        <i class="bi bi-telephone"></i>

                        <input
                            type="text"
                            id="phone"
                            name="phone"
                            value="{{ old('phone') }}"
                            placeholder="Contoh: 081234567890"
                            autocomplete="tel"
                        >
                    </div>

                </div>


                <!-- ALAMAT -->
                <div class="form-group full">

                    <label for="address">Alamat</label>

                    <div class="input-wrapper">
                        <i class="bi bi-geo-alt"></i>

                        <textarea
                            id="address"
                            name="address"
                            placeholder="Masukkan alamat lengkap kamu"
                            autocomplete="street-address"
                        >{{ old('address') }}</textarea>
                    </div>

                </div>

            </div>


            <button type="submit" class="register-button">
                Buat Akun Sekarang
                <i class="bi bi-arrow-right ms-2"></i>
            </button>

        </form>


        <div class="login-text">
            Sudah punya akun?
            <a href="{{ url('/login') }}">Login sekarang</a>
        </div>


        <div class="secure-note">
            <i class="bi bi-shield-check"></i>
            Data akun kamu diproses dengan aman
        </div>

    </section>

</div>


<script>
    // Fitur tampil dan sembunyikan password
    document.querySelectorAll('.toggle-password').forEach(function(button) {

        button.addEventListener('click', function() {

            const targetId = this.dataset.target;
            const input = document.getElementById(targetId);
            const icon = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
                this.setAttribute('aria-label', 'Sembunyikan password');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
                this.setAttribute('aria-label', 'Tampilkan password');
            }

        });

    });
</script>

</body>
</html>
