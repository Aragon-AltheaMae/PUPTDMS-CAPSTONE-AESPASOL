<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'System Error')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            font-family: 'Inter', sans-serif;
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --primary: #8B0000;
            --primary-dark: #5f0000;
            --primary-soft: #fff1f1;
            --primary-border: #efcaca;
            --ink: #1f1720;
            --muted: #8a6f6f;
            --surface: rgba(255, 255, 255, 0.9);
            --surface-strong: #ffffff;
            --line: #f0d9d9;
            --shadow: 0 30px 80px rgba(139, 0, 0, 0.12);
        }

        .shell {
            animation: fadeUp 0.8s ease-out;
        }

        @keyframes fadeUp {
            0% {
                opacity: 0;
                transform: translateY(30px) scale(.98);
            }

            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes floatCard {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-6px);
            }
        }

        body {
            margin: 0;
        }

        .page {
            min-height: 100vh;
            position: relative;
            overflow: hidden;
            display: grid;
            place-items: center;
            padding: 24px;
            background:
                linear-gradient(rgba(20, 10, 10, 0.65), rgba(20, 10, 10, 0.75)),
                url('/images/PUP-Pylon.jpg') center/cover no-repeat;
            background-attachment: fixed;
        }

        .error-500 .page {
            background:
                linear-gradient(rgba(60, 0, 0, 0.75), rgba(20, 0, 0, 0.85)),
                url('/images/PUP-Pylon.jpg') center/cover no-repeat;
        }

        .error-404 .page {
            background:
                linear-gradient(rgba(30, 30, 30, 0.65), rgba(15, 15, 15, 0.75)),
                url('/images/PUP-Pylon.jpg') center/cover no-repeat;
        }

        .error-403 .page {
            background:
                linear-gradient(rgba(80, 40, 0, 0.70), rgba(30, 15, 0, 0.80)),
                url('/images/PUP-Pylon.jpg') center/cover no-repeat;
        }

        .bg-orb {
            position: absolute;
            border-radius: 999px;
            filter: blur(80px);
            opacity: 0.5;
            pointer-events: none;
        }

        .bg-orb.one {
            width: 280px;
            height: 280px;
            top: -70px;
            left: -60px;
            background: rgba(139, 0, 0, 0.12);
        }

        .bg-orb.two {
            width: 340px;
            height: 340px;
            right: -120px;
            bottom: -100px;
            background: rgba(255, 133, 133, 0.18);
        }

        .bg-teeth {
            position: absolute;
            inset: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .bt {
            position: absolute;
            opacity: 0.055;
            color: var(--primary);
        }

        .bt:nth-child(1) {
            top: 5%;
            left: 7%;
            width: 40px;
            animation: floatA 8s ease-in-out infinite;
        }

        .bt:nth-child(2) {
            top: 10%;
            left: 20%;
            width: 28px;
            animation: floatB 9s ease-in-out infinite;
        }

        .bt:nth-child(3) {
            top: 6%;
            left: 37%;
            width: 50px;
            animation: floatA 10s ease-in-out infinite;
        }

        .bt:nth-child(4) {
            top: 8%;
            left: 59%;
            width: 34px;
            animation: floatB 8s ease-in-out infinite;
        }

        .bt:nth-child(5) {
            top: 6%;
            left: 82%;
            width: 42px;
            animation: floatA 9s ease-in-out infinite;
        }

        .bt:nth-child(6) {
            top: 25%;
            left: 5%;
            width: 30px;
            animation: floatB 10s ease-in-out infinite;
        }

        .bt:nth-child(7) {
            top: 30%;
            left: 17%;
            width: 46px;
            animation: floatA 8s ease-in-out infinite;
        }

        .bt:nth-child(8) {
            top: 22%;
            left: 74%;
            width: 36px;
            animation: floatB 9s ease-in-out infinite;
        }

        .bt:nth-child(9) {
            top: 28%;
            left: 90%;
            width: 30px;
            animation: floatA 11s ease-in-out infinite;
        }

        .bt:nth-child(10) {
            top: 49%;
            left: 4%;
            width: 42px;
            animation: floatA 10s ease-in-out infinite;
        }

        .bt:nth-child(11) {
            top: 55%;
            left: 24%;
            width: 28px;
            animation: floatB 8s ease-in-out infinite;
        }

        .bt:nth-child(12) {
            top: 46%;
            left: 82%;
            width: 46px;
            animation: floatA 9s ease-in-out infinite;
        }

        .bt:nth-child(13) {
            top: 58%;
            left: 92%;
            width: 34px;
            animation: floatB 10s ease-in-out infinite;
        }

        .bt:nth-child(14) {
            top: 74%;
            left: 8%;
            width: 36px;
            animation: floatB 9s ease-in-out infinite;
        }

        .bt:nth-child(15) {
            top: 80%;
            left: 21%;
            width: 50px;
            animation: floatA 11s ease-in-out infinite;
        }

        .bt:nth-child(16) {
            top: 86%;
            left: 43%;
            width: 32px;
            animation: floatB 8s ease-in-out infinite;
        }

        .bt:nth-child(17) {
            top: 79%;
            left: 68%;
            width: 44px;
            animation: floatA 9s ease-in-out infinite;
        }

        .bt:nth-child(18) {
            top: 87%;
            left: 87%;
            width: 30px;
            animation: floatB 10s ease-in-out infinite;
        }

        @keyframes floatA {

            0%,
            100% {
                transform: translateY(0) rotate(-5deg);
            }

            50% {
                transform: translateY(-10px) rotate(4deg);
            }
        }

        @keyframes floatB {

            0%,
            100% {
                transform: translateY(0) rotate(5deg);
            }

            50% {
                transform: translateY(-12px) rotate(-4deg);
            }
        }

        .shell {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 980px;
            border-radius: 32px;

            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);

            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.35);
            overflow: hidden;
        }

        .shell-grid {
            display: grid;
            grid-template-columns: 360px 1fr;
            min-height: 560px;
        }

        .brand-panel {
            position: relative;
            background: linear-gradient(180deg, #8B0000 0%, #740000 50%, #5f0000 100%);
            color: #fff;
            padding: 36px 30px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .brand-panel::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at top right, rgba(255, 255, 255, 0.18), transparent 30%),
                radial-gradient(circle at bottom left, rgba(255, 255, 255, 0.12), transparent 28%);
            pointer-events: none;
        }

        .brand-top,
        .brand-bottom,
        .brand-center {
            position: relative;
            z-index: 1;
        }

        .brand-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.18);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .brand-chip-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #ffd7d7;
            box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.08);
        }

        .brand-center {
            display: flex;
            flex-direction: column;
            gap: 18px;
            margin-top: 40px;
        }

        .brand-icon {
            width: 86px;
            height: 86px;
            border-radius: 24px;
            display: grid;
            place-items: center;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.16);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.08);
            position: relative;
        }

        .brand-icon svg {
            width: 42px;
            height: 42px;
        }

        .brand-icon::after {
            content: "";
            position: absolute;
            inset: -6px;
            border-radius: 28px;
            background: rgba(255, 255, 255, 0.15);
            filter: blur(10px);
            opacity: 0;
            animation: glowPulse 2.5s ease-in-out infinite;
        }

        @keyframes glowPulse {

            0%,
            100% {
                opacity: 0;
            }

            50% {
                opacity: 1;
            }
        }

        .brand-title {
            font-size: 30px;
            line-height: 1.15;
            font-weight: 800;
            max-width: 220px;
        }

        .brand-text {
            font-size: 14px;
            line-height: 1.8;
            color: rgba(255, 255, 255, 0.82);
            max-width: 240px;
            margin-top: 10px;
        }

        .brand-bottom {
            display: flex;
            justify-content: space-between;
            align-items: end;
            gap: 12px;
            color: rgba(255, 255, 255, 0.78);
            font-size: 12px;
        }

        .brand-status {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.18);
            font-weight: 600;
        }

        .brand-status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #ffd2d2;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: .4;
                transform: scale(.82);
            }
        }

        .content-panel {
            position: relative;
            padding: 36px 42px;
            display: flex;
            flex-direction: column;
            justify-content: center;

            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(6px);
        }

        .content-panel::before {
            content: "";
            position: absolute;
            left: 0;
            top: 28px;
            bottom: 28px;
            width: 1px;
            background: linear-gradient(180deg, transparent, #edd0d0 15%, #edd0d0 85%, transparent);
        }

        .page::after {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at center, rgba(139, 0, 0, 0.15), transparent 60%);
            pointer-events: none;
        }

        .mini-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            width: fit-content;
            padding: 8px 12px;
            border-radius: 999px;
            background: var(--primary-soft);
            border: 1px solid var(--primary-border);
            color: var(--primary);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.04em;
            margin-bottom: 18px;
        }

        .mini-label .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--primary);
        }

        .error-code {
            position: relative;
            display: inline-block;
            font-size: clamp(86px, 12vw, 140px);
            line-height: 0.95;
            letter-spacing: -0.08em;
            font-weight: 900;
            color: var(--primary-dark);
            animation: popIn 0.6s ease;
        }

        .error-500 .error-code {
            animation:
                popIn 0.6s ease,
                glitchSkew 3.5s infinite steps(1, end);
        }

        .error-500 .error-code::before,
        .error-500 .error-code::after {
            content: attr(data-text);
            position: absolute;
            inset: 0;
            pointer-events: none;
            opacity: 0;
        }

        .error-500 .error-code::before {
            color: rgba(255, 80, 80, 0.7);
            transform: translateX(-2px);
            animation: glitchBefore 3.5s infinite steps(1, end);
        }

        .error-500 .error-code::after {
            color: rgba(255, 255, 255, 0.5);
            transform: translateX(2px);
            animation: glitchAfter 3.5s infinite steps(1, end);
        }

        @keyframes glitchSkew {

            0%,
            94%,
            100% {
                transform: skew(0deg);
            }

            95% {
                transform: skew(1deg);
            }

            96% {
                transform: skew(-1deg);
            }

            97% {
                transform: skew(0.5deg);
            }

            98% {
                transform: skew(-0.5deg);
            }
        }

        @keyframes glitchBefore {

            0%,
            94%,
            100% {
                opacity: 0;
                clip-path: inset(0 0 0 0);
            }

            95% {
                opacity: 1;
                clip-path: inset(10% 0 55% 0);
            }

            96% {
                opacity: 1;
                clip-path: inset(65% 0 8% 0);
            }

            97% {
                opacity: 1;
                clip-path: inset(35% 0 30% 0);
            }
        }

        @keyframes glitchAfter {

            0%,
            94%,
            100% {
                opacity: 0;
                clip-path: inset(0 0 0 0);
            }

            95% {
                opacity: 1;
                clip-path: inset(60% 0 12% 0);
            }

            96% {
                opacity: 1;
                clip-path: inset(18% 0 58% 0);
            }

            97% {
                opacity: 1;
                clip-path: inset(42% 0 22% 0);
            }
        }

        @keyframes popIn {
            0% {
                transform: scale(.8);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .error-code span {
            color: #b32020;
        }

        .headline {
            margin-top: 18px;
            font-size: clamp(28px, 3vw, 40px);
            line-height: 1.08;
            letter-spacing: -0.04em;
            color: var(--ink);
            font-weight: 800;
            max-width: 460px;
        }

        .desc {
            margin-top: 14px;
            max-width: 540px;
            font-size: 15px;
            line-height: 1.85;
            color: var(--muted);
        }

        .notice-box {
            margin-top: 24px;
            padding: 16px 18px;
            border-radius: 18px;
            background: #fff8f8;
            border: 1px solid #f2d7d7;
            display: flex;
            gap: 12px;
            align-items: flex-start;
            max-width: 560px;
            transition: all 0.2s ease;
        }

        .notice-box:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(139, 0, 0, 0.08);
        }

        .notice-icon {
            flex-shrink: 0;
            width: 38px;
            height: 38px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            background: #fff;
            border: 1px solid #f0d1d1;
            color: var(--primary);
        }

        .notice-icon svg {
            width: 18px;
            height: 18px;
        }

        .notice-text {
            font-size: 13px;
            line-height: 1.7;
            color: #7f6161;
        }

        .actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 28px;
        }

        .btn-primary,
        .btn-secondary {
            min-height: 48px;
            padding: 0 20px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 14px;
            font-weight: 700;
            transition: all 0.18s ease;
        }

        .btn-primary {
            background: linear-gradient(180deg, #980808 0%, #7a0000 100%);
            color: #fff;
            border: 1px solid #7a0000;
            box-shadow: 0 10px 24px rgba(139, 0, 0, 0.18);
            cursor: pointer;
        }

        .btn-primary:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 14px 30px rgba(139, 0, 0, 0.25);
        }

        .btn-secondary {
            background: #fff;
            color: var(--primary);
            border: 1px solid #e7bebe;
        }

        .btn-secondary:hover {
            transform: translateY(-1px);
            background: #fff7f7;
        }

        @media (max-width: 900px) {
            .shell-grid {
                grid-template-columns: 1fr;
            }

            .brand-panel {
                min-height: 280px;
                padding: 28px 24px;
            }

            .content-panel {
                padding: 30px 24px 28px;
            }

            .content-panel::before {
                display: none;
            }

            .headline,
            .desc,
            .notice-box {
                max-width: 100%;
            }
        }

        @media (max-width: 560px) {
            .page {
                padding: 16px;
            }

            .shell {
                border-radius: 24px;
            }

            .brand-title {
                font-size: 24px;
                max-width: 100%;
            }

            .error-code {
                font-size: 78px;
            }

            .headline {
                font-size: 26px;
            }

            .actions {
                flex-direction: column;
            }

            .btn-primary,
            .btn-secondary {
                width: 100%;
            }

            .brand-bottom {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        .logo {
            width: 60px;
            height: 60px;
            object-fit: contain;
            filter: drop-shadow(0 6px 12px rgba(255, 255, 255, 0.25));
        }

        .error-500 .shell {
            animation:
                fadeUp 0.8s ease-out,
                floatCard 6s ease-in-out infinite,
                errorShake 4.5s ease-in-out infinite;
        }

        @keyframes errorShake {

            0%,
            92%,
            100% {
                transform: translateY(0) translateX(0);
            }

            93% {
                transform: translateY(0) translateX(-2px) rotate(-0.3deg);
            }

            94% {
                transform: translateY(0) translateX(2px) rotate(0.3deg);
            }

            95% {
                transform: translateY(0) translateX(-3px) rotate(-0.4deg);
            }

            96% {
                transform: translateY(0) translateX(3px) rotate(0.4deg);
            }

            97% {
                transform: translateY(0) translateX(-2px) rotate(-0.2deg);
            }

            98% {
                transform: translateY(0) translateX(2px) rotate(0.2deg);
            }

            99% {
                transform: translateY(0) translateX(0);
            }
        }

        .error-404 .shell {
            animation:
                fadeUp 0.8s ease-out,
                lostFloat 7s ease-in-out infinite,
                lostFade 5.5s ease-in-out infinite;
        }

        @keyframes lostFloat {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        @keyframes lostFade {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.92;
            }
        }

        .error-403 .shell {
            animation:
                fadeUp 0.8s ease-out,
                floatCard 6s ease-in-out infinite,
                warnPulse 2.8s ease-in-out infinite;
        }

        @keyframes warnPulse {

            0%,
            100% {
                box-shadow: 0 30px 80px rgba(0, 0, 0, 0.35);
            }

            50% {
                box-shadow: 0 30px 95px rgba(217, 119, 6, 0.28);
            }
        }

        .error-404 .mini-label,
        .error-404 .notice-box {
            animation: lostDrift 6s ease-in-out infinite;
        }

        @keyframes lostDrift {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-4px);
            }
        }

        .error-403 .notice-icon,
        .error-403 .btn-primary {
            animation: lockedPulse 2.2s ease-in-out infinite;
        }

        @keyframes lockedPulse {

            0%,
            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(217, 119, 6, 0);
            }

            50% {
                transform: scale(1.02);
                box-shadow: 0 0 0 10px rgba(217, 119, 6, 0.08);
            }
        }
    </style>
