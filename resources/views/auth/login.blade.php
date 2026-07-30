@extends('layouts.auth')

@section('styles')
@vite('resources/css/pages/auth/login.css')
@endsection

@section('content')

<nav class="login-nav">
  <div class="nav-brand">
    <span class="nav-brand-text">PUP Taguig Dental Clinic</span>
  </div>

  <ul class="nav-links">
    <li><a href="#home">Home</a></li>
    <li><a href="#about">About</a></li>
    <li><a href="#services">Services</a></li>
    <li><a href="#faq">FAQ</a></li>
    <li><a href="#team">Team</a></li>
    <li><a href="/auth/oidc/redirect" class="nav-cta">Login</a></li>
  </ul>

  <button class="auth-theme-toggle" id="themeToggle" aria-label="Toggle dark mode">
    <i class="fas fa-moon" id="themeIcon"></i>
  </button>

  <button class="nav-hamburger" id="hamburgerBtn" aria-label="Toggle menu" onclick="toggleMobileMenu()">
    <span></span>
    <span></span>
    <span></span>
  </button>
</nav>

<!-- Mobile Menu — compact dropdown panel -->
<div class="mobile-menu" id="mobileMenu">
  <a href="#home" onclick="closeMobileMenu()">Home</a>
  <a href="#about" onclick="closeMobileMenu()">About</a>
  <a href="#services" onclick="closeMobileMenu()">Services</a>
  <a href="#faq" onclick="closeMobileMenu()">FAQ</a>
  <a href="#team" onclick="closeMobileMenu()">Team</a>
  <div class="mob-divider"></div>
  <a href="/auth/oidc/redirect" class="nav-cta-mob">
    <i class="fa-solid fa-arrow-right-to-bracket" style="margin-right:6px;font-size:11px;"></i>Login with SSO
  </a>
  <a href="{{ route('backup.login') }}" class="nav-cta-mob" style="margin-top:10px;">
    <i class="fa-solid fa-key" style="margin-right:6px;font-size:11px;"></i>Login Locally
  </a>
</div>

<section class="hero" id="home">
  <div class="hero-content">

    <div class="hero-logos reveal">
      <img src="{{ asset('images/PUP.png') }}" class="hero-logo-img" alt="PUP Logo">
      <img src="{{ asset('images/PUPT-DMS-Logo.png') }}" class="hero-logo-img" alt="Clinic Logo">
    </div>
  </div>

  <h1 class="hero-title reveal reveal-d2">
    <span class="t1">PUP</span>
    <span class="t2">Taguig</span>
    <span class="t3">Dental Clinic</span>
  </h1>

  <p class="hero-desc reveal reveal-d3">
    Professional, accessible, and high-quality dental care exclusively for students, faculty, and staff of
    PUP Taguig. Manage your oral health seamlessly.
  </p>

  <ul class="hero-features reveal reveal-d4">
    <li><span class="feat-dot"><i class="fa-solid fa-check"></i></span> Secure online appointment booking</li>
    <li><span class="feat-dot"><i class="fa-solid fa-check"></i></span> Comprehensive digital patient records</li>
    <li><span class="feat-dot"><i class="fa-solid fa-check"></i></span> Professional campus dental services</li>
  </ul>

  <div id="login" class="reveal" style="animation-delay: 1.1s;">
    <div class="hero-login-actions">
      <a href="/auth/oidc/redirect" class="btn-sso">
        <div class="btn-sso-icon">
          <i class="fa-solid fa-arrow-right-to-bracket" style="font-size:12px;"></i>
        </div>
        Login with SSO
      </a>
      <a href="{{ route('backup.login') }}" class="btn-local">
        <div class="btn-local-icon">
          <i class="fa-solid fa-key" style="font-size:12px;"></i>
        </div>
        Login Locally
      </a>
    </div>
  </div>
</section>

