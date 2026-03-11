<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PUPT-DMS | Admin Portal</title>
  <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --gold: #C9A84C;
      --gold-light: #F0D080;
      --gold-dim: rgba(201,168,76,.12);
      --crimson: #8B0000;
      --bg: #080C14;
      --surface: #0D1322;
      --border: rgba(201,168,76,.18);
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'DM Sans', sans-serif;
      min-height: 100vh;
      background: var(--bg);
      display: flex; align-items: center; justify-content: center;
      padding: 20px;
    }

    /* ── BACKGROUND ── */
    #bgCanvas { position: fixed; inset: 0; z-index: 0; pointer-events: none; }

    /* Diagonal stripe texture */
    .bg-stripes {
      position: fixed; inset: 0; z-index: 0; pointer-events: none;
      background-image: repeating-linear-gradient(
        -45deg,
        transparent 0px, transparent 28px,
        rgba(201,168,76,.025) 28px, rgba(201,168,76,.025) 29px
      );
    }

    /* Corner glow */
    .bg-glow {
      position: fixed; pointer-events: none; z-index: 0;
      border-radius: 50%;
      filter: blur(80px);
    }
    .bg-glow-1 {
      width: 500px; height: 500px;
      top: -150px; right: -100px;
      background: radial-gradient(circle, rgba(201,168,76,.08) 0%, transparent 70%);
    }
    .bg-glow-2 {
      width: 400px; height: 400px;
      bottom: -100px; left: -80px;
      background: radial-gradient(circle, rgba(139,0,0,.12) 0%, transparent 70%);
    }

    /* ── CARD ── */
    .login-card {
      position: relative; z-index: 10;
      width: min(92vw, 440px);
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 24px;
      padding: 44px 40px 36px;
      box-shadow:
        0 40px 100px rgba(0,0,0,.7),
        0 0 0 1px rgba(201,168,76,.08),
        inset 0 1px 0 rgba(201,168,76,.1);
      animation: cardIn .65s cubic-bezier(.22,1,.36,1) both;
    }
    @keyframes cardIn {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    /* Top gold line with dot */
    .card-top-line {
      position: absolute; top: -1px; left: 50%; transform: translateX(-50%);
      width: 55%; height: 1px;
      background: linear-gradient(90deg, transparent, var(--gold), transparent);
    }
    .card-top-dot {
      position: absolute; top: -4px; left: 50%; transform: translateX(-50%);
      width: 7px; height: 7px; border-radius: 50%;
      background: var(--gold);
      box-shadow: 0 0 10px rgba(201,168,76,.7);
    }

    /* ── HEADER ── */
    .portal-badge {
      display: inline-flex; align-items: center; gap: 7px;
      background: var(--gold-dim);
      border: 1px solid rgba(201,168,76,.3);
      border-radius: 30px; padding: 5px 14px;
      font-size: 10.5px; font-weight: 700; letter-spacing: .12em;
      text-transform: uppercase; color: var(--gold-light);
      margin-bottom: 16px;
    }

    .form-title {
      font-family: 'Playfair Display', serif;
      font-size: 28px; font-weight: 800;
      color: #FAFAF5; line-height: 1.2; margin-bottom: 4px;
    }
    .form-sub { font-size: 13px; color: rgba(255,255,255,.3); margin-bottom: 30px; }

    /* ── INPUTS ── */
    .field-group { margin-bottom: 16px; }
    .field-label {
      display: block; font-size: 11.5px; font-weight: 600;
      color: rgba(255,255,255,.38); margin-bottom: 7px;
      letter-spacing: .06em; text-transform: uppercase;
    }
    .field-input {
      width: 100%; padding: 12px 16px;
      background: rgba(255,255,255,.05);
      border: 1.5px solid rgba(255,255,255,.09);
      border-radius: 10px;
      font-family: 'DM Sans', sans-serif;
      font-size: 14px; color: #FAFAF5;
      outline: none;
      transition: border-color .2s, background .2s, box-shadow .2s;
    }
    .field-input::placeholder { color: rgba(255,255,255,.18); }
    .field-input:focus {
      border-color: var(--gold);
      background: rgba(201,168,76,.06);
      box-shadow: 0 0 0 3px rgba(201,168,76,.12);
    }
    .pw-wrap { position: relative; }
    .pw-toggle {
      position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
      background: none; border: none; cursor: pointer;
      color: rgba(255,255,255,.25); transition: color .2s; padding: 4px;
    }
    .pw-toggle:hover { color: var(--gold); }

    input:-webkit-autofill, input:-webkit-autofill:focus {
      -webkit-box-shadow: 0 0 0 40px #0D1322 inset !important;
      -webkit-text-fill-color: #FAFAF5 !important;
    }

    /* ── SUBMIT BUTTON ── */
    .btn-submit {
      width: 100%; padding: 13px;
      background: linear-gradient(135deg, #8B6914 0%, var(--gold) 50%, #B8900E 100%);
      color: #1a0e00; border: none; border-radius: 12px;
      font-family: 'DM Sans', sans-serif;
      font-size: 14px; font-weight: 800;
      cursor: pointer; letter-spacing: .04em;
      display: flex; align-items: center; justify-content: center; gap: 8px;
      transition: transform .18s, box-shadow .18s, filter .18s;
      box-shadow: 0 4px 20px rgba(201,168,76,.3);
      margin-top: 6px; position: relative; overflow: hidden;
    }
    .btn-submit::before {
      content: '';
      position: absolute; top: 0; left: -60%; width: 40%; height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,.4), transparent);
      transform: skewX(-15deg);
      transition: left .5s ease;
    }
    .btn-submit:hover::before { left: 130%; }
    .btn-submit:hover {
      transform: translateY(-1px);
      box-shadow: 0 8px 28px rgba(201,168,76,.45);
      filter: brightness(1.06);
    }
    .btn-submit:active { transform: translateY(0); }
    .btn-submit i { transition: transform .2s; }
    .btn-submit:hover i { transform: translateX(3px); }

    /* ── SECURITY NOTICE ── */
    .security-note {
      display: flex; align-items: center; gap: 8px;
      margin-top: 18px; padding: 10px 14px;
      background: var(--gold-dim); border: 1px solid rgba(201,168,76,.2);
      border-radius: 10px;
      font-size: 11.5px; color: rgba(255,255,255,.35); line-height: 1.5;
    }
    .security-note i { color: var(--gold); font-size: 13px; flex-shrink: 0; opacity: .7; }

    /* ── BACK LINK ── */
    .back-link {
      display: flex; align-items: center; justify-content: center;
      gap: 6px; margin-top: 20px;
      font-size: 13px; color: rgba(255,255,255,.25);
      text-decoration: none; transition: color .2s;
    }
    .back-link:hover { color: var(--gold); }
    .back-link i { font-size: 11px; }

    /* ── LOGO ROW ── */
    .logo-row {
      display: flex; align-items: center; gap: 10px; margin-bottom: 24px;
    }
    .logo-row img { width: 32px; height: 32px; object-fit: contain; opacity: .75; }

    /* ── ERROR BOX ── */
    .error-box {
      background: rgba(139,0,0,.15); border: 1px solid rgba(139,0,0,.3);
      border-radius: 10px; padding: 10px 14px;
      font-size: 13px; color: #FCA5A5; margin-bottom: 16px;
      display: flex; align-items: center; gap: 8px;
    }
  </style>
