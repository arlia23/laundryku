
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="LaundryKu - Solusi laundry praktis, bersih, dan terpercaya di Segala Mider, Lampung.">
    <title>LaundryKu - Laundry Praktis, Bersih, dan Wangi</title>

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --blue: #2563eb;
            --blue-dark: #123b91;
            --navy: #10234b;
            --sky: #eaf3ff;
            --text: #18243b;
            --muted: #718096;
            --white: #ffffff;
        }
        .btn-register,
.btn-register i {
    color: #fff !important;
}

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 90px;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            color: var(--text);
            background: #fff;
            overflow-x: hidden;
        }

        a {
            text-decoration: none;
        }

        button, a {
            -webkit-tap-highlight-color: transparent;
        }

        .container {
            width: min(1160px, 90%);
            margin: auto;
        }

        /* NAVBAR */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            background: rgba(255,255,255,.92);
            backdrop-filter: blur(18px);
            transition: .3s;
        }

        .navbar.scrolled {
            box-shadow: 0 8px 30px rgba(20,50,100,.08);
        }

        .nav-inner {
            min-height: 78px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--navy);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 23px;
            font-weight: 800;
        }

        .logo-icon {
            width: 43px;
            height: 43px;
            border-radius: 14px;
            background: linear-gradient(135deg, #2563eb, #38bdf8);
            color: white;
            display: grid;
            place-items: center;
            font-size: 23px;
            box-shadow: 0 7px 18px rgba(37,99,235,.25);
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .nav-links a {
            font-size: 13px;
            font-weight: 700;
            color: #58667d;
            transition: .25s;
        }

        .nav-links a:hover {
            color: var(--blue);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-login, .btn-register, .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            border-radius: 12px;
            padding: 12px 20px;
            font-weight: 700;
            font-size: 13px;
            transition: .25s;
        }

        .btn-login {
            color: var(--blue);
            background: #eff6ff;
        }

        .btn-register, .btn-primary {
            color: white;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            box-shadow: 0 8px 20px rgba(37,99,235,.2);
        }

        .btn-register:hover, .btn-primary:hover {
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(37,99,235,.3);
        }

        .menu-toggle {
            display: none;
            border: 0;
            background: transparent;
            color: var(--navy);
            font-size: 27px;
            cursor: pointer;
        }

        /* HERO */
        .hero {
            position: relative;
            min-height: 720px;
            padding: 150px 0 90px;
            overflow: hidden;
            background:
                radial-gradient(circle at 85% 20%, #d9edff 0, transparent 28%),
                radial-gradient(circle at 10% 80%, #e9f3ff 0, transparent 30%),
                linear-gradient(135deg, #f8fbff, #eef6ff);
        }

        .hero::before {
            content: "";
            position: absolute;
            width: 500px;
            height: 500px;
            border: 1px solid rgba(37,99,235,.1);
            border-radius: 50%;
            right: -150px;
            top: 100px;
            animation: rotate 30s linear infinite;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.05fr .95fr;
            align-items: center;
            gap: 55px;
            position: relative;
            z-index: 2;
        }

        .hero-tag {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 9px 15px;
            border-radius: 50px;
            background: white;
            color: var(--blue);
            font-size: 12px;
            font-weight: 800;
            box-shadow: 0 5px 20px rgba(30,70,130,.07);
            margin-bottom: 25px;
        }

        .hero-tag span {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #22c55e;
            animation: pulse 1.5s infinite;
        }

        .hero h1 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: clamp(39px, 5vw, 61px);
            line-height: 1.14;
            letter-spacing: -2.5px;
            font-weight: 800;
            color: var(--navy);
            margin-bottom: 22px;
        }

        .hero h1 span {
            color: var(--blue);
            position: relative;
        }

        .hero-description {
            color: var(--muted);
            line-height: 1.9;
            font-size: 15px;
            max-width: 510px;
            margin-bottom: 30px;
        }

        .hero-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 13px;
        }

        .btn-outline {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 12px 20px;
            border: 1px solid #d9e4f4;
            border-radius: 12px;
            color: var(--navy);
            font-size: 13px;
            font-weight: 700;
            background: white;
            transition: .25s;
        }

        .btn-outline:hover {
            border-color: var(--blue);
            color: var(--blue);
            transform: translateY(-3px);
        }

        .hero-note {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 35px;
            color: var(--muted);
            font-size: 12px;
        }

        .hero-note i {
            color: #16a34a;
            font-size: 20px;
        }

        .hero-visual {
            position: relative;
            min-height: 450px;
            display: grid;
            place-items: center;
        }

        .visual-circle {
            width: 390px;
            height: 390px;
            border-radius: 50%;
            background: linear-gradient(145deg, #cce7ff, #e9f5ff);
            display: grid;
            place-items: center;
            position: relative;
            animation: float 5s ease-in-out infinite;
        }

        .visual-circle::before {
            content: "";
            position: absolute;
            inset: 22px;
            border: 1px dashed rgba(37,99,235,.28);
            border-radius: 50%;
        }

        .washing-machine {
            width: 205px;
            height: 275px;
            border-radius: 27px;
            background: linear-gradient(145deg, #ffffff, #e8f0fa);
            box-shadow: 20px 25px 45px rgba(37,78,135,.2), inset 0 2px 5px white;
            padding: 19px;
            position: relative;
            z-index: 2;
        }

        .machine-top {
            height: 37px;
            border-radius: 10px;
            background: #edf4ff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 11px;
            margin-bottom: 17px;
        }

        .machine-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #2563eb;
        }

        .machine-screen {
            width: 30px;
            height: 8px;
            background: #bfdbfe;
            border-radius: 10px;
        }

        .machine-door {
            width: 140px;
            height: 140px;
            border: 11px solid #d5e4f6;
            border-radius: 50%;
            margin: auto;
            background: linear-gradient(145deg, #8bd2ff, #2563eb);
            box-shadow: inset 0 0 0 5px rgba(255,255,255,.5);
            overflow: hidden;
            display: grid;
            place-items: center;
        }

        .machine-door i {
            font-size: 68px;
            color: rgba(255,255,255,.9);
            animation: spin 9s linear infinite;
        }

        .machine-bottom {
            width: 85px;
            height: 5px;
            background: #cbdcf0;
            border-radius: 10px;
            margin: 17px auto 0;
        }

        .floating-card {
            position: absolute;
            z-index: 3;
            background: white;
            border-radius: 17px;
            padding: 14px 17px;
            box-shadow: 0 14px 35px rgba(30,60,110,.13);
            display: flex;
            align-items: center;
            gap: 11px;
            animation: float 4s ease-in-out infinite;
        }

        .floating-card.one {
            top: 55px;
            left: -5px;
        }

        .floating-card.two {
            bottom: 50px;
            right: -10px;
            animation-delay: 1s;
        }

        .float-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: #eff6ff;
            color: var(--blue);
            display: grid;
            place-items: center;
            font-size: 21px;
        }

        .floating-card strong {
            display: block;
            color: var(--navy);
            font-size: 12px;
        }

        .floating-card small {
            color: var(--muted);
            font-size: 10px;
        }

        .bubble {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,.65);
            border: 1px solid rgba(255,255,255,.9);
            animation: bubble 7s ease-in-out infinite;
        }

        .bubble.b1 { width: 28px; height: 28px; top: 15%; right: 10%; }
        .bubble.b2 { width: 17px; height: 17px; bottom: 15%; left: 10%; animation-delay: 2s; }
        .bubble.b3 { width: 12px; height: 12px; top: 50%; left: 2%; animation-delay: 4s; }

        /* SECTION GLOBAL */
        section {
            padding: 95px 0;
        }

        .section-heading {
            text-align: center;
            max-width: 650px;
            margin: 0 auto 48px;
        }

        .section-label {
            color: var(--blue);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 13px;
        }

        .section-heading h2 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--navy);
            font-size: clamp(28px, 4vw, 39px);
            font-weight: 800;
            letter-spacing: -1px;
            margin-bottom: 14px;
        }

        .section-heading p {
            color: var(--muted);
            font-size: 14px;
            line-height: 1.8;
        }

        /* SERVICES */
        .services {
            background: white;
        }

        .service-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 22px;
        }

        .service-card {
            padding: 32px 27px;
            border: 1px solid #edf1f7;
            border-radius: 22px;
            background: white;
            transition: .35s;
            position: relative;
            overflow: hidden;
        }

        .service-card:hover {
            transform: translateY(-9px);
            border-color: #c9ddff;
            box-shadow: 0 20px 45px rgba(30,70,130,.09);
        }

        .service-icon {
            width: 61px;
            height: 61px;
            border-radius: 18px;
            background: #eff6ff;
            color: var(--blue);
            display: grid;
            place-items: center;
            font-size: 29px;
            margin-bottom: 24px;
        }

        .service-card h3 {
            font-size: 18px;
            color: var(--navy);
            margin-bottom: 12px;
        }

        .service-card p {
            color: var(--muted);
            line-height: 1.8;
            font-size: 13px;
        }

        .service-number {
            position: absolute;
            top: 20px;
            right: 22px;
            color: #edf3fc;
            font-size: 40px;
            font-weight: 800;
        }

        /* HOW IT WORKS */
        .how {
            background: #f6f9ff;
        }

        .steps {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .step {
            text-align: center;
            position: relative;
            padding: 20px 12px;
        }

        .step-icon {
            width: 76px;
            height: 76px;
            border-radius: 24px;
            margin: 0 auto 22px;
            display: grid;
            place-items: center;
            background: white;
            color: var(--blue);
            font-size: 30px;
            box-shadow: 0 10px 25px rgba(30,70,130,.08);
        }

        .step h3 {
            font-size: 15px;
            color: var(--navy);
            margin-bottom: 10px;
        }

        .step p {
            color: var(--muted);
            font-size: 12px;
            line-height: 1.8;
        }

        /* PRICING */
        .pricing {
            background: white;
        }

        .price-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 22px;
        }

        .price-card {
            border: 1px solid #e8eef8;
            border-radius: 22px;
            padding: 31px;
            transition: .3s;
            position: relative;
            background: white;
        }

        .price-card:hover {
            transform: translateY(-7px);
            box-shadow: 0 18px 40px rgba(30,70,130,.1);
        }

        .price-card.featured {
            border: 2px solid var(--blue);
            background: linear-gradient(160deg, #f3f8ff, white);
        }

        .popular {
            position: absolute;
            top: -13px;
            right: 22px;
            background: var(--blue);
            color: white;
            padding: 7px 13px;
            border-radius: 30px;
            font-size: 10px;
            font-weight: 800;
        }

        .price-icon {
            width: 51px;
            height: 51px;
            border-radius: 15px;
            background: #eff6ff;
            color: var(--blue);
            display: grid;
            place-items: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .price-card h3 {
            color: var(--navy);
            font-size: 18px;
            margin-bottom: 9px;
        }

        .price-card p {
            color: var(--muted);
            font-size: 12px;
            line-height: 1.7;
            min-height: 42px;
        }

        .price {
            color: var(--blue);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 29px;
            font-weight: 800;
            margin: 20px 0;
        }

        .price small {
            color: var(--muted);
            font-size: 12px;
            font-weight: 500;
        }

        .price-features {
            border-top: 1px solid #edf1f7;
            padding-top: 19px;
            margin-bottom: 22px;
        }

        .price-features div {
            display: flex;
            gap: 9px;
            color: #59677e;
            font-size: 12px;
            margin-bottom: 12px;
        }

        .price-features i {
            color: #16a34a;
        }

        .price-card .btn-primary {
            width: 100%;
        }

        /* CTA */
        .cta {
            padding: 65px 0;
            background: #f5f9ff;
        }

        .cta-box {
            padding: 55px;
            border-radius: 28px;
            background: linear-gradient(120deg, #153e91, #2563eb, #38a7e8);
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 25px;
            overflow: hidden;
            position: relative;
        }

        .cta-box::after {
            content: "";
            position: absolute;
            width: 280px;
            height: 280px;
            border: 1px solid rgba(255,255,255,.18);
            border-radius: 50%;
            right: 100px;
            top: -160px;
        }

        .cta-box h2 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 29px;
            font-weight: 800;
            margin-bottom: 12px;
            position: relative;
            z-index: 1;
        }

        .cta-box p {
            color: #dbeafe;
            font-size: 13px;
            line-height: 1.8;
            position: relative;
            z-index: 1;
        }

        .cta-box .btn-white {
            flex-shrink: 0;
            background: white;
            color: var(--blue);
            padding: 15px 22px;
            border-radius: 12px;
            font-weight: 800;
            font-size: 13px;
            position: relative;
            z-index: 2;
            transition: .25s;
        }

        .btn-white:hover {
            transform: translateY(-4px);
        }

        /* LOCATION */
        .location {
            background: white;
        }

        .location-grid {
            display: grid;
            grid-template-columns: .8fr 1.2fr;
            gap: 35px;
            align-items: stretch;
        }

        .location-info {
            padding: 15px 0;
        }

        .location-info h3 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 25px;
            color: var(--navy);
            margin-bottom: 15px;
        }

        .location-info > p {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.8;
            margin-bottom: 25px;
        }

        .contact-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            margin-bottom: 22px;
        }

        .contact-icon {
            flex-shrink: 0;
            width: 45px;
            height: 45px;
            display: grid;
            place-items: center;
            border-radius: 13px;
            color: var(--blue);
            background: #eff6ff;
            font-size: 20px;
        }

        .contact-item strong {
            display: block;
            color: var(--navy);
            font-size: 13px;
            margin-bottom: 5px;
        }

        .contact-item span, .contact-item a {
            color: var(--muted);
            font-size: 12px;
            line-height: 1.7;
        }

        .map-box {
            min-height: 390px;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(20,50,100,.1);
            background: #edf4ff;
        }

        .map-box iframe {
            width: 100%;
            height: 100%;
            min-height: 390px;
            border: 0;
        }

        /* FOOTER */
        footer {
            background: #10234b;
            color: white;
            padding: 65px 0 25px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.4fr 1fr 1fr;
            gap: 55px;
            padding-bottom: 45px;
        }

        .footer-brand .logo {
            color: white;
            margin-bottom: 18px;
        }

        .footer-brand p {
            color: #aabbd9;
            font-size: 12px;
            line-height: 1.9;
            max-width: 330px;
        }

        footer h4 {
            font-size: 14px;
            margin-bottom: 20px;
        }

        .footer-links {
            display: flex;
            flex-direction: column;
            gap: 13px;
        }

        .footer-links a {
            color: #aabbd9;
            font-size: 12px;
            transition: .2s;
        }

        .footer-links a:hover {
            color: white;
            transform: translateX(4px);
        }

        .socials {
            display: flex;
            gap: 10px;
            margin-top: 19px;
        }

        .socials a {
            width: 39px;
            height: 39px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            background: rgba(255,255,255,.1);
            color: white;
            font-size: 17px;
            transition: .25s;
        }

        .socials a:hover {
            background: var(--blue);
            transform: translateY(-4px);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,.12);
            padding-top: 23px;
            text-align: center;
            color: #8fa4c8;
            font-size: 11px;
        }

        /* ANIMATION */
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-13px); }
        }

        @keyframes pulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(34,197,94,.4); }
            50% { box-shadow: 0 0 0 7px rgba(34,197,94,0); }
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        @keyframes rotate {
            to { transform: rotate(360deg); }
        }

        @keyframes bubble {
            0%, 100% { transform: translateY(0) scale(1); opacity: .6; }
            50% { transform: translateY(-35px) scale(1.15); opacity: 1; }
        }

        .reveal {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity .7s ease, transform .7s ease;
        }

        .reveal.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* RESPONSIVE */
        @media(max-width: 950px) {
            .nav-links {
                gap: 16px;
            }

            .nav-links a {
                font-size: 11px;
            }

            .hero-grid {
                gap: 20px;
            }

            .visual-circle {
                width: 320px;
                height: 320px;
            }

            .washing-machine {
                transform: scale(.85);
            }

            .steps {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media(max-width: 768px) {
            .nav-inner {
                min-height: 70px;
            }

            .menu-toggle {
                display: block;
            }

            .nav-links {
                position: absolute;
                top: 70px;
                left: 5%;
                width: 90%;
                background: white;
                border-radius: 17px;
                padding: 20px;
                display: none;
                flex-direction: column;
                align-items: stretch;
                gap: 0;
                box-shadow: 0 15px 35px rgba(20,50,100,.13);
            }

            .nav-links.open {
                display: flex;
            }

            .nav-links a {
                padding: 13px 5px;
                font-size: 13px;
            }

            .nav-actions {
                margin-top: 10px;
                flex-wrap: wrap;
            }

            .hero {
                padding: 120px 0 65px;
            }

            .hero-grid {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .hero-description {
                margin-left: auto;
                margin-right: auto;
            }

            .hero-buttons, .hero-note {
                justify-content: center;
            }

            .hero-visual {
                min-height: 370px;
            }

            .visual-circle {
                width: 300px;
                height: 300px;
            }

            .floating-card.one {
                left: 0;
            }

            .floating-card.two {
                right: 0;
            }

            section {
                padding: 70px 0;
            }

            .service-grid, .price-grid {
                grid-template-columns: 1fr;
            }

            .location-grid {
                grid-template-columns: 1fr;
            }

            .cta-box {
                padding: 35px 25px;
                flex-direction: column;
                align-items: flex-start;
            }

            .footer-grid {
                grid-template-columns: 1fr 1fr;
                gap: 35px;
            }

            .footer-brand {
                grid-column: 1 / -1;
            }
        }

        @media(max-width: 480px) {
            .logo {
                font-size: 20px;
            }

            .hero h1 {
                font-size: 39px;
            }

            .hero-visual {
                min-height: 320px;
            }

            .visual-circle {
                width: 260px;
                height: 260px;
            }

            .washing-machine {
                transform: scale(.72);
            }

            .floating-card {
                padding: 10px;
            }

            .floating-card.one {
                top: 15px;
            }

            .floating-card.two {
                bottom: 15px;
            }

            .floating-card strong {
                font-size: 10px;
            }

            .steps {
                grid-template-columns: 1fr 1fr;
            }

            .footer-grid {
                grid-template-columns: 1fr;
            }

            .footer-brand {
                grid-column: auto;
            }
        }

        @media(prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: .01ms !important;
                transition-duration: .01ms !important;
                scroll-behavior: auto !important;
            }
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar" id="navbar">
        <div class="container nav-inner">

            <a href="#beranda" class="logo">
                <div class="logo-icon">
                    <i class="bi bi-droplet-fill"></i>
                </div>
                LaundryKu
            </a>

            <button class="menu-toggle" id="menuToggle" aria-label="Buka menu">
                <i class="bi bi-list"></i>
            </button>

            <div class="nav-links" id="navLinks">
                <a href="#beranda">Beranda</a>
                <a href="#layanan">Layanan</a>
                <a href="#cara-kerja">Cara Kerja</a>
                <a href="#harga">Paket Harga</a>
                <a href="#lokasi">Lokasi</a>
                <a href="#kontak">Kontak</a>

                <div class="nav-actions">
                    <a href="{{ url('/login') }}" class="btn-login">Login</a>
                    <a href="{{ url('/register') }}" class="btn-register">Daftar <i class="bi bi-arrow-right" ></i></a>
                </div>
            </div>

        </div>
    </nav>

    <!-- HERO -->
    <section class="hero" id="beranda">

        <div class="bubble b1"></div>
        <div class="bubble b2"></div>
        <div class="bubble b3"></div>

        <div class="container hero-grid">

            <div class="hero-content reveal">

                <div class="hero-tag">
                    <span></span>
                    LAUNDRY PRAKTIS UNTUK KESEHARIANMU
                </div>

                <h1>
                    Pakaian Bersih,<br>
                    Wangi, dan <span>Siap Dipakai!</span>
                </h1>

                <p class="hero-description">
                    Tidak perlu repot mencuci sendiri. Serahkan urusan pakaianmu
                    kepada LaundryKu. Nikmati layanan laundry yang praktis,
                    mudah dipesan, dan nyaman untuk aktivitas sehari-hari.
                </p>

                <div class="hero-buttons">
                    <a href="{{ url('/register') }}" class="btn-primary">
                        Pesan Sekarang
                        <i class="bi bi-arrow-up-right"></i>
                    </a>

                    <a href="#layanan" class="btn-outline">
                        <i class="bi bi-play-circle"></i>
                        Jelajahi Layanan
                    </a>
                </div>

                <div class="hero-note">
                    <i class="bi bi-patch-check-fill"></i>
                    <span>Lebih praktis, hemat waktu, dan mudah dipantau.</span>
                </div>

            </div>

            <div class="hero-visual">

                <div class="visual-circle">

                    <div class="washing-machine">
                        <div class="machine-top">
                            <div class="machine-dot"></div>
                            <div class="machine-screen"></div>
                            <div class="machine-dot"></div>
                        </div>

                        <div class="machine-door">
                            <i class="bi bi-arrow-repeat"></i>
                        </div>

                        <div class="machine-bottom"></div>
                    </div>

                </div>

                <div class="floating-card one">
                    <div class="float-icon">
                        <i class="bi bi-stars"></i>
                    </div>
                    <div>
                        <strong>Bersih & Wangi</strong>
                        <small>Rawat pakaianmu</small>
                    </div>
                </div>

                <div class="floating-card two">
                    <div class="float-icon">
                        <i class="bi bi-truck"></i>
                    </div>
                    <div>
                        <strong>Layanan Antar</strong>
                        <small>Lebih praktis</small>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- LAYANAN -->
    <section class="services" id="layanan">

        <div class="container">

            <div class="section-heading reveal">
                <div class="section-label">Layanan Kami</div>
                <h2>Solusi Laundry untuk Kebutuhanmu</h2>
                <p>
                    Pilih layanan yang sesuai dengan kebutuhan pakaianmu.
                    Kami hadir untuk membuat urusan laundry menjadi lebih mudah.
                </p>
            </div>

            <div class="service-grid">

                <div class="service-card reveal">
                    <span class="service-number">01</span>
                    <div class="service-icon">
                        <i class="bi bi-water"></i>
                    </div>
                    <h3>Cuci Kering</h3>
                    <p>
                        Layanan pencucian dan pengeringan pakaian
                        agar lebih bersih dan siap digunakan.
                    </p>
                </div>

                <div class="service-card reveal">
                    <span class="service-number">02</span>
                    <div class="service-icon">
                        <i class="bi bi-handbag"></i>
                    </div>
                    <h3>Cuci Setrika</h3>
                    <p>
                        Pakaian dicuci, dikeringkan, dan disetrika
                        agar rapi serta nyaman saat digunakan.
                    </p>
                </div>

                <div class="service-card reveal">
                    <span class="service-number">03</span>
                    <div class="service-icon">
                        <i class="bi bi-truck"></i>
                    </div>
                    <h3>Cuci Setrika Antar</h3>
                    <p>
                        Nikmati layanan cuci dan setrika sekaligus
                        kemudahan penjemputan serta pengantaran.
                    </p>
                </div>

            </div>

        </div>
    </section>

    <!-- CARA KERJA -->
    <section class="how" id="cara-kerja">

        <div class="container">

            <div class="section-heading reveal">
                <div class="section-label">Mudah dan Praktis</div>
                <h2>Bagaimana Cara Kerjanya?</h2>
                <p>
                    Hanya beberapa langkah sederhana untuk menikmati
                    layanan laundry dari LaundryKu.
                </p>
            </div>

            <div class="steps">

                <div class="step reveal">
                    <div class="step-icon">
                        <i class="bi bi-person-plus"></i>
                    </div>
                    <h3>1. Buat Akun</h3>
                    <p>Daftarkan akun pelanggan agar dapat menggunakan sistem LaundryKu.</p>
                </div>

                <div class="step reveal">
                    <div class="step-icon">
                        <i class="bi bi-bag-plus"></i>
                    </div>
                    <h3>2. Pilih Paket</h3>
                    <p>Pilih layanan laundry sesuai kebutuhan pakaianmu.</p>
                </div>

                <div class="step reveal">
                    <div class="step-icon">
                        <i class="bi bi-basket"></i>
                    </div>
                    <h3>3. Proses Laundry</h3>
                    <p>Admin akan memeriksa berat pakaian dan memproses pesanan.</p>
                </div>

                <div class="step reveal">
                    <div class="step-icon">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <h3>4. Pesanan Selesai</h3>
                    <p>Pantau status pesanan hingga pakaian selesai dan diterima.</p>
                </div>

            </div>

        </div>
    </section>

    <!-- PAKET HARGA -->
    <section class="pricing" id="harga">

        <div class="container">

            <div class="section-heading reveal">
                <div class="section-label">Paket Laundry</div>
                <h2>Pilih Paket Sesuai Kebutuhan</h2>
                <p>
                    Harga layanan dihitung berdasarkan berat pakaian
                    yang ditimbang oleh admin.
                </p>
            </div>

            <div class="price-grid">

                <div class="price-card reveal">
                    <div class="price-icon">
                        <i class="bi bi-water"></i>
                    </div>
                    <h3>Cuci Kering</h3>
                    <p>Pilihan praktis untuk mencuci dan mengeringkan pakaian.</p>
                    <div class="price">Rp5.000 <small>/ kg</small></div>

                    <div class="price-features">
                        <div><i class="bi bi-check-circle-fill"></i> Pencucian pakaian</div>
                        <div><i class="bi bi-check-circle-fill"></i> Pengeringan pakaian</div>
                        <div><i class="bi bi-check-circle-fill"></i> Perhitungan berdasarkan berat</div>
                    </div>

                    <a href="{{ url('/register') }}" class="btn-primary">Pilih Paket <i class="bi bi-arrow-right"></i></a>
                </div>

                <div class="price-card featured reveal">
                    <span class="popular">Pilihan Favorit</span>
                    <div class="price-icon">
                        <i class="bi bi-stars"></i>
                    </div>
                    <h3>Cuci Setrika</h3>
                    <p>Solusi pakaian bersih, kering, dan rapi untuk aktivitasmu.</p>
                    <div class="price">Rp8.000 <small>/ kg</small></div>

                    <div class="price-features">
                        <div><i class="bi bi-check-circle-fill"></i> Pencucian pakaian</div>
                        <div><i class="bi bi-check-circle-fill"></i> Pengeringan pakaian</div>
                        <div><i class="bi bi-check-circle-fill"></i> Penyetrikaan pakaian</div>
                    </div>

                    <a href="{{ url('/register') }}" class="btn-primary">Pilih Paket <i class="bi bi-arrow-right"></i></a>
                </div>

                <div class="price-card reveal">
                    <div class="price-icon">
                        <i class="bi bi-truck"></i>
                    </div>
                    <h3>Cuci Setrika Antar</h3>
                    <p>Lebih nyaman dengan layanan penjemputan dan pengantaran.</p>
                    <div class="price">Rp10.000 <small>/ kg</small></div>

                    <div class="price-features">
                        <div><i class="bi bi-check-circle-fill"></i> Pencucian dan pengeringan</div>
                        <div><i class="bi bi-check-circle-fill"></i> Penyetrikaan pakaian</div>
                        <div><i class="bi bi-check-circle-fill"></i> Layanan antar-jemput</div>
                    </div>

                    <a href="{{ url('/register') }}" class="btn-primary">Pilih Paket <i class="bi bi-arrow-right"></i></a>
                </div>

            </div>

        </div>
    </section>

    <!-- CTA -->
    <section class="cta">
        <div class="container">
            <div class="cta-box reveal">
                <div>
                    <h2>Sudah Siap Menikmati Laundry yang Praktis?</h2>
                    <p>
                        Buat akun LaundryKu sekarang dan mulai pesan layanan
                        laundry dengan lebih mudah.
                    </p>
                </div>

                <a href="{{ url('/register') }}" class="btn-white">
                    Mulai Sekarang <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- LOKASI DAN KONTAK -->
    <section class="location" id="lokasi">

        <div class="container">

            <div class="section-heading reveal">
                <div class="section-label">Temukan Kami</div>
                <h2>Lokasi LaundryKu</h2>
                <p>
                    Kunjungi lokasi LaundryKu atau hubungi kami
                    untuk mendapatkan informasi lebih lanjut.
                </p>
            </div>

            <div class="location-grid">

                <div class="location-info reveal">

                    <h3>Kami Siap Membantu!</h3>

                    <p>
                        LaundryKu hadir untuk membantu kebutuhan laundry
                        harianmu. Silakan hubungi kami melalui informasi berikut.
                    </p>

                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>
                        <div>
                            <strong>Alamat</strong>
                            <span>Jl. Palapa 5A 3, 35142, Segala Mider, Lampung.</span>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="bi bi-telephone-fill"></i>
                        </div>
                        <div>
                            <strong>Nomor WhatsApp</strong>
                            <a href="https://wa.me/6281272131789" target="_blank">
                                0812-7213-1789
                            </a>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="bi bi-clock-fill"></i>
                        </div>
                        <div>
                            <strong>Informasi Layanan</strong>
                            <span>Hubungi kami untuk informasi pelayanan laundry.</span>
                        </div>
                    </div>

                    <a href="https://www.google.com/maps/search/?api=1&query=-5.382102%2C105.250015"
                       target="_blank" class="btn-primary">
                        <i class="bi bi-map"></i>
                        Buka Google Maps
                    </a>

                </div>

                <div class="map-box reveal">
                    <iframe
                        src="https://maps.google.com/maps?q=-5.382102,105.250015&z=16&output=embed"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        allowfullscreen>
                    </iframe>
                </div>

            </div>

        </div>
    </section>

    <!-- FOOTER -->
    <footer id="kontak">

        <div class="container">

            <div class="footer-grid">

                <div class="footer-brand">

                    <a href="#beranda" class="logo">
                        <div class="logo-icon">
                            <i class="bi bi-droplet-fill"></i>
                        </div>
                        LaundryKu
                    </a>

                    <p>
                        Solusi laundry praktis untuk membantu menjaga
                        pakaian tetap bersih, rapi, dan nyaman digunakan.
                        Terima kasih telah mempercayakan kebutuhan laundry
                        kepada LaundryKu.
                    </p>

                    <div class="socials">
                        <a href="https://www.instagram.com/skyrain195/" target="_blank" aria-label="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>

                        <a href="https://www.facebook.com/profile.php?id=61588693542613" target="_blank" aria-label="Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>

                        <a href="https://youtube.com/@skyrain-f5l" target="_blank" aria-label="YouTube">
                            <i class="bi bi-youtube"></i>
                        </a>

                        <a href="https://wa.me/6281272131789" target="_blank" aria-label="WhatsApp">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                    </div>

                </div>

                <div>
                    <h4>Navigasi</h4>
                    <div class="footer-links">
                        <a href="#beranda">Beranda</a>
                        <a href="#layanan">Layanan Kami</a>
                        <a href="#cara-kerja">Cara Kerja</a>
                        <a href="#harga">Paket Harga</a>
                        <a href="#lokasi">Lokasi</a>
                    </div>
                </div>

                <div>
                    <h4>Akun & Bantuan</h4>
                    <div class="footer-links">
                        <a href="{{ url('/login') }}">Login</a>
                        <a href="{{ url('/register') }}">Daftar Akun</a>
                        <a href="https://wa.me/6281272131789" target="_blank">Hubungi Kami</a>
                        <a href="https://www.google.com/maps/search/?api=1&query=-5.382102%2C105.250015" target="_blank">Petunjuk Lokasi</a>
                    </div>
                </div>

            </div>

            <div class="footer-bottom">
                © {{ date('Y') }} LaundryKu. All Rights Reserved.
                Made with <i class="bi bi-heart-fill text-danger"></i> for cleaner days.
            </div>

        </div>

    </footer>

    <script>
        // Navbar shadow ketika halaman digulir
        const navbar = document.getElementById('navbar');

        window.addEventListener('scroll', function () {
            navbar.classList.toggle('scrolled', window.scrollY > 20);
        });

        // Menu mobile
        const menuToggle = document.getElementById('menuToggle');
        const navLinks = document.getElementById('navLinks');

        menuToggle.addEventListener('click', function () {
            navLinks.classList.toggle('open');

            const icon = menuToggle.querySelector('i');
            icon.classList.toggle('bi-list');
            icon.classList.toggle('bi-x-lg');
        });

        document.querySelectorAll('#navLinks a').forEach(function (link) {
            link.addEventListener('click', function () {
                navLinks.classList.remove('open');
                menuToggle.querySelector('i').className = 'bi bi-list';
            });
        });

        // Animasi elemen ketika masuk layar
        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('show');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.12
        });

        document.querySelectorAll('.reveal').forEach(function (element) {
            observer.observe(element);
        });
    </script>

</body>
</html>
