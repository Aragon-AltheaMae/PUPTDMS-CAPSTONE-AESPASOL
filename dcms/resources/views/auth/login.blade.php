<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PUPT-DMS | Login</title>
    <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --crimson: #8B0000;
            --crimson-mid: #6B0000;
            --crimson-dark: #3D0000;
            --gold: #C9A84C;
            --gold-bright: #FFD700;
            --ivory: #FEFCF8;
            --text-dark: #1A0A0A;
            --text-mid: #6B5B5B;
            --text-light: #A89898;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: var(--crimson-dark);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px 16px;
            position: relative;
            overflow-x: hidden;
        }

        /* ── STARS ── */
        #stars {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
        }

        /* ── AMBIENT GLOW ── */
        .glow-orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.18;
            pointer-events: none;
            z-index: 0;
        }

        .glow-orb-1 {
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, #C9A84C, transparent 70%);
            top: -100px;
            left: -100px;
            animation: orbFloat1 12s ease-in-out infinite alternate;
        }

        .glow-orb-2 {
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, #8B0000, transparent 70%);
            bottom: -80px;
            right: -80px;
            animation: orbFloat2 15s ease-in-out infinite alternate;
        }

        @keyframes orbFloat1 {
            from {
                transform: translate(0, 0);
            }

            to {
                transform: translate(60px, 40px);
            }
        }

        @keyframes orbFloat2 {
            from {
                transform: translate(0, 0);
            }

            to {
                transform: translate(-40px, -60px);
            }
        }

        /* ── CARD ── */
        .login-card {
            position: relative;
            z-index: 10;
            width: min(96vw, 980px);
            display: grid;
            grid-template-columns: 1fr 1.1fr;
            border-radius: 24px;
            overflow: hidden;
            box-shadow:
                0 0 0 1px rgba(201, 168, 76, .15),
                0 24px 80px rgba(0, 0, 0, .7),
                0 8px 24px rgba(0, 0, 0, .4);
            animation: cardUp .9s cubic-bezier(.22, 1, .36, 1) .1s both;
        }

        @keyframes cardUp {
            from {
                opacity: 0;
                transform: translateY(32px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ── LEFT: PHOTO ── */
        .photo-side {
            position: relative;
            overflow: hidden;
            min-height: 500px;
        }

        .photo-side img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            filter: brightness(.35) saturate(.5);
            transform: scale(1.02);
            transition: transform 12s ease;
        }

        .photo-side:hover img {
            transform: scale(1.08);
        }

        .photo-side::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg,
                    rgba(61, 0, 0, .8) 0%,
                    rgba(90, 0, 0, .4) 40%,
                    rgba(0, 0, 0, .15) 100%);
        }

        .photo-content {
            position: absolute;
            inset: 0;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 32px;
            text-align: center;
        }

        /* Shine text */
        .shine-text {
            background: linear-gradient(90deg,
                    var(--crimson-mid) 0%,
                    var(--gold-bright) 35%,
                    #fff 50%,
                    var(--gold-bright) 65%,
                    var(--crimson-mid) 100%);
            background-size: 250% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shine 16s linear infinite;
            display: block;
        }

        @keyframes shine {
            from {
                background-position: 250% center;
            }

            to {
                background-position: -250% center;
            }
        }

        .photo-title-main {
            font-size: clamp(24px, 3.2vw, 38px);
            font-weight: 900;
            letter-spacing: .05em;
            line-height: 1;
        }

        .photo-title-sub {
            font-size: clamp(9px, 1.1vw, 13px);
            font-weight: 700;
            letter-spacing: .16em;
            margin-top: 6px;
        }

        /* Divider */
        .photo-divider {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin: 18px 0;
        }

        .photo-divider-line {
            width: 40px;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(201, 168, 76, .45));
        }

        .photo-divider-line.r {
            background: linear-gradient(90deg, rgba(201, 168, 76, .45), transparent);
        }

        .photo-divider-dot {
            width: 5px;
            height: 5px;
            background: var(--gold);
            transform: rotate(45deg);
            opacity: .7;
        }

        /* Logos */
        .logo-row {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 20px;
        }

        .logo-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .08);
            border: 1.5px solid rgba(201, 168, 76, .25);
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(4px);
            transition: border-color .3s;
        }

        .logo-circle:hover {
            border-color: rgba(201, 168, 76, .55);
        }

        .logo-circle img {
            width: 42px;
            height: 42px;
            object-fit: contain;
            filter: none;
            transform: none;
        }

        .logo-v-divider {
            width: 1px;
            height: 32px;
            background: linear-gradient(to bottom, transparent, rgba(201, 168, 76, .4), transparent);
        }

        .photo-tagline {
            font-size: 12px;
            color: rgb(239, 239, 239);
            line-height: 1.8;
            max-width: 300px;
        }

        .photo-badge {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 3;
            display: flex;
            align-items: center;
            gap: 6px;
            background: rgba(201, 168, 76, .1);
            border: 1px solid rgba(201, 168, 76, .25);
            border-radius: 20px;
            padding: 5px 14px;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: .16em;
            text-transform: uppercase;
            color: rgba(255, 215, 0, .65);
            white-space: nowrap;
        }

        /* ── RIGHT: FORM ── */
        .form-side {
            background: var(--ivory);
            padding: 52px 48px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        .form-side::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 120px;
            height: 120px;
            background: radial-gradient(circle at top right, rgba(201, 168, 76, .08), transparent 70%);
            pointer-events: none;
        }

        .form-portal-label {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }

        .form-portal-pip {
            width: 28px;
            height: 3px;
            background: linear-gradient(90deg, var(--crimson), var(--gold));
            border-radius: 2px;
        }

        .form-portal-text {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .18em;
            text-transform: uppercase;
            color: var(--gold);
        }

        .form-heading {
            font-size: 30px;
            font-weight: 800;
            color: var(--text-dark);
            line-height: 1.15;
            margin-bottom: 4px;
        }

        .form-heading span {
            color: var(--crimson);
        }

        .form-sub {
            font-size: 13px;
            color: var(--text-light);
            margin-bottom: 28px;
            line-height: 1.5;
        }

        .field {
            margin-bottom: 18px;
        }

        .field-label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            font-weight: 600;
            color: var(--text-mid);
            margin-bottom: 7px;
            letter-spacing: .05em;
            text-transform: uppercase;
        }

        .field-label i {
            font-size: 10px;
            color: var(--crimson);
            opacity: .7;
        }

        .field-input {
            width: 100%;
            padding: 13px 16px;
            background: #fff;
            border: 1.5px solid #E8E0D8;
            border-radius: 12px;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            color: var(--text-dark);
            outline: none;
            transition: border-color .2s, box-shadow .2s, background .2s;
        }

        .field-input::placeholder {
            color: #CEC6BE;
            font-size: 13px;
        }

        .field-input:focus {
            border-color: var(--crimson);
            box-shadow: 0 0 0 4px rgba(139, 0, 0, .07);
            background: #FFFDF9;
        }

        .pw-wrap {
            position: relative;
        }

        .pw-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #CEC6BE;
            transition: color .2s;
            display: flex;
            align-items: center;
            padding: 4px;
        }

        .pw-toggle:hover {
            color: var(--crimson);
        }

        input:-webkit-autofill,
        input:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0 40px #fff inset !important;
            -webkit-text-fill-color: var(--text-dark) !important;
        }

        .btn-submit {
            width: 100%;
            margin-top: 8px;
            padding: 14px;
            background: linear-gradient(135deg, var(--crimson) 0%, #B22222 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: .04em;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            position: relative;
            overflow: hidden;
            transition: transform .18s, box-shadow .18s;
            box-shadow: 0 6px 20px rgba(139, 0, 0, .35);
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, .12) 0%, transparent 60%);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(139, 0, 0, .45);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-submit .btn-arrow {
            width: 28px;
            height: 28px;
            background: rgba(255, 255, 255, .15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform .2s, background .2s;
        }

        .btn-submit:hover .btn-arrow {
            transform: translateX(3px);
            background: rgba(255, 255, 255, .25);
        }

        .register-row {
            text-align: center;
            margin-top: 22px;
            padding-top: 18px;
            border-top: 1px solid #F0EAE2;
            font-size: 13px;
            color: var(--text-light);
        }

        .register-row a {
            color: var(--crimson);
            font-weight: 700;
            text-decoration: none;
            transition: opacity .2s;
        }

        .register-row a:hover {
            opacity: .75;
            text-decoration: underline;
        }

        /* ── TOAST ── */
        #toastContainer {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 99999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            pointer-events: none;
        }

        .toast {
            min-width: 300px;
            background: white;
            border-radius: 14px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, .18);
            padding: 14px 18px 14px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            opacity: 0;
            transform: translateX(340px);
            transition: all .35s cubic-bezier(.68, -.55, .265, 1.55);
            position: relative;
            overflow: hidden;
            pointer-events: all;
        }

        .toast::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
        }

        .toast.error::before {
            background: var(--crimson);
        }

        .toast.success::before {
            background: #15803d;
        }

        .toast.show {
            opacity: 1;
            transform: translateX(0);
        }

        .toast.hide {
            opacity: 0;
            transform: translateX(340px);
        }

        .toast-icon-wrap {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .toast.error .toast-icon-wrap {
            background: rgba(139, 0, 0, .08);
        }

        .toast.success .toast-icon-wrap {
            background: rgba(21, 128, 61, .08);
        }

        .toast-icon {
            font-size: 17px;
        }

        .toast.error .toast-icon {
            color: var(--crimson);
        }

        .toast.success .toast-icon {
            color: #15803d;
        }

        .toast-body {
            flex: 1;
            min-width: 0;
        }

        .toast-title {
            font-size: 13px;
            font-weight: 700;
            color: #1A0A0A;
        }

        .toast-msg {
            font-size: 12px;
            color: #888;
            margin-top: 2px;
            line-height: 1.4;
        }

        .toast-close {
            background: none;
            border: none;
            cursor: pointer;
            color: #CCC;
            font-size: 13px;
            flex-shrink: 0;
            padding: 2px 4px;
            transition: color .2s;
        }

        .toast-close:hover {
            color: #888;
        }

        /* ════════════════════════════
        LOGIN FOOTER
        ════════════════════════════ */

        .login-footer {
            width: 100%;
            margin-top: 30px;
            padding: 18px 16px 24px;
            display: flex;
            justify-content: center;
            z-index: 5;
        }

        .login-footer-inner {
            text-align: center;
            color: rgba(255,255,255,.75);
            font-size: 12px;
            letter-spacing: .04em;
        }

        /* Divider */
        .footer-divider {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 8px;
        }

        .footer-divider span {
            width: 40px;
            height: 1px;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(201,168,76,.6),
                transparent
            );
        }

        .footer-divider i {
            font-size: 11px;
            color: rgba(255,215,0,.65);
        }

        /* Text */
        .footer-text {
            font-weight: 500;
        }

        .footer-year {
            color: rgba(255,255,255,.45);
        }

        /* Links */
        .footer-links {
            margin-top: 6px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            font-size: 11px;
        }

        .footer-links a {
            color: rgba(255,215,0,.75);
            text-decoration: none;
            transition: opacity .2s;
        }

        .footer-links a:hover {
            opacity: .7;
        }

        .footer-links .dot {
            width: 4px;
            height: 4px;
            background: rgba(255,215,0,.45);
            border-radius: 50%;
        }

        @media (max-width: 640px) {
            #toastContainer {
                left: 12px;
                right: 12px;
                top: 12px;
            }

            .toast {
                min-width: unset;
                transform: translateY(-80px);
            }

            .toast.show {
                transform: translateY(0);
            }

            .toast.hide {
                transform: translateY(-80px);
            }
        }

        /* ════════════════════════════
           MOBILE RESPONSIVE
        ════════════════════════════ */
        @media (max-width: 767px) {
            body {
                padding: 16px;
                justify-content: flex-start;
                padding-top: 32px;
            }

            .login-card {
                grid-template-columns: 1fr;
                width: 100%;
                max-width: 440px;
                border-radius: 20px;
                margin: 0 auto;
            }

            /* Mobile: photo becomes a banner */
            .photo-side {
                min-height: unset;
                height: auto;
            }

            .photo-side img {
                height: 220px;
                transform: scale(1.0);
            }

            .photo-content {
                position: relative;
                /* stack in flow */
                padding: 28px 24px 24px;
                background: linear-gradient(135deg,
                        rgba(61, 0, 0, .92) 0%,
                        rgba(90, 0, 0, .85) 50%,
                        rgba(30, 0, 0, .9) 100%);
            }

            /* Hide the campus photo entirely on mobile — use CSS bg only */
            .photo-side img {
                display: none;
            }

            .photo-side::after {
                display: none;
            }

            .photo-title-main {
                font-size: 28px;
            }

            .photo-title-sub {
                font-size: 10px;
                letter-spacing: .14em;
            }

            .logo-circle {
                width: 52px;
                height: 52px;
            }

            .logo-circle img {
                width: 36px;
                height: 36px;
            }

            .photo-tagline {
                display: none;
            }

            .photo-badge {
                position: relative;
                bottom: unset;
                left: unset;
                transform: none;
                margin: 12px auto 0;
                display: inline-flex;
            }

            /* Form */
            .form-side {
                padding: 28px 24px 36px;
            }

            .form-heading {
                font-size: 24px;
            }

            .form-sub {
                margin-bottom: 22px;
                font-size: 12.5px;
            }

            .field {
                margin-bottom: 16px;
            }

            .field-input {
                padding: 12px 14px;
                font-size: 15px;
            }

            .btn-submit {
                padding: 13px;
                font-size: 14px;
            }

            .register-row {
                font-size: 12.5px;
            }
        }

        @media (max-width: 380px) {
            body {
                padding: 12px;
                padding-top: 20px;
            }

            .form-side {
                padding: 24px 18px 28px;
            }

            .photo-content {
                padding: 22px 20px 20px;
            }

            .photo-title-main {
                font-size: 24px;
            }

            .logo-circle {
                width: 46px;
                height: 46px;
            }

            .logo-circle img {
                width: 32px;
                height: 32px;
            }
        }
    </style>