<section id="about">
  <div class="section-wrap">
    <div class="about-grid reveal">
      <div class="about-left">
        <div class="section-label">
          <span class="section-label-line"></span>
          <span class="section-label-text">About the Clinic</span>
        </div>
        <h2 class="section-heading">Commitment to Oral Health</h2>
        <p class="about-statement">
          Providing <strong>free, professional dental care</strong> to the PUP Taguig community in a safe and
          welcoming clinical environment.
        </p>
        <p class="about-body">
          The PUP Taguig Dental Clinic was established to ensure every member of the university community has access
          to quality oral health services — without cost or barriers. Operated by a licensed campus dentist, the
          clinic handles everything from routine check-ups to comprehensive dental procedures.
        </p>
      </div>
      <div class="about-right">
        <div class="pillar-card reveal reveal-d1">
          <div class="pillar-icon"><i class="fa-solid fa-shield-heart"></i></div>
          <div>
            <div class="pillar-title">Free Dental Care</div>
            <div class="pillar-body">All standard dental services are provided at no cost to eligible PUP Taguig
              students, faculty, and staff.</div>
          </div>
        </div>
        <div class="pillar-card reveal reveal-d2">
          <div class="pillar-icon"><i class="fa-solid fa-calendar-check"></i></div>
          <div>
            <div class="pillar-title">Easy Scheduling</div>
            <div class="pillar-body">Book real-time slots online through the Dental Management System with instant
              confirmations.</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="dentist">
  <div class="section-wrap">
    <div class="dentist-inner reveal">
      <div class="dentist-left">
        <div class="section-label">
          <span class="section-label-line"></span>
          <span class="section-label-text">Our Dentist</span>
        </div>
        <h2 class="section-heading">Led by an Experienced Professional</h2>
        <p class="section-sub">
          The clinic is headed by <strong>Dr. Nelson P. Angeles</strong>, providing professional, safe, and reliable
          dental care to the university community. With a commitment to
          patient comfort and oral health excellence, the clinic supports consultations, treatment planning, and
          preventive care.
        </p>
        <div class="dentist-tags">
          <span class="dtag"><i class="fa-solid fa-circle-check"></i> Licensed Dentist</span>
          <span class="dtag"><i class="fa-solid fa-circle-check"></i> Campus Specialist</span>
        </div>
      </div>

      <div class="dentist-card">
        <div class="dentist-card-top">
          <div class="dentist-avatar">
            <img src="{{ asset('images/Nelson-Angeles.jpg') }}" alt="Dr. Nelson P. Angeles"
              onerror="this.src='https://ui-avatars.com/api/?name=Nelson+Angeles&background=660000&color=FFFFFF&size=88'">
          </div>
          <div class="dentist-name">Dr. Nelson P. Angeles</div>
          <div class="dentist-role">University Campus Dentist</div>
        </div>
        <div class="dentist-card-body">
          <div class="info-row"><i class="fa-solid fa-location-dot"></i> PUP Taguig Campus Dental Clinic</div>
          <div class="info-row"><i class="fa-regular fa-clock"></i> Mon – Fri, 8:00 AM – 5:00 PM</div>
          <div class="info-row"><i class="fa-solid fa-users"></i> Students, Alumni, Faculty & Staff</div>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="services">
  <div class="section-wrap">
    <div class="services-header reveal">
      <div>
        <div class="section-label">
          <span class="section-label-line"></span>
          <span class="section-label-text">Services</span>
        </div>
        <h2 class="section-heading">What We Offer</h2>
      </div>
      <p class="section-sub" style="max-width:360px; text-align:right;">Preventive and restorative dental procedures
        provided safely and efficiently.</p>
    </div>

    <div class="services-grid reveal">
      <div class="svc-card">
        <div class="svc-icon"><i class="fa-solid fa-hand-holding-medical"></i></div>
        <div class="svc-body">
          <h4>Oral Check-Up & Consultation</h4>
          <p>Routine oral examinations, dental consultations, and comprehensive oral health assessments.</p>
        </div>
      </div>
      <div class="svc-card">
        <div class="svc-icon"><i class="fa-solid fa-droplet"></i></div>
        <div class="svc-body">
          <h4>Dental Cleaning</h4>
          <p>Professional oral hygiene treatment to remove plaque, tartar, and surface stains securely.</p>
        </div>
      </div>
      <div class="svc-card">
        <div class="svc-icon"><i class="fa-solid fa-teeth"></i></div>
        <div class="svc-body">
          <h4>Restoration & Prosthesis</h4>
          <p>Fillings, crowns, inlays, and other repairs to effectively restore damaged or missing teeth.</p>
        </div>
      </div>
      <div class="svc-card">
        <div class="svc-icon"><i class="fa-solid fa-crutch"></i></div>
        <div class="svc-body">
          <h4>Dental Surgery</h4>
          <p>Tooth extractions, supernumerary removal, and other minor surgical dental procedures.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="faq" class="faq-section reveal">
  <div class="section-wrap">
    <div class="faq-header-row">
      <div>
        <div class="section-pill"><i class="fa-solid fa-circle-question"></i> FAQs</div>
        <h2 class="faq-section-title">Frequently Asked Questions</h2>
        <p class="faq-section-sub">Quick answers about the PUP Taguig Dental Management System.</p>
      </div>
    </div>

    @php
    $faqs = [
    [
    'q' => 'Who can avail of the dental services?',
    'a' => 'All students, faculty, and staff of the Polytechnic University of the Philippines – Taguig Campus
    are eligible for free dental services.',
    ],
    [
    'q' => 'How do I book an appointment?',
    'a' => 'You can book an appointment online through the Dental Management System portal. Simply log in, choose your
    preferred schedule, and confirm your booking.',
    ],
    [
    'q' => 'Will the dentist prescribe medications?',
    'a' => 'Yes. Depending on your dental condition, Dr. Angeles may prescribe antibiotics, pain relievers, or other
    necessary medications during your visit.',
    ],
    [
    'q' => 'Can I book an appointment anytime?',
    'a' => 'Appointments are subject to slot availability. Since the clinic operates with a single dentist and limited
    daily slots, early booking is highly recommended.',
    ],
    [
    'q' => 'How do I cancel or reschedule?',
    'a' => 'You can cancel or reschedule through the Dental Management System portal or by contacting the clinic
    directly — at least three (3) days before your scheduled appointment.',
    ],
    [
    'q' => 'What if the dentist is unavailable on my scheduled day?',
    'a' => 'If Dr. Angeles is unavailable, your confirmed appointment will be rescheduled to the next available slot
    and you will be notified accordingly.',
    ],
    [
    'q' => 'What services are available at the clinic?',
    'a' => 'The clinic provides oral check-ups, dental cleaning, fillings, extractions, dental surgery, restoration,
    prosthetics, and preventive care services.',
    ],
    [
    'q' => 'Are urgent dental cases given priority?',
    'a' => 'Yes, urgent cases may be prioritized depending on the daily schedule and the dentist\'s discretion.
    Contact the clinic directly for urgent concerns.',
    ],
    [
    'q' => 'Are there restrictions for certain treatments?',
    'a' => 'Some advanced procedures may not be available due to the clinic\'s resources and equipment. The dentist
    will guide you on available alternatives if needed.',
    ],
    [
    'q' => 'Are follow-up appointments required?',
    'a' => 'Some treatments require follow-up visits. Dr. Angeles will advise you if a follow-up is necessary after
    your initial treatment.',
    ],
    ];
    @endphp

    <div id="faqList">
      @foreach ($faqs as $i => $faq)
      <div class="faq-item-new reveal" style="transition-delay: {{ $i * 0.04 }}s;">
        <button class="faq-trigger" onclick="toggleFaq(this)" aria-expanded="false">
          <div class="faq-trigger-left">
            <span class="faq-num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
            <span class="faq-q">{{ $faq['q'] }}</span>
          </div>
          <span class="faq-chevron"><i class="fa-solid fa-chevron-down text-xs"></i></span>
        </button>
        <div class="faq-body">
          <div class="faq-body-inner">{{ $faq['a'] }}</div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