</head>

<body>
  <canvas id="bgCanvas"></canvas>
  <div class="bg-stripes"></div>
  <div class="bg-glow bg-glow-1"></div>
  <div class="bg-glow bg-glow-2"></div>

  <div class="login-card">
    <div class="card-top-line"></div>
    <div class="card-top-dot"></div>

    <div class="logo-row">
      <img src="{{ asset('images/PUP.png') }}" alt="PUP">
      <img src="{{ asset('images/PUPT-DMS-Logo.png') }}" alt="DMS">
    </div>

    <div class="portal-badge">
      <i class="fa-solid fa-user-shield"></i>
      Admin Portal
    </div>
    <h1 class="form-title">Admin Sign In</h1>
    <p class="form-sub">System administration &amp; management access.</p>

    @if(session('error'))
    <div class="error-box">
      <i class="fa-solid fa-circle-exclamation"></i>
      {{ session('error') }}
    </div>
    @endif

    <form method="POST" action="{{ route('admin.login.submit') }}">
      @csrf

      <div class="field-group">
        <label class="field-label">Username</label>
        <input type="text" name="email" required placeholder="Enter your username" class="field-input">
      </div>

      <div class="field-group">
        <label class="field-label">Password</label>
        <div class="pw-wrap">
          <input type="password" id="adminPw" name="password" required placeholder="••••••••" class="field-input" style="padding-right:42px;">
          <button type="button" class="pw-toggle" onclick="togglePw('adminPw','adminEye')">
            <svg id="adminEye" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
          </button>
        </div>
      </div>

      <button type="submit" class="btn-submit">
        Access System <i class="fa-solid fa-arrow-right"></i>
      </button>
    </form>

    <div class="security-note">
      <i class="fa-solid fa-lock"></i>
      Restricted area. All access is monitored and logged.
    </div>

    <a href="/login" class="back-link">
      <i class="fa-solid fa-arrow-left"></i> Back to Patient Login
    </a>
  </div>

  <script>
    /* ── PARTICLES ── */
    (function() {
      const canvas = document.getElementById('bgCanvas');
      const ctx = canvas.getContext('2d');
      let W, H, pts = [];

      function resize() {
        W = canvas.width  = window.innerWidth;
        H = canvas.height = window.innerHeight;
        pts = Array.from({ length: 50 }, () => ({
          x: Math.random() * W, y: Math.random() * H,
          r: Math.random() * 1.0 + .3,
          vy: -(Math.random() * .18 + .04),
          a: Math.random() * .45 + .1,
        }));
      }

      function draw() {
        ctx.clearRect(0, 0, W, H);
        for (const p of pts) {
          ctx.globalAlpha = p.a * .4;
          ctx.fillStyle = '#C9A84C';
          ctx.beginPath(); ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2); ctx.fill();
          p.y += p.vy;
          if (p.y < 0) { p.y = H; p.x = Math.random() * W; }
        }
        ctx.globalAlpha = 1;
        requestAnimationFrame(draw);
      }

      window.addEventListener('resize', resize);
      resize(); draw();
    })();

    /* ── PASSWORD TOGGLE ── */
    function togglePw(inputId, iconId) {
      const inp = document.getElementById(inputId);
      const svg = document.getElementById(iconId);
      const showing = inp.type === 'text';
      inp.type = showing ? 'password' : 'text';
      svg.innerHTML = showing
        ? `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`
        : `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.042-3.368M6.223 6.223A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.956 9.956 0 01-4.132 5.411M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18"/>`;
    }
  </script>
</body>
</html>