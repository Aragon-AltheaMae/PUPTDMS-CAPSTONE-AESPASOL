@extends('layouts.auth')

@section('title', 'Backup Login | PUP Taguig Dental Clinic')

@section('styles')
@vite('resources/css/pages/auth/backup-login.css')
@endsection

@section('content')
<div class="backup-page">
  <section class="backup-shell">
    <div class="backup-panel">
      <div class="backup-brand">
        <div>
          <div class="backup-brand-top">
            <div class="backup-brand-logos">
              <img src="{{ asset('images/PUP.png') }}" alt="PUP Logo">
              <img src="{{ asset('images/PUPT-DMS-Logo.png') }}" alt="Clinic Logo">
            </div>
            <div class="backup-brand-name">PUP Taguig Dental Clinic</div>
          </div>

          <h1 class="backup-brand-title">Admin-only backup access.</h1>
          <p class="backup-brand-copy">
            This page is reserved for administrator fallback authentication when the primary IdP or SSO service is
            temporarily unavailable.
          </p>

          <div class="backup-points">
            <div class="backup-point">
              <i class="fa-solid fa-database"></i>
              <span>Uses the administrator credentials stored directly in your clinic system database.</span>
            </div>
            <div class="backup-point">
              <i class="fa-solid fa-shield-halved"></i>
              <span>Patient and dentist accounts are blocked here and must continue through the IdP.</span>
            </div>
            <div class="backup-point">
              <i class="fa-solid fa-key"></i>
              <span>Best used only after an admin local backup password has been injected or reset.</span>
            </div>
          </div>
        </div>

        <div class="backup-brand-footer">
          <span>Mula Sayo, Para Sa Bayan.</span>
          <span>Local fallback authentication</span>
        </div>
      </div>

      <div class="backup-form-wrap">
        <div class="backup-form-card">
          <a href="{{ route('login') }}" class="backup-back-link">
            <i class="fa-solid fa-arrow-left"></i>
            Back to landing page
          </a>

          <div class="backup-eyebrow">
            <i class="fa-solid fa-triangle-exclamation"></i>
            Backup Login
          </div>

          <h2 class="backup-form-title">Sign in with your local admin account.</h2>
          <p class="backup-form-copy">
            Use the admin email stored in the local database. Patients and dentists must sign in through the IdP,
            even when this backup page is available.
          </p>

          <form method="POST" action="{{ route('login.store') }}" class="backup-form">
            @csrf
            <input type="hidden" name="browser_name" id="browserNameInput">

            <div class="backup-field">
              <label for="email">Email Address</label>
              <input id="email" name="email" type="email" placeholder="name@pup.edu.ph" value="{{ old('email') }}"
                required>
            </div>

            <div class="backup-field">
              <label for="password">Local Password</label>
              <input id="password" name="password" type="password" placeholder="Enter your backup login password"
                required>
            </div>

            <button type="submit" class="backup-submit">Continue Locally</button>
          </form>

          <div class="backup-switch">
            <span>SSO is available again?</span>
            <a href="/auth/oidc/redirect" data-oidc-login-link>Return to SSO login</a>
          </div>

          <div class="backup-note">
            Local login will only work for admin accounts that already have a password saved in the local `users`
            table.
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<script>
  function detectBrowserName() {
    const userAgent = navigator.userAgent || '';

    if (navigator.brave) {
      return 'Brave';
    }

    if (userAgent.includes('Edg/')) {
      return 'Edge';
    }

    if (userAgent.includes('OPR/')) {
      return 'Opera';
    }

    if (userAgent.includes('Firefox/')) {
      return 'Firefox';
    }

    if (userAgent.includes('Chrome/')) {
      return 'Chrome';
    }

    if (userAgent.includes('Safari/')) {
      return 'Safari';
    }

    return 'Browser';
  }

  function applyBrowserHintToOidcLinks() {
    const browserName = detectBrowserName();

    document.querySelectorAll('[data-oidc-login-link]').forEach(link => {
      const url = new URL(link.getAttribute('href'), window.location.origin);
      url.searchParams.set('browser_name', browserName);
      link.setAttribute('href', url.pathname + url.search);
    });

    const input = document.getElementById('browserNameInput');

    if (input) {
      input.value = browserName;
    }
  }

  applyBrowserHintToOidcLinks();
</script>
@endsection
