
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - LaundryKu</title>

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

        .login-wrapper {
            width: 100%;
            max-width: 1080px;
            min-height: 650px;
            background: #fff;
            display: grid;
            grid-template-columns: 1fr 1fr;
            border-radius: 26px;
            overflow: hidden;
            box-shadow: 0 25px 70px rgba(30, 64, 175, .12);
            animation: appear .7s ease;
        }

        /* BAGIAN KIRI */

        .brand-panel {
            position: relative;
            overflow: hidden;
            padding: 55px 50px;
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
            right: -150px;
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
            margin-top: 105px;
        }

        .brand-heading .eyebrow {
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
            font-size: 39px;
            line-height: 1.25;
            font-weight: 800;
            letter-spacing: -1.3px;
            max-width: 420px;
        }

        .brand-heading p {
            margin-top: 20px;
            font-size: 15px;
            line-height: 1.9;
            color: rgba(255,255,255,.82);
            max-width: 390px;
        }

        .brand-illustration {
            margin-top: 42px;
            width: 100%;
            max-width: 390px;
            min-height: 145px;
            border-radius: 22px;
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.18);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 22px;
            backdrop-filter: blur(10px);
        }

        .illustration-item {
            text-align: center;
            color: white;
        }

        .illustration-item i {
            display: block;
            font-size: 37px;
            margin-bottom: 10px;
        }

        .illustration-item span {
            font-size: 12px;
            font-weight: 600;
            color: rgba(255,255,255,.85);
        }

        .illustration-arrow {
            font-size: 20px;
            color: rgba(255,255,255,.6);
        }

        .brand-footer {
            margin-top: 45px;
            font-size: 12px;
            color: rgba(255,255,255,.7);
        }

        /* BAGIAN KANAN */

        .form-panel {
            padding: 65px 65px 45px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-heading {
            margin-bottom: 35px;
        }

        .form-heading .welcome {
            color: #2563eb;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 1.3px;
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        .form-heading h2 {
            font-size: 32px;
            font-weight: 800;
            letter-spacing: -1px;
            color: #172554;
        }

        .form-heading p {
            color: #8491a7;
            font-size: 14px;
            margin-top: 10px;
            line-height: 1.7;
        }

        .error-box {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            background: #fff1f2;
            color: #be123c;
            border: 1px solid #fecdd3;
            padding: 13px 15px;
            border-radius: 12px;
            font-size: 13px;
            margin-bottom: 22px;
        }

        .form-group {
            margin-bottom: 23px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: #334155;
            margin-bottom: 10px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper > i {
            position: absolute;
            left: 17px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 18px;
            transition: .2s;
        }

        .input-wrapper input {
            width: 100%;
            height: 54px;
            border: 1.5px solid #e2e8f0;
            background: #f8fafc;
            border-radius: 12px;
            outline: none;
            padding: 0 48px;
            font-family: inherit;
            font-size: 14px;
            color: #1e293b;
            transition: .25s;
        }

        .input-wrapper input::placeholder {
            color: #a0aec0;
        }

        .input-wrapper input:focus {
            border-color: #3b82f6;
            background: white;
            box-shadow: 0 0 0 4px rgba(59,130,246,.1);
        }

        .input-wrapper:focus-within > i {
            color: #2563eb;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: none;
            color: #94a3b8;
            cursor: pointer;
            font-size: 18px;
            padding: 5px;
        }

        .toggle-password:hover {
            color: #2563eb;
        }

        .login-button {
            width: 100%;
            height: 55px;
            margin-top: 8px;
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

        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(37,99,235,.3);
        }

        .login-button:active {
            transform: scale(.99);
        }

        .register-text {
            text-align: center;
            margin-top: 28px;
            font-size: 13px;
            color: #94a3b8;
        }

        .register-text a {
            color: #2563eb;
            font-weight: 800;
            text-decoration: none;
            margin-left: 4px;
        }

        .register-text a:hover {
            text-decoration: underline;
        }

        .secure-note {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 7px;
            margin-top: 45px;
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

        @media (max-width: 850px) {
            body {
                padding: 20px;
            }

            .login-wrapper {
                max-width: 520px;
                grid-template-columns: 1fr;
            }

            .brand-panel {
                padding: 35px;
                min-height: 350px;
            }

            .brand-heading {
                margin-top: 45px;
            }

            .brand-heading h1 {
                font-size: 29px;
            }

            .brand-heading p {
                font-size: 13px;
            }

            .brand-illustration {
                display: none;
            }

            .brand-footer {
                margin-top: 30px;
            }

            .form-panel {
                padding: 45px 35px;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 12px;
            }

            .login-wrapper {
                border-radius: 19px;
            }

            .brand-panel {
                padding: 28px 25px;
                min-height: 300px;
            }

            .brand-logo {
                font-size: 21px;
            }

            .brand-heading {
                margin-top: 40px;
            }

            .brand-heading h1 {
                font-size: 26px;
            }

            .form-panel {
                padding: 38px 25px;
            }

            .form-heading h2 {
                font-size: 27px;
            }
        }
    </style>
</head>

<body>

<div class="login-wrapper">

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
                    <i class="bi bi-stars me-1"></i>
                    LAUNDRY MANAGEMENT SYSTEM
                </span>

                <h1>
                    Pakaian Bersih,<br>
                    Hidup Lebih Nyaman.
                </h1>

                <p>
                    Kelola layanan laundry dengan lebih mudah,
                    praktis, dan terorganisir bersama LaundryKu.
                </p>

                <div class="brand-illustration">

                    <div class="illustration-item">
                        <i class="bi bi-basket2-fill"></i>
                        <span>Terima</span>
                    </div>

                    <i class="bi bi-arrow-right illustration-arrow"></i>

                    <div class="illustration-item">
                        <i class="bi bi-water"></i>
                        <span>Cuci</span>
                    </div>

                    <i class="bi bi-arrow-right illustration-arrow"></i>

                    <div class="illustration-item">
                        <i class="bi bi-truck"></i>
                        <span>Antar</span>
                    </div>

                </div>

            </div>

        </div>

        <div class="brand-footer">
            © {{ date('Y') }} LaundryKu. All rights reserved.
        </div>

    </section>


    <!-- BAGIAN FORM LOGIN -->
    <section class="form-panel">

        <div class="form-heading">
            <div class="welcome">Selamat Datang Kembali</div>

            <h2>Masuk ke Akun</h2>

            <p>
                Silakan masukkan email dan password
                untuk melanjutkan ke LaundryKu.
            </p>
        </div>


        @if ($errors->any())
            <div class="error-box">
                <i class="bi bi-exclamation-circle-fill"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif


        <form action="{{ url('/login') }}" method="POST">

            @csrf

            <div class="form-group">

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


            <div class="form-group">

                <label for="password">Password</label>

                <div class="input-wrapper">
                    <i class="bi bi-lock"></i>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Masukkan password"
                        autocomplete="current-password"
                        required
                    >

                    <button
                        type="button"
                        class="toggle-password"
                        id="togglePassword"
                        aria-label="Tampilkan password"
                    >
                        <i class="bi bi-eye"></i>
                    </button>

                </div>

            </div>


            <button type="submit" class="login-button">
                Masuk Sekarang
                <i class="bi bi-arrow-right ms-2"></i>
            </button>

        </form>


        <div class="register-text">
            Belum punya akun?
            <a href="{{ url('/register') }}">Daftar sekarang</a>
        </div>


        <div class="secure-note">
            <i class="bi bi-shield-check"></i>
            Login aman dan terlindungi
        </div>

    </section>

</div>


<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    togglePassword.addEventListener('click', function () {

        const isPassword = passwordInput.type === 'password';

        passwordInput.type = isPassword ? 'text' : 'password';

        this.innerHTML = isPassword
            ? '<i class="bi bi-eye-slash"></i>'
            : '<i class="bi bi-eye"></i>';

        this.setAttribute(
            'aria-label',
            isPassword ? 'Sembunyikan password' : 'Tampilkan password'
        );
    });
</script>

</body>
</html>