</head>

<body>
    <canvas id="stars"></canvas>
    <div class="glow-orb glow-orb-1"></div>
    <div class="glow-orb glow-orb-2"></div>
    <div id="toastContainer"></div>

    <main>
        <div class="login-card">

            <!-- LEFT / TOP: Photo Panel -->
            <div class="photo-side">
                <img src="/images/PUP TAGUIG CAMPUS.jpg" alt="PUP Taguig Campus">

                <div class="photo-content">
                    <!-- Title first -->
                    <h2>
                        <span class="shine-text photo-title-main">PUP TAGUIG</span>
                        <span class="shine-text photo-title-sub">DENTAL MANAGEMENT SYSTEM</span>
                    </h2>

                    <!-- Divider -->
                    <div class="photo-divider">
                        <div class="photo-divider-line"></div>
                        <div class="photo-divider-dot"></div>
                        <div class="photo-divider-line r"></div>
                    </div>

                    <!-- Logos below title -->
                    <div class="logo-row">
                        <div class="logo-circle">
                            <img src="{{ asset('images/PUP.png') }}" alt="PUP">
                        </div>
                        <div class="logo-v-divider"></div>
                        <div class="logo-circle">
                            <img src="{{ asset('images/PUPT-DMS-Logo.png') }}" alt="DMS">
                        </div>
                    </div>

                    <p class="photo-tagline">
                        Your campus dental clinic, now fully digital.<br>
                        Book appointments, view records, and more.
                    </p>

                    <div class="photo-badge">
                        <i class="fa-solid fa-tooth" style="font-size:8px;"></i>
                        Patient Portal
                    </div>
                </div>
            </div>

            <!-- RIGHT / BOTTOM: Form -->
            <div class="form-side">

                <div class="form-portal-label">
                    <div class="form-portal-pip"></div>
                    <span class="form-portal-text">Secure Login</span>
                </div>

                <h1 class="form-heading">Welcome <span>back.</span></h1>
                <p class="form-sub">Sign in to access your dental appointments and records.</p>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="field">
                        <label class="field-label">
                            <i class="fa-solid fa-user"></i> Email or Username
                        </label>
                        <input type="text" name="email" required placeholder="Enter your email or username"
                            class="field-input" autocomplete="username">
                    </div>

                    <div class="field">
                        <label class="field-label">
                            <i class="fa-solid fa-lock"></i> Password
                        </label>
                        <div class="pw-wrap">
                            <input type="password" id="loginPw" name="password" required placeholder="••••••••"
                                class="field-input" style="padding-right:46px;" autocomplete="current-password">
                            <button type="button" class="pw-toggle" onclick="togglePw()">
                                <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">
                        Sign In
                        <div class="btn-arrow">
                            <i class="fa-solid fa-arrow-right" style="font-size:11px;"></i>
                        </div>
                    </button>
                </form>

                <div class="register-row">
                    New patient? <a href="/register">Create an account</a>
                </div>

            </div>
        </div>
    </main>

    <!-- ══════ LOGIN FOOTER ══════ -->
    <footer class="login-footer">
    <div class="login-footer-inner">

        <div class="footer-divider">
        <span></span>
        <i class="fa-solid fa-shield-halved"></i>
        <span></span>
        </div>

        <p class="footer-text">
        <span class="footer-year">© 1998–2026</span>
        <strong>Polytechnic University of the Philippines</strong>
        </p>

        <div class="footer-links">
        <a href="https://www.pup.edu.ph/terms/" target="_blank">Terms of Use</a>
        <span class="dot"></span>
        <a href="https://www.pup.edu.ph/privacy/" target="_blank">Privacy Statement</a>
        </div>

    </div>
    </footer>

    <script>
        /* STARS */
        (function () {
            const canvas = document.getElementById('stars');
            const ctx = canvas.getContext('2d');
            let w, h, stars = [];

            function resize() {
                w = canvas.width = window.innerWidth;
                h = canvas.height = window.innerHeight;
                stars = Array.from({
                    length: 200
                }, () => ({
                    x: Math.random() * w,
                    y: Math.random() * h,
                    r: Math.random() * 1.6 + 0.3,
                    v: Math.random() * 0.25 + 0.06,
                    a: Math.random() * 0.7 + 0.3,
                }));
            }

            function draw() {
                ctx.clearRect(0, 0, w, h);
                for (const s of stars) {
                    ctx.globalAlpha = s.a * 0.75;
                    ctx.fillStyle = '#FFF8DC';
                    ctx.beginPath();
                    ctx.arc(s.x, s.y, s.r, 0, Math.PI * 2);
                    ctx.fill();
                    s.y -= s.v;
                    if (s.y < 0) {
                        s.y = h;
                        s.x = Math.random() * w;
                    }
                }
                ctx.globalAlpha = 1;
                requestAnimationFrame(draw);
            }

            window.addEventListener('resize', resize);
            resize();
            draw();
        })();

        /* PASSWORD TOGGLE */
        function togglePw() {
            const inp = document.getElementById('loginPw');
            const icon = document.getElementById('eyeIcon');
            const isText = inp.type === 'text';
            inp.type = isText ? 'password' : 'text';
            icon.innerHTML = isText ?
                `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>` :
                `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.042-3.368M6.223 6.223A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.956 9.956 0 01-4.132 5.411M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18"/>`;
        }

        /* TOAST */
        function showToast(title, message, type = 'error') {
            const container = document.getElementById('toastContainer');
            const t = document.createElement('div');
            t.className = `toast ${type}`;
            const icon = type === 'error' ?
                '<i class="fa-solid fa-circle-exclamation toast-icon"></i>' :
                '<i class="fa-solid fa-circle-check toast-icon"></i>';
            t.innerHTML = `
                <div class="toast-icon-wrap">${icon}</div>
                <div class="toast-body">
                    <div class="toast-title">${title}</div>
                    <div class="toast-msg">${message}</div>
                </div>
                <button class="toast-close" onclick="this.closest('.toast').classList.add('hide')">
                    <i class="fa-solid fa-xmark"></i>
                </button>`;
            container.appendChild(t);
            requestAnimationFrame(() => requestAnimationFrame(() => t.classList.add('show')));
            setTimeout(() => {
                t.classList.remove('show');
                t.classList.add('hide');
                setTimeout(() => t.remove(), 400);
            }, 4500);
        }
    </script>

    {{-- ERROR from server --}}
    @if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', () =>
            showToast('Login Failed', "{{ session('error') }}", 'error')
        );
    </script>
    @endif

    {{-- SUCCESS login toast: pass role name from controller via session('login_as') --}}
    @if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', () =>
            showToast('Logged in successfully', "{{ session('success') }}", 'success')
        );
    </script>
    @endif

    {{-- Login success with role name e.g. "Logged in successfully as Admin" --}}
    @if (session('login_as'))
    <script>
        document.addEventListener('DOMContentLoaded', () =>
            showToast(
                'Login Successful',
                'Logged in successfully as <strong>{{ session('login_as') }}</strong>',
                'success'
            )
        );
    </script>
    @endif

</body>

</html>