<section id="team">
  <div class="section-wrap">
    <div class="section-label reveal">
      <span class="section-label-line"></span>
      <span class="section-label-text">Development Team</span>
    </div>
    <h2 class="section-heading reveal">The System Developers</h2>

    @php
    $devs = [
    ['img' => 'Althea-Aragon.jpg', 'name' => 'Althea Mae Aragon', 'role' => 'Developer'],
    ['img' => 'Grace-Lim.jpg', 'name' => 'Grace Anne Lim', 'role' => 'Developer'],
    ['img' => 'Hoshea-Lopez.jpg', 'name' => 'Hoshea Shania Lopez', 'role' => 'Developer'],
    ['img' => 'Rain-Romero.jpg', 'name' => 'Dianna Rain Romero', 'role' => 'Developer'],
    ];
    @endphp

    <div class="team-grid">
      @foreach ($devs as $i => $dev)
      <div class="team-card reveal {{ $i > 0 ? 'reveal-d' . $i : '' }}">
        <div class="team-img">
          <img src="{{ asset('images/' . $dev['img']) }}" alt="{{ $dev['name'] }}"
            onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($dev['name']) }}&background=660000&color=FFFFFF&size=250'">
        </div>
        <div class="team-info">
          <div class="team-name">{{ $dev['name'] }}</div>
          <span class="team-badge">{{ $dev['role'] }}</span>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

