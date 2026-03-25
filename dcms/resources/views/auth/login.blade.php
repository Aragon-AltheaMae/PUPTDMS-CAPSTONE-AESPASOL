<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>PUP Taguig — Dental Clinic</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Lora:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

    :root {
      --red-deep:   #8B0000;
      --red-mid:    #B01020;
      --red-bright: #CC1A2A;
      --gold:       #D4A017;
      --gold-light: #F0C040;
      --white:      #FFFFFF;
      --off-white:  #F5F0E8;
      --dark:       #1A0505;
    }

    html { scroll-behavior: smooth; }

    body {
      font-family: 'Montserrat', sans-serif;
      background: var(--dark);
      color: var(--white);
      min-height: 100vh;
      overflow-x: hidden;
    }

    /* ── ANIMATED BACKGROUND ── */
    .bg-wrap {
      position: fixed; inset: 0;
      z-index: 0;
      background: radial-gradient(ellipse 80% 70% at 70% 50%, #7a1a00 0%, #3d0000 40%, #1A0505 100%);
    }

    /* Grid lines like the reference */
    .bg-wrap::before {
      content: '';
      position: absolute; inset: 0;
      background-image:
        linear-gradient(rgba(212,160,23,0.07) 1px, transparent 1px),
        linear-gradient(90deg, rgba(212,160,23,0.07) 1px, transparent 1px);
      background-size: 60px 60px;
    }

    /* Animated floating particles */
    .particles { position: absolute; inset: 0; overflow: hidden; }
    .particle {
      position: absolute;
      border-radius: 50%;
      background: rgba(212,160,23,0.5);
      animation: drift linear infinite;
    }

    /* Decorative tooth shapes in BG (like reference) */
    .bg-tooth {
      position: absolute;
      opacity: 0.06;
      fill: var(--gold);
    }
    .bg-tooth-1 { top: 8%; left: 5%; width: 90px; animation: floatY 7s ease-in-out infinite; }
    .bg-tooth-2 { bottom: 10%; left: 3%; width: 120px; animation: floatY 9s ease-in-out 2s infinite; }
    .bg-tooth-3 { bottom: 20%; right: 4%; width: 80px; animation: floatY 6s ease-in-out 1s infinite; }

    @keyframes drift {
      0%   { transform: translateY(100vh) scale(0); opacity: 0; }
      10%  { opacity: 1; }
      90%  { opacity: 1; }
      100% { transform: translateY(-10vh) scale(1); opacity: 0; }
    }

    @keyframes floatY {
      0%, 100% { transform: translateY(0) rotate(0deg); }
      50%       { transform: translateY(-18px) rotate(5deg); }
    }

    /* ── NAV ── */
    nav {
      position: fixed; top: 0; left: 0; right: 0;
      display: flex; align-items: center; justify-content: space-between;
      padding: 1.2rem 5rem;
      background: rgba(26, 5, 5, 0.7);
      backdrop-filter: blur(14px);
      border-bottom: 1px solid rgba(212,160,23,0.2);
      z-index: 100;
      animation: fadeDown 0.8s ease both;
    }

    .nav-brand {
      display: flex; align-items: center; gap: 0.8rem;
    }

    .nav-logo-icon {
      width: 38px; height: 38px;
      background: var(--gold);
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.1rem;
    }

    .nav-brand-text {
      display: flex; flex-direction: column;
      line-height: 1.1;
    }

    .nav-brand-title {
      font-size: 0.95rem;
      font-weight: 800;
      letter-spacing: 0.08em;
      color: var(--white);
      text-transform: uppercase;
    }

    .nav-brand-sub {
      font-size: 0.6rem;
      font-weight: 600;
      letter-spacing: 0.2em;
      color: rgba(255,255,255,0.85);
      text-transform: uppercase;
    }

    .nav-links {
      display: flex; gap: 2.5rem; list-style: none;
    }

    .nav-links a {
      font-size: 0.75rem;
      font-weight: 600;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: rgba(255,255,255,0.65);
      text-decoration: none;
      transition: color 0.3s;
    }

    .nav-links a:hover { color: var(--gold-light); }

    .nav-cta {
      background: var(--gold);
      color: var(--dark) !important;
      padding: 0.5rem 1.2rem;
      border-radius: 40px;
      font-weight: 700 !important;
      transition: background 0.3s, transform 0.2s !important;
    }

    .nav-cta:hover {
      background: var(--gold-light) !important;
      transform: translateY(-1px);
    }

    /* ── HERO ── */
    .hero {
      position: relative; z-index: 1;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 8rem 5rem 5rem;
    }

    .hero-inner {
      max-width: 1100px;
      width: 100%;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 6rem;
      align-items: center;
    }

    /* LEFT */
    .hero-left { animation: fadeUp 1s ease 0.2s both; }

    .badge-pill {
      display: inline-flex; align-items: center; gap: 0.5rem;
      background: rgba(212,160,23,0.15);
      border: 1px solid rgba(212,160,23,0.35);
      border-radius: 40px;
      padding: 0.4rem 1rem;
      font-size: 0.7rem;
      font-weight: 700;
      letter-spacing: 0.15em;
      text-transform: uppercase;
      color: var(--gold-light);
      margin-bottom: 1.8rem;
    }

    .badge-dot {
      width: 6px; height: 6px;
      background: var(--gold-light);
      border-radius: 50%;
      animation: pulse 2s ease infinite;
    }

    @keyframes pulse {
      0%, 100% { opacity: 1; transform: scale(1); }
      50%       { opacity: 0.5; transform: scale(1.5); }
    }

    h1 {
      font-family: 'Montserrat', sans-serif;
      font-size: clamp(2.6rem, 4.5vw, 3.8rem);
      font-weight: 900;
      line-height: 1.08;
      text-transform: uppercase;
      letter-spacing: -0.01em;
      margin-bottom: 1.5rem;
    }

    h1 .line-gold {
      background: linear-gradient(90deg,
        #6B0000 0%,
        #FFD700 35%,
        #fff 50%,
        #FFD700 65%,
        #6B0000 100%);
      background-size: 250% auto;
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      animation: shine 16s linear infinite;
      display: block;
    }

    h1 .line-white {
      display: block;
      color: var(--white);
    }

    @keyframes shine {
      0%   { background-position: 200% center; }
      100% { background-position: -200% center; }
    }

    .subtitle-row {
      display: flex; align-items: center; gap: 0.75rem;
      margin-bottom: 1.8rem;
    }

    .subtitle-line { flex: 1; height: 1px; background: rgba(212,160,23,0.3); }

    .subtitle-text {
      font-size: 0.7rem;
      font-weight: 700;
      letter-spacing: 0.25em;
      text-transform: uppercase;
      color: rgba(255,255,255,0.9);
      white-space: nowrap;
    }

    .hero-desc {
      font-size: 0.95rem;
      line-height: 1.8;
      color: rgba(255,255,255,0.9);
      font-weight: 400;
      margin-bottom: 2.5rem;
      max-width: 440px;
    }

    /* Feature list */
    .features {
      list-style: none;
      display: flex; flex-direction: column; gap: 0.75rem;
      margin-bottom: 3rem;
    }

    .features li {
      display: flex; align-items: center; gap: 0.8rem;
      font-size: 0.85rem;
      color: rgba(255,255,255,0.95);
      font-weight: 500;
    }

    .feat-icon {
      width: 30px; height: 30px;
      background: rgba(212,160,23,0.15);
      border: 1px solid rgba(212,160,23,0.3);
      border-radius: 8px;
      display: flex; align-items: center; justify-content: center;
      font-size: 0.85rem;
      flex-shrink: 0;
    }

    /* CTA */
    .cta-row { display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap; }

    .btn-primary {
      display: inline-flex; align-items: center; gap: 0.8rem;
      background: linear-gradient(135deg, var(--red-bright), var(--red-deep));
      color: var(--white);
      border: none;
      padding: 1rem 2rem;
      font-family: 'Montserrat', sans-serif;
      font-size: 0.8rem;
      font-weight: 700;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      border-radius: 50px;
      cursor: pointer;
      text-decoration: none;
      box-shadow: 0 8px 30px rgba(176, 16, 32, 0.5);
      transition: transform 0.3s, box-shadow 0.3s;
      position: relative; overflow: hidden;
    }

    .btn-primary::before {
      content: '';
      position: absolute; inset: 0;
      background: linear-gradient(135deg, var(--gold), var(--red-bright));
      opacity: 0;
      transition: opacity 0.4s;
    }

    .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 14px 40px rgba(176,16,32,0.6); }
    .btn-primary:hover::before { opacity: 1; }

    .btn-primary span, .btn-primary svg { position: relative; z-index: 1; }

    .btn-arrow {
      width: 28px; height: 28px;
      background: rgba(255,255,255,0.2);
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      transition: transform 0.3s;
    }

    .btn-primary:hover .btn-arrow { transform: translateX(4px); }

    .btn-secondary {
      font-size: 0.8rem;
      font-weight: 600;
      color: rgba(255,255,255,0.85);
      display: flex; align-items: center; gap: 0.4rem;
      transition: color 0.3s;
    }

    .btn-secondary:hover { color: var(--gold-light); }

    /* RIGHT */
    .hero-right {
      position: relative;
      display: flex; align-items: center; justify-content: center;
      animation: fadeUp 1s ease 0.45s both;
    }

    /* Glow circle */
    .glow-ring {
      position: absolute;
      width: 380px; height: 380px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(176,16,32,0.4) 0%, transparent 70%);
      animation: glowPulse 4s ease-in-out infinite;
    }

    @keyframes glowPulse {
      0%, 100% { transform: scale(1); opacity: 0.7; }
      50%       { transform: scale(1.1); opacity: 1; }
    }

    /* Center card */
    .clinic-card {
      position: relative; z-index: 2;
      background: rgba(255,255,255,0.1);
      border: 1px solid rgba(255,255,255,0.2);
      border-radius: 2rem;
      padding: 2.5rem;
      width: 100%;
      max-width: 360px;
      backdrop-filter: blur(20px);
      text-align: center;
    }

    .card-logos {
      display: flex; align-items: center; justify-content: center; gap: 1rem;
      margin-bottom: 1.5rem;
    }

    .logo-circle {
      width: 72px; height: 72px;
      border-radius: 50%;
      border: 2px solid rgba(255,255,255,0.25);
      background: rgba(255,255,255,0.08);
      display: flex; align-items: center; justify-content: center;
      overflow: hidden;
      position: relative;
    }

    .logo-img-placeholder {
      width: 100%; height: 100%;
      display: flex; align-items: center; justify-content: center;
      background: radial-gradient(circle at 40% 35%, rgba(255,255,255,0.12), rgba(0,0,0,0.2));
    }

    .logo-sep { color: rgba(212,160,23,0.4); font-size: 1.2rem; }

    .card-title {
      font-family: 'Lora', serif;
      font-style: italic;
      font-size: 0.85rem;
      color: rgba(255,255,255,0.9);
      letter-spacing: 0.05em;
      padding-bottom: 1.2rem;
      margin-bottom: 1.2rem;
      border-bottom: 1px solid rgba(255,255,255,0.2);
    }

    .card-stats {
      display: grid; grid-template-columns: 1fr 1fr 1fr;
      gap: 0.5rem;
      padding: 1.2rem 0;
      border-top: 1px solid rgba(255,255,255,0.08);
      border-bottom: 1px solid rgba(255,255,255,0.08);
      margin-bottom: 1.5rem;
    }

    .stat-item { text-align: center; }

    .stat-num {
      font-size: 1.4rem;
      font-weight: 900;
      color: var(--gold);
      font-family: 'Montserrat', sans-serif;
    }

    .stat-label {
      font-size: 0.6rem;
      font-weight: 600;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: rgba(255,255,255,0.4);
      margin-top: 0.2rem;
    }

    .card-motto {
      margin-top: 1.2rem;
      font-family: 'Lora', serif;
      font-style: italic;
      font-size: 0.95rem;
      font-weight: 600;
      color: var(--gold-light);
      letter-spacing: 0.03em;
      border-top: 1px solid rgba(255,255,255,0.15);
      padding-top: 1rem;
    }
      font-size: 0.8rem;
      color: rgba(255,255,255,0.9);
      line-height: 1.6;
    }

    /* Floating small badges */
    .float-badge {
      position: absolute;
      background: rgba(26,5,5,0.85);
      border: 1px solid rgba(212,160,23,0.3);
      border-radius: 12px;
      padding: 0.6rem 0.9rem;
      display: flex; align-items: center; gap: 0.5rem;
      backdrop-filter: blur(10px);
      z-index: 3;
      animation: floatY 5s ease-in-out infinite;
    }

    .float-badge-icon { font-size: 1rem; }
    .float-badge-text { font-size: 0.7rem; font-weight: 600; color: rgba(255,255,255,1); white-space: nowrap; }

    .fb1 { top: -5%; right: -10%; animation-delay: 0s; }
    .fb2 { bottom: 5%; left: -12%; animation-delay: 2s; }

    /* ── FOOTER ── */
    footer {
      position: relative; z-index: 1;
      text-align: center;
      padding: 2rem;
      border-top: 1px solid rgba(212,160,23,0.1);
    }

    .footer-inner {
      display: flex; align-items: center; justify-content: center; gap: 0.6rem;
      font-size: 0.72rem;
      color: rgba(255,255,255,0.7);
      margin-bottom: 0.5rem;
    }

    .footer-sep { color: rgba(212,160,23,0.4); }

    .footer-links { display: flex; gap: 1.5rem; justify-content: center; }
    .footer-links a {
      font-size: 0.68rem;
      color: var(--gold);
      text-decoration: none;
      letter-spacing: 0.05em;
      opacity: 0.7;
      transition: opacity 0.3s;
    }
    .footer-links a:hover { opacity: 1; }

    /* ── ANIMATIONS ── */
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(28px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeDown {
      from { opacity: 0; transform: translateY(-20px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    /* ── RESPONSIVE ── */
    @media (max-width: 880px) {
      nav { padding: 1rem 1.5rem; }
      .nav-links { display: none; }

      .hero { padding: 7rem 1.5rem 4rem; }
      .hero-inner { grid-template-columns: 1fr; gap: 3rem; text-align: center; }
      .hero-desc { margin: 0 auto 2.5rem; }
      .features li { justify-content: center; }
      .cta-row { justify-content: center; }
      .hero-right { display: none; }
    }
  </style>
</head>
<body>

  <!-- BG -->
  <div class="bg-wrap">
    <div class="particles" id="particles"></div>

    <!-- Tooth decorations -->
    <svg class="bg-tooth bg-tooth-1" viewBox="0 0 100 120">
      <path d="M50 5C35 5 20 15 18 32C16 45 20 55 22 65C24 80 22 105 32 110C40 114 42 98 46 88C48 82 49 78 50 78C51 78 52 82 54 88C58 98 60 114 68 110C78 105 76 80 78 65C80 55 84 45 82 32C80 15 65 5 50 5Z" fill="currentColor"/>
    </svg>
    <svg class="bg-tooth bg-tooth-2" viewBox="0 0 100 120">
      <path d="M50 5C35 5 20 15 18 32C16 45 20 55 22 65C24 80 22 105 32 110C40 114 42 98 46 88C48 82 49 78 50 78C51 78 52 82 54 88C58 98 60 114 68 110C78 105 76 80 78 65C80 55 84 45 82 32C80 15 65 5 50 5Z" fill="currentColor"/>
    </svg>
    <svg class="bg-tooth bg-tooth-3" viewBox="0 0 100 120">
      <path d="M50 5C35 5 20 15 18 32C16 45 20 55 22 65C24 80 22 105 32 110C40 114 42 98 46 88C48 82 49 78 50 78C51 78 52 82 54 88C58 98 60 114 68 110C78 105 76 80 78 65C80 55 84 45 82 32C80 15 65 5 50 5Z" fill="currentColor"/>
    </svg>
  </div>

  <!-- NAV -->
  <nav>
    <div class="nav-brand">
      <span class="nav-brand-title">PUP Taguig Dental Clinic</span>
    </div>

  </nav>

  <!-- HERO -->
  <section class="hero">
    <div class="hero-inner">

      <!-- LEFT -->
      <div class="hero-left">
        <h1>
          <span class="line-gold">PUP Taguig</span>
          <span class="line-white">Dental Clinic</span>
        </h1>


        <p class="hero-desc">
          Quality dental care for PUP Taguig students, faculty, and staff. Book appointments online, access your records, and take charge of your oral health — anytime, anywhere.
        </p>

        <ul class="features">
          <li>
            <span class="feat-icon">🗓</span>
            Book appointments online, anytime
          </li>
          <li>
            <span class="feat-icon">📋</span>
            View your dental records &amp; history
          </li>
          <li>
            <span class="feat-icon">🔒</span>
            Secure &amp; private patient portal
          </li>
        </ul>

        <div class="cta-row">
          <a href="/auth/oidc/redirect" class="btn-primary">
    <span>Login with SSO</span>
    <span class="btn-arrow">
      <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
        <path d="M2 6h8M6 2l4 4-4 4" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </span>
</a>

        </div>
      </div>

      <!-- RIGHT -->
      <div class="hero-right">
        <div class="glow-ring"></div>

<div class="clinic-card">
          <div class="card-logos">
            <div class="logo-circle">
              <div class="logo-img-placeholder">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                  <circle cx="16" cy="16" r="15" stroke="rgba(255,255,255,0.3)" stroke-width="1.5" stroke-dasharray="3 2"/>
                  <path d="M16 8l1.5 4.5H22l-3.7 2.7 1.4 4.4L16 17l-3.7 2.6 1.4-4.4L10 12.5h4.5z" fill="rgba(255,255,255,0.25)"/>
                  <text x="16" y="28" text-anchor="middle" font-size="6" fill="rgba(255,255,255,0.4)" font-family="Montserrat,sans-serif" font-weight="600">PUP LOGO</text>
                </svg>
              </div>
            </div>
            <span class="logo-sep">+</span>
            <div class="logo-circle">
              <div class="logo-img-placeholder">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                  <circle cx="16" cy="16" r="15" stroke="rgba(255,255,255,0.3)" stroke-width="1.5" stroke-dasharray="3 2"/>
                  <path d="M16 7c-3 0-6 2-6.4 5.4-.3 2.6.8 4.8 1.2 7 .4 2.4-.1 6 2 6.8 1.6.6 2-1.6 2.8-3.4.3-.8.4-1.4.4-1.4s.1.6.4 1.4c.8 1.8 1.2 4 2.8 3.4 2.1-.8 1.6-4.4 2-6.8.4-2.2 1.5-4.4 1.2-7C22 9 19 7 16 7z" fill="rgba(255,255,255,0.25)"/>
                  <text x="16" y="29" text-anchor="middle" font-size="5.5" fill="rgba(255,255,255,0.4)" font-family="Montserrat,sans-serif" font-weight="600">CLINIC</text>
                </svg>
              </div>
            </div>
          </div>

          <div class="card-title">Serving the PUP Community</div>

          <p class="card-tagline">
            Your smile is our priority.<br>
            Accessible, compassionate dental care<br>right on campus.
          </p>
          <div class="card-motto">"Mula Sayo, Para Sa Bayan."</div>
        </div>
      </div>

    </div>
  </section>

  <!-- FOOTER -->
  <footer>
    <div class="footer-inner">
      <span>© 1998–2026</span>
      <span class="footer-sep">•</span>
      <strong style="color:rgba(255,255,255,0.55)">Polytechnic University of the Philippines</strong>
      <span class="footer-sep">🦷</span>
      <span>Taguig Campus</span>
    </div>
    <div class="footer-links">
      <a href="#">Terms of Use</a>
      <a href="#">Privacy Statement</a>
    </div>
  </footer>

  <script>
    // Generate floating particles
    const container = document.getElementById('particles');
    for (let i = 0; i < 30; i++) {
      const p = document.createElement('div');
      p.className = 'particle';
      const size = Math.random() * 4 + 2;
      p.style.cssText = `
        width:${size}px; height:${size}px;
        left:${Math.random()*100}%;
        animation-duration:${8 + Math.random()*12}s;
        animation-delay:${Math.random()*10}s;
      `;
      container.appendChild(p);
    }
  </script>
</body>
</html>
