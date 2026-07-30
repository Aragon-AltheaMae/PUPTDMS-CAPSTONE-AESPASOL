<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Under Maintenance — PUP Taguig Dental Clinic</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --crimson: #c0001a;
            --crimson-dark: #7a0010;
            --gold: #f5a623;
            --gold-light: #ffd97d;
            --white: #ffffff;
        }

        html, body {
            height: 100%;
            overflow: hidden;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #7a0010;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            color: #fff;
            position: relative;
        }

        /* ─── gradient background ─── */
        .bg-gradient {
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 10% 20%, #cc2200 0%, transparent 60%),
                radial-gradient(ellipse 70% 50% at 90% 80%, #f5a62344 0%, transparent 55%),
                linear-gradient(135deg, #1a0000 0%, #5a0008 25%, #7a000e 50%, #c04000 80%, #f5a623 100%);
            z-index: 0;
        }

        /* ─── blobs ─── */
        .blobs {
            position: fixed;
            inset: 0;
            z-index: 1;
            pointer-events: none;
            overflow: hidden;
        }

        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.35;
            animation: blob-float linear infinite;
            will-change: transform;
        }

        .blob-1 {
            width: 520px; height: 520px;
            background: radial-gradient(circle, #ff6a00cc, transparent 70%);
            top: -120px; left: -100px;
            animation-duration: 18s;
        }
        .blob-2 {
            width: 420px; height: 420px;
            background: radial-gradient(circle, #f5a623bb, transparent 70%);
            bottom: -80px; right: -80px;
            animation-duration: 22s;
            animation-direction: reverse;
        }
        .blob-3 {
            width: 300px; height: 300px;
            background: radial-gradient(circle, #ffd97daa, transparent 70%);
            top: 40%; left: 60%;
            animation-duration: 14s;
            opacity: 0.2;
        }
        .blob-4 {
            width: 240px; height: 240px;
            background: radial-gradient(circle, #ff2d55bb, transparent 70%);
            top: 60%; left: 10%;
            animation-duration: 20s;
        }

        @keyframes blob-float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(30px, -40px) scale(1.05); }
            50% { transform: translate(-20px, 30px) scale(0.96); }
            75% { transform: translate(40px, 20px) scale(1.03); }
        }

        /* ─── sparkles ─── */
        .sparkles {
            position: fixed;
            inset: 0;
            z-index: 2;
            pointer-events: none;
        }

        .sparkle {
            position: absolute;
            width: 6px; height: 6px;
            border-radius: 50%;
            background: var(--gold-light);
            box-shadow: 0 0 6px 2px var(--gold-light);
            animation: sparkle-twinkle ease-in-out infinite;
        }

        @keyframes sparkle-twinkle {
            0%, 100% { opacity: 0; transform: scale(0.4); }
            50% { opacity: 1; transform: scale(1); }
        }

        /* ─── noise overlay ─── */
        .noise {
            position: fixed;
            inset: 0;
            z-index: 3;
            pointer-events: none;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='1'/%3E%3C/svg%3E");
            opacity: 0.045;
        }

        /* ─── main content ─── */
        .content {
            position: relative;
            z-index: 10;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 2.5rem 2rem;
            max-width: 560px;
            width: 100%;
        }

        /* ─── icon animation ─── */
        .icon-wrap {
            position: relative;
            width: 110px;
            height: 110px;
            margin-bottom: 2.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon-ring {
            position: absolute;
            inset: 0;
            border-radius: 50%;
            border: 1.5px solid rgba(255,255,255,0.15);
            animation: ring-expand 3s ease-out infinite;
        }
        .icon-ring:nth-child(2) { animation-delay: 1s; }
        .icon-ring:nth-child(3) { animation-delay: 2s; }

        @keyframes ring-expand {
            0% { transform: scale(1); opacity: 0.5; }
            100% { transform: scale(2.2); opacity: 0; }
        }

        .tooth-icon {
            position: relative;
            z-index: 2;
            font-size: 56px;
            filter: drop-shadow(0 0 24px rgba(255, 200, 100, 0.5));
            animation: tooth-float 4s ease-in-out infinite;
        }

        @keyframes tooth-float {
            0%, 100% { transform: translateY(0) rotate(-4deg); }
            50% { transform: translateY(-12px) rotate(4deg); }
        }

        /* ─── eyebrow ─── */
        .eyebrow {
            font-family: 'Inter', sans-serif;
            font-size: 0.65rem;
            font-weight: 600;
            letter-spacing: 0.28em;
            text-transform: uppercase;
            color: rgba(255,215,100,0.7);
            margin-bottom: 1rem;
            animation: fade-up 0.8s 0.1s both;
        }

        /* ─── heading ─── */
        .heading {
            font-family: 'Inter', sans-serif;
            font-size: clamp(2.8rem, 9vw, 5rem);
            font-weight: 800;
            line-height: 1.05;
            letter-spacing: -0.03em;
            color: #fff;
            margin-bottom: 0.5rem;
            animation: fade-up 0.8s 0.18s both;
        }

        .heading .dim {
            color: rgba(255,255,255,0.45);
        }

        /* ─── subtitle ─── */
        .subtitle {
            font-family: 'Inter', sans-serif;
            font-size: 0.95rem;
            font-weight: 300;
            color: rgba(255,255,255,0.65);
            line-height: 1.75;
            margin: 1.4rem auto 2.2rem;
            max-width: 520px;
            animation: fade-up 0.8s 0.26s both;
        }

        .subtitle strong {
            color: rgba(255,255,255,0.9);
            font-weight: 600;
        }

        /* ─── status pill ─── */
        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(0,0,0,0.18);
            border: 1px solid rgba(255,255,255,0.14);
            border-radius: 99px;
            padding: 9px 20px;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.05em;
            color: rgba(255,255,255,0.8);
            margin-bottom: 2rem;
            backdrop-filter: blur(10px);
            animation: fade-up 0.8s 0.38s both;
        }

        .pulse {
            width: 8px; height: 8px;
            border-radius: 50%;
            background: var(--gold-light);
            box-shadow: 0 0 0 3px rgba(255,215,100,0.25);
            animation: pulse-anim 2s ease-in-out infinite;
            flex-shrink: 0;
        }

        @keyframes pulse-anim {
            0%, 100% { box-shadow: 0 0 0 3px rgba(255,215,100,0.25); }
            50% { box-shadow: 0 0 0 8px rgba(255,215,100,0.05); }
        }

        /* ─── button ─── */
        .refresh-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 32px;
            border-radius: 14px;
            border: 1px solid rgba(255,255,255,0.28);
            background: rgba(255,255,255,0.1);
            color: #fff;
            font-family: 'Inter', sans-serif;
            font-size: 0.82rem;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            cursor: pointer;
            text-decoration: none;
            backdrop-filter: blur(10px);
            transition: background 0.2s, border-color 0.2s, transform 0.2s, box-shadow 0.2s;
            animation: fade-up 0.8s 0.44s both;
        }

        .refresh-btn:hover {
            background: rgba(255,255,255,0.2);
            border-color: rgba(255,255,255,0.45);
            transform: translateY(-3px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.2);
        }

        .refresh-btn:active { transform: translateY(-1px); }

        .refresh-btn .fa-rotate-right {
            transition: transform 0.5s;
        }

        .refresh-btn:hover .fa-rotate-right {
            transform: rotate(180deg);
        }

        /* ─── bottom note ─── */
        .bottom-note {
            position: fixed;
            bottom: 28px;
            font-family: 'Inter', sans-serif;
            font-size: 0.72rem;
            font-weight: 400;
            color: rgba(255,255,255,0.3);
            z-index: 10;
            letter-spacing: 0.03em;
        }

        .bottom-note a {
            color: rgba(255,220,120,0.6);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.15s;
        }

        .bottom-note a:hover { color: rgba(255,220,120,0.95); }

        /* ─── fade-up animation ─── */
        @keyframes fade-up {
            from { opacity: 0; transform: translateY(22px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ─── responsive ─── */
        @media (max-width: 480px) {
            .heading { font-size: 3rem; }
            .tooth-icon { font-size: 44px; }
            .icon-wrap { width: 86px; height: 86px; }
        }
    </style>
</head>
<body>

    <div class="bg-gradient"></div>

    <!-- blobs -->
    <div class="blobs">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="blob blob-3"></div>
        <div class="blob blob-4"></div>
    </div>

    <!-- sparkles (generated by JS) -->
    <div class="sparkles" id="sparkles"></div>

    <div class="noise"></div>

    <div class="content">

        <div class="icon-wrap">
            <div class="icon-ring"></div>
            <div class="icon-ring"></div>
            <div class="icon-ring"></div>
            <span class="tooth-icon">🦷</span>
        </div>

        <p class="eyebrow">PUP Taguig Dental Clinic</p>

        <h1 class="heading">
            Oops! <span class="dim">We're</span><br>fixing things.
        </h1>

        <p class="subtitle">
            The system is currently undergoing
            <strong>scheduled maintenance.</strong>
            We'll be back up shortly — thanks for your patience!
        </p>

        <div class="status-pill">
            <div class="pulse"></div>
            Maintenance in progress
        </div>

        <a href="javascript:location.reload()" class="refresh-btn">
            <i class="fa-solid fa-rotate-right"></i>
            Refresh Page
        </a>

    </div>

    <p class="bottom-note">
        Need urgent help?&nbsp;&nbsp;<a href="/cdn-cgi/l/email-protection#f793929983969bb7878287839690829e90d9929382d9879f"><span class="__cf_email__" data-cfemail="f397969d87929fb3838683879294869a94dd969786dd839b">[insert email here!]</span></a>
    </p>

    <script>
        // generate sparkles (circles only)
        const container = document.getElementById('sparkles');
        const count = 38;
        for (let i = 0; i < count; i++) {
            const s = document.createElement('div');
            s.className = 'sparkle';
            const size = Math.random() * 5 + 3;
            s.style.cssText = `
                left: ${Math.random() * 100}%;
                top: ${Math.random() * 100}%;
                width: ${size}px;
                height: ${size}px;
                animation-duration: ${1.8 + Math.random() * 3.5}s;
                animation-delay: ${Math.random() * 4}s;
                opacity: 0;
            `;
            container.appendChild(s);
        }

        // auto-reload after 60s
        setTimeout(() => location.reload(), 60000);
    </script>
</body>
</html>