<section class="closing">
  <div class="section-wrap">
    <div class="closing-inner reveal">
      <div class="closing-eyebrow">
        <span class="eyebrow-line" style="background:var(--gold);"></span>
        <span class="eyebrow-text" style="color:var(--gold);">PUP Taguig Dental Clinic</span>
        <span class="eyebrow-line" style="background:var(--gold);"></span>
      </div>
      <h2 class="closing-heading">Mula Sayo,<br><em>Para Sa Bayan.</em></h2>
      <p class="closing-desc">Developed to manage appointments and records more effectively, supporting accessible and
        efficient dental care for the entire PUP Taguig community.</p>
      <div class="hero-login-actions" style="margin-top:1.2rem;">
        <a href="/auth/oidc/redirect" class="btn-sso btn-sso-alt" style="margin:0;">
          <div class="btn-sso-icon"><i class="fa-solid fa-arrow-right-to-bracket" style="font-size:11px;"></i></div>
          Login with SSO
        </a>
        <a href="{{ route('backup.login') }}" class="btn-local">
          <div class="btn-local-icon"><i class="fa-solid fa-key" style="font-size:11px;"></i></div>
          Login Locally
        </a>
      </div>
    </div>
  </div>
</section>

<script>
  function toggleMobileMenu() {
    const menu = document.getElementById('mobileMenu');
    const btn = document.getElementById('hamburgerBtn');
    const open = menu.classList.toggle('open');
    btn.classList.toggle('open', open);
    document.body.style.overflow = open ? 'hidden' : '';
  }

  function closeMobileMenu() {
    document.getElementById('mobileMenu').classList.remove('open');
    document.getElementById('hamburgerBtn').classList.remove('open');
    document.body.style.overflow = '';
  }

  function toggleFaq(btn) {
    const item = btn.closest('.faq-item-new');
    const answer = item.querySelector('.faq-body');
    const isOpen = item.classList.contains('open');

    document.querySelectorAll('.faq-item-new.open').forEach(el => {
      el.classList.remove('open');
      el.querySelector('.faq-body').style.maxHeight = '0';
      el.querySelector('.faq-trigger').setAttribute('aria-expanded', 'false');
    });

    if (!isOpen) {
      item.classList.add('open');
      answer.style.maxHeight = answer.scrollHeight + 'px';
      btn.setAttribute('aria-expanded', 'true');
    }
  }

  const revealObs = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        e.target.classList.add('visible');
        revealObs.unobserve(e.target);
      }
    });
  }, { threshold: 0.08 });

  document.querySelectorAll('.reveal').forEach(el => revealObs.observe(el));
</script>
@endsection