</head>

<body class="error-@yield('code')">
    <div class="page">
        <div class="bg-orb one"></div>
        <div class="bg-orb two"></div>
        <div class="bg-teeth" id="bgTeeth"></div>

        <div class="shell">
            <div class="shell-grid">
                <div class="brand-panel">
                    <div class="brand-top">
                        <div class="brand-chip">
                            <span class="brand-chip-dot"></span>
                            PUP Taguig Dental Clinic
                        </div>
                    </div>

                    <div class="brand-center">
                        <div class="brand-icon">
                            <img src="{{ asset('images/PUPT-DMS-Logo.png') }}" alt="PUP Dental" class="logo">
                        </div>

                        <div>
                            <div class="brand-title">@yield('brand_title')</div>
                            <div class="brand-text">@yield('brand_text')</div>
                        </div>
                    </div>

                    <div class="brand-bottom">
                        <span>PUPTDMS · Error @yield('code')</span>
                        <span class="brand-status">
                            <span class="brand-status-dot"></span>
                            @yield('status', 'System notice')
                        </span>
                    </div>
                </div>

                <div class="content-panel">
                    <div class="mini-label">
                        <span class="dot"></span>
                        @yield('label')
                    </div>

                    <div class="error-code" data-text="@yield('code')">@yield('code_styled')</div>

                    <h1 class="headline">@yield('message')</h1>

                    <p class="desc">@yield('description')</p>

                    <div class="notice-box">
                        <div class="notice-icon">
                            @yield('notice_icon')
                        </div>
                        <div class="notice-text">
                            @yield('notice_text')
                        </div>
                    </div>

                    <div class="actions">
                        <button type="button" class="btn-primary" onclick="history.back()">Go Back</button>
                        <a href="{{ url('/') }}" class="btn-secondary">Return Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const container = document.getElementById('bgTeeth');

        if (container) {
            const path = `
                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" width="100%" height="100%">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.5 3.5c1.2 0 2.2.4 3.5 1.2 1.3-.8 2.3-1.2 3.5-1.2 2.6 0 4.5 2 4.5 5.1 0 2.5-.9 4.8-2.1 7-.8 1.5-1.7 3.3-2.9 3.3-.9 0-1.2-.8-1.5-1.8-.3-1.1-.7-2.2-1.5-2.2s-1.2 1.1-1.5 2.2c-.3 1-.6 1.8-1.5 1.8-1.2 0-2.1-1.8-2.9-3.3-1.2-2.2-2.1-4.5-2.1-7 0-3.1 1.9-5.1 4.5-5.1z"/>
                </svg>
            `;

            for (let i = 0; i < 18; i++) {
                const d = document.createElement('div');
                d.className = 'bt';
                d.innerHTML = path;
                container.appendChild(d);
            }
        }
    </script>
</body>

</html>
