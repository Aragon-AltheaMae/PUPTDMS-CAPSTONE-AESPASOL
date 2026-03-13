<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Patient Registration</title>
  <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">

  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      margin: 0;
      padding: 0;
      min-height: 100vh;
      background: linear-gradient(135deg, #8B0000 0%, #660000 50%, #C9A84C 100%);
      overflow-x: hidden;
    }

    /* ── STARS ── */
    #stars {
      position: fixed;
      inset: 0;
      z-index: 1;
      pointer-events: none;
    }

    /* ── SHINE TEXT ── */
    .shine-text {
      background: linear-gradient(90deg, #6B0000, #FFD700, #fff, #FFD700, #6B0000);
      background-size: 250% auto;
      background-clip: text;
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      animation: shine 4s linear infinite;
    }

    @keyframes shine {
      0% {
        background-position: 250% center;
      }

      100% {
        background-position: -250% center;
      }
    }

    /* ── FADE UP ── */
    @keyframes fadeUp {
      0% {
        opacity: 0;
        transform: translateY(16px);
      }

      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .fade-up {
      animation: fadeUp 0.6s ease-out forwards;
    }

    /* ── OUTER WRAPPER ── */
    .page-wrapper {
      position: relative;
      z-index: 10;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 16px;
    }

    /* ── CARD ── */
    .card {
      width: 100%;
      max-width: 1100px;
      background: white;
      border-radius: 24px;
      overflow: hidden;
      box-shadow: 0 32px 80px rgba(0, 0, 0, 0.35);
      display: flex;
      flex-direction: column;
    }

    /* Desktop: side by side */
    @media (min-width: 1024px) {
      .card {
        flex-direction: row;
        min-height: 680px;
        max-height: 92vh;
      }
    }

    /* ── LEFT PHOTO PANEL ── */
    .photo-panel {
      position: relative;
      overflow: hidden;
      flex-shrink: 0;
    }

    /* Mobile: banner */
    .photo-panel {
      height: 140px;
    }

    @media (min-width: 640px) {
      .photo-panel {
        height: 180px;
      }
    }

    @media (min-width: 1024px) {
      .photo-panel {
        height: auto;
        width: 42%;
        min-height: 680px;
      }
    }

    .photo-panel img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      object-position: center;
    }

    .photo-overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(to bottom, rgba(139, 0, 0, 0.3), rgba(60, 0, 0, 0.6));
    }

    /* Mobile: show title in photo panel */
    .photo-mobile-title {
      position: absolute;
      bottom: 16px;
      left: 20px;
      right: 20px;
      display: block;
    }

    @media (min-width: 1024px) {
      .photo-mobile-title {
        display: none;
      }
    }

    /* ── RIGHT FORM PANEL ── */
    .form-panel {
      flex: 1;
      padding: 24px 20px 28px;
      overflow-y: auto;
      display: flex;
      flex-direction: column;
    }

    @media (min-width: 640px) {
      .form-panel {
        padding: 28px 32px 36px;
      }
    }

    @media (min-width: 1024px) {
      .form-panel {
        padding: 36px 44px 44px;
        justify-content: center;
      }
    }

    /* Desktop title (hidden on mobile) */
    .desktop-title {
      display: none;
    }

    @media (min-width: 1024px) {
      .desktop-title {
        display: block;
        margin-bottom: 6px;
      }
    }

    /* ── FORM GRID ── */
    .form-grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: 14px;
    }

    @media (min-width: 480px) {
      .form-grid {
        grid-template-columns: 1fr 1fr;
        gap: 14px 16px;
      }
    }

    .col-span-2 {
      grid-column: span 2;
    }

    .col-span-1 {
      grid-column: span 1;
    }

    @media (max-width: 479px) {

      .col-span-2,
      .col-span-1 {
        grid-column: span 1;
      }
    }

    /* ── INPUT STYLES ── */
    .field-label {
      display: block;
      font-size: 11.5px;
      font-weight: 600;
      color: #4B4B4B;
      margin-bottom: 5px;
      letter-spacing: 0.01em;
    }

    .field-input {
      width: 100%;
      padding: 9px 14px;
      border-radius: 10px;
      background: #F7F5F5;
      border: 1.5px solid #E5E0E0;
      font-size: 13px;
      color: #333;
      font-family: 'Inter', sans-serif;
      transition: border-color 0.2s, box-shadow 0.2s;
      outline: none;
      appearance: none;
      -webkit-appearance: none;
    }

    .field-input:focus {
      border-color: #8B0000;
      box-shadow: 0 0 0 3px rgba(139, 0, 0, 0.08);
      background: #fff;
    }

    .field-input.border-red-500 {
      border-color: #EF4444;
    }

    .field-input.border-green-500 {
      border-color: #22C55E;
    }

    .field-input::placeholder {
      color: #BCBCBC;
    }

    /* date + select fix on mobile */
    input[type="date"].field-input,
    select.field-input {
      padding: 9px 10px;
      line-height: 1.4;
    }

    /* ── PASSWORD WRAPPER ── */
    .pass-wrap {
      position: relative;
    }

    .pass-toggle {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      cursor: pointer;
      color: #9CA3AF;
      padding: 0;
      display: flex;
      align-items: center;
    }

    .pass-toggle:hover {
      color: #555;
    }

    .pass-wrap .field-input {
      padding-right: 40px;
    }

    /* ── PASSWORD RULES ── */
    #passwordRules {
      margin-top: 8px;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 4px 12px;
      font-size: 11px;
    }

    #passwordRules li {
      display: flex;
      align-items: center;
      gap: 5px;
      color: #9CA3AF;
      list-style: none;
      padding: 0;
      margin: 0;
    }

    #passwordRules li.text-green-600 {
      color: #16A34A;
    }

    .fade-out {
      opacity: 0;
      transition: opacity 0.4s ease;
    }

    /* ── REGISTER BUTTON ── */
    .register-btn {
      width: 100%;
      padding: 11px;
      border-radius: 12px;
      background: linear-gradient(135deg, #8B0000, #A52A2A);
      color: white;
      font-weight: 700;
      font-size: 14px;
      font-family: 'Inter', sans-serif;
      border: none;
      cursor: pointer;
      transition: all 0.25s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      box-shadow: 0 4px 16px rgba(139, 0, 0, 0.3);
      position: relative;
      overflow: hidden;
    }

    .register-btn:hover {
      background: linear-gradient(135deg, #A52A2A, #8B0000);
      box-shadow: 0 6px 22px rgba(139, 0, 0, 0.42);
      transform: translateY(-1px);
    }

    .register-btn:active {
      transform: translateY(0);
    }

    /* ── AUTOFILL FIX ── */
    input:-webkit-autofill,
    input:-webkit-autofill:hover,
    input:-webkit-autofill:focus {
      -webkit-box-shadow: 0 0 0 30px #F7F5F5 inset !important;
      -webkit-text-fill-color: #333333 !important;
    }

    /* ── TOAST ── */
    #toastContainer {
      position: fixed;
      top: 16px;
      right: 16px;
      z-index: 99999;
      display: flex;
      flex-direction: column;
      gap: 10px;
      pointer-events: none;
    }

    @media (max-width: 640px) {
      #toastContainer {
        top: 12px;
        left: 12px;
        right: 12px;
      }
    }

    .toast-item {
      background: white;
      border-radius: 14px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.18);
      padding: 13px 16px 13px 14px;
      display: flex;
      align-items: center;
      gap: 11px;
      opacity: 0;
      transform: translateX(340px);
      transition: all 0.35s cubic-bezier(0.68, -0.55, 0.265, 1.55);
      position: relative;
      overflow: hidden;
      pointer-events: all;
      min-width: 280px;
      max-width: 380px;
    }

    @media (max-width: 640px) {
      .toast-item {
        min-width: unset;
        max-width: unset;
        width: 100%;
        transform: translateY(-80px);
      }
    }

    .toast-item::before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      bottom: 0;
      width: 4px;
    }

    .toast-item.toast-error::before {
      background: #8B0000;
    }

    .toast-item.toast-success::before {
      background: #15803d;
    }

    .toast-item.show {
      opacity: 1;
      transform: translateX(0);
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
      color: rgba(255, 255, 255, .75);
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
      background: linear-gradient(90deg,
          transparent,
          rgba(201, 168, 76, .6),
          transparent);
    }

    .footer-divider i {
      font-size: 11px;
      color: rgba(255, 215, 0, .65);
    }

    /* Text */
    .footer-text {
      font-weight: 500;
    }

    .footer-year {
      color: rgba(255, 255, 255, .45);
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
      color: rgba(255, 215, 0, .75);
      text-decoration: none;
      transition: opacity .2s;
    }

    .footer-links a:hover {
      opacity: .7;
    }

    .footer-links .dot {
      width: 4px;
      height: 4px;
      background: rgba(255, 215, 0, .45);
      border-radius: 50%;
    }

    @media (max-width: 640px) {
      .toast-item.show {
        transform: translateY(0);
      }
    }

    .toast-item.hide {
      opacity: 0;
      transform: translateX(340px);
    }

    @media (max-width: 640px) {
      .toast-item.hide {
        transform: translateY(-80px);
      }
    }

    .toast-icon-wrap {
      width: 34px;
      height: 34px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      font-size: 16px;
    }

    .toast-error .toast-icon-wrap {
      background: rgba(139, 0, 0, .08);
      color: #8B0000;
    }

    .toast-success .toast-icon-wrap {
      background: rgba(21, 128, 61, .08);
      color: #15803d;
    }

    .toast-body {
      flex: 1;
      min-width: 0;
    }

    .toast-title {
      font-size: 12.5px;
      font-weight: 700;
      color: #1A0A0A;
    }

    .toast-msg {
      font-size: 11.5px;
      color: #888;
      margin-top: 2px;
      line-height: 1.4;
    }

    .toast-close {
      background: none;
      border: none;
      cursor: pointer;
      color: #CCC;
      font-size: 12px;
      flex-shrink: 0;
      padding: 2px 4px;
      transition: color .2s;
    }

    .toast-close:hover {
      color: #888;
    }

    /* ── ERROR TEXT ── */
    .field-error {
      font-size: 11px;
      color: #DC2626;
      margin-top: 3px;
      display: none;
    }

    .field-error.visible {
      display: block;
    }
  </style>
</head>

<body>
  <canvas id="stars"></canvas>
  <div id="toastContainer"></div>

  <main>
    <div class="page-wrapper fade-up">
      <div class="card">

        <!-- LEFT: Photo Panel -->
        <div class="photo-panel">
          <img src="/images/PUP TAGUIG CAMPUS.jpg" alt="PUP Taguig Campus">
          <div class="photo-overlay"></div>
          <!-- Title shown on mobile inside photo -->
          <div class="photo-mobile-title">
            <p class="text-white/70 text-[10px] font-bold tracking-[.15em] uppercase mb-0.5">Patient Portal</p>
            <h1 class="text-white text-2xl font-extrabold leading-tight shine-text">Create Account</h1>
          </div>
        </div>

        <!-- RIGHT: Form Panel -->
        <div class="form-panel">

          <!-- Desktop-only title -->
          <div class="desktop-title">
            <p class="text-[10px] font-bold tracking-[.15em] uppercase text-[#8B0000]/60 mb-1">Patient Portal</p>
            <h1 class="text-3xl font-extrabold shine-text leading-tight mb-1">Create Account</h1>
            <p class="text-xs text-gray-400 mb-5">Register a new patient account to get started</p>
          </div>

          <!-- Mobile subtitle (below photo, above form) -->
          <div class="lg:hidden mb-4 mt-1">
            <p class="text-xs text-gray-400">Fill in the details below to create your account</p>
          </div>

          <form method="POST" action="/register" id="registerForm">
            @csrf

            <div class="form-grid">

              <!-- Full Name -->
              <div class="col-span-2">
                <label class="field-label">Full Name</label>
                <input id="name" name="name" value="{{ old('name') }}" placeholder="Enter your full name" required
                  class="field-input">
                <p id="name-error" class="field-error"></p>
              </div>

              <!-- Email -->
              <div class="col-span-1">
                <label class="field-label">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email"
                  required class="field-input">
                <p id="email-error" class="field-error"></p>
              </div>

              <!-- Phone -->
              <div class="col-span-1">
                <label class="field-label">Phone</label>
                <input id="phone" name="phone" value="{{ old('phone') }}" placeholder="Enter phone number"
                  class="field-input">
                <p id="phone-error" class="field-error"></p>
              </div>

              <!-- Birthdate -->
              <div class="col-span-1">
                <label class="field-label">Birthdate</label>
                <input id="birthdate" type="date" name="birthdate" value="{{ old('birthdate') }}" required
                  class="field-input">
                <p id="birthdate-error" class="field-error"></p>
              </div>

              <!-- Gender -->
              <div class="col-span-1">
                <label class="field-label">Gender</label>
                <select id="gender" name="gender" required class="field-input">
                  <option value="">Select Gender</option>
                  <option value="Male" {{ old('gender')=='Male' ? 'selected' : '' }}>Male</option>
                  <option value="Female" {{ old('gender')=='Female' ? 'selected' : '' }}>Female</option>
                </select>
                <p id="gender-error" class="field-error"></p>
              </div>

              <!-- Password -->
              <div class="col-span-2">
                <label class="field-label">Password</label>
                <div class="pass-wrap">
                  <input id="password" type="password" name="password" placeholder="Enter your password" required
                    class="field-input">
                  <button type="button" class="pass-toggle" onclick="togglePassword('password','eyePassword')">
                    <svg id="eyePassword" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none"
                      viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                  </button>
                </div>
                <ul id="passwordRules">
                  <li id="rule-length"><i class="fa-solid fa-circle-xmark text-[10px]"></i> At least 8 characters</li>
                  <li id="rule-letter"><i class="fa-solid fa-circle-xmark text-[10px]"></i> At least one letter</li>
                  <li id="rule-number"><i class="fa-solid fa-circle-xmark text-[10px]"></i> At least one number</li>
                  <li id="rule-special"><i class="fa-solid fa-circle-xmark text-[10px]"></i> One special symbol</li>
                </ul>
              </div>

              <!-- Confirm Password -->
              <div class="col-span-2">
                <label class="field-label">Confirm Password</label>
                <div class="pass-wrap">
                  <input id="confirmPassword" type="password" name="password_confirmation"
                    placeholder="Re-enter your password" required class="field-input">
                  <button type="button" class="pass-toggle"
                    onclick="togglePassword('confirmPassword','eyeConfirmPassword')">
                    <svg id="eyeConfirmPassword" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none"
                      viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                  </button>
                </div>
                <p id="passwordMismatch" class="field-error"><i class="fa-solid fa-circle-xmark"></i> Passwords do not
                  match</p>
                <p id="passwordMatch" class="field-error" style="color:#16A34A;display:none;"><i
                    class="fa-solid fa-circle-check"></i> Passwords match</p>
              </div>

              <!-- Submit -->
              <div class="col-span-2" style="margin-top:4px;">
                <button type="submit" class="register-btn">
                  <span>Register</span>
                  <i class="fa-solid fa-user-plus text-sm"></i>
                </button>
              </div>

              <!-- Login Link -->
              <p class="col-span-2 text-center text-xs text-gray-400" style="margin-top:2px;">
                Already have an account?
                <a href="/login" class="text-[#8B0000] font-bold hover:underline">Login here</a>
              </p>

            </div>
          </form>

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

  @if($errors->any())
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      @foreach($errors -> all() as $error)
      showToast('Validation Error', "{{ $error }}", 'error');
      @endforeach
    });
  </script>
  @endif

  @if(session('error'))
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      showToast('Error', "{{ session('error') }}", 'error');
    });
  </script>
  @endif

  <script>
    /* ══════════════════════════
       TOAST
    ══════════════════════════ */
    function showToast(title, message, type) {
      type = type || 'error';
      var container = document.getElementById('toastContainer');
      var t = document.createElement('div');
      t.className = 'toast-item toast-' + type;

      var icon = type === 'success'
        ? '<i class="fa-solid fa-circle-check"></i>'
        : '<i class="fa-solid fa-circle-exclamation"></i>';

      t.innerHTML =
        '<div class="toast-icon-wrap">' + icon + '</div>' +
        '<div class="toast-body">' +
        '<div class="toast-title">' + title + '</div>' +
        '<div class="toast-msg">' + message + '</div>' +
        '</div>' +
        '<button class="toast-close" onclick="dismissToast(this.parentElement)">' +
        '<i class="fa-solid fa-xmark"></i>' +
        '</button>';

      container.appendChild(t);
      requestAnimationFrame(function () { requestAnimationFrame(function () { t.classList.add('show'); }); });

      setTimeout(function () {
        dismissToast(t);
      }, type === 'success' ? 4000 : 5000);
    }

    function dismissToast(t) {
      t.classList.remove('show');
      t.classList.add('hide');
      setTimeout(function () { if (t.parentElement) t.remove(); }, 400);
    }

    /* ══════════════════════════
       VALIDATION HELPERS
    ══════════════════════════ */
    function setError(inputEl, errorId, msg) {
      var e = document.getElementById(errorId);
      e.textContent = msg;
      e.classList.add('visible');
      inputEl.classList.add('border-red-500');
      inputEl.classList.remove('border-green-500');
    }

    function clearError(inputEl, errorId) {
      var e = document.getElementById(errorId);
      e.classList.remove('visible');
      inputEl.classList.remove('border-red-500');
      inputEl.classList.add('border-green-500');
    }

    var nameInput = document.getElementById('name');
    var emailInput = document.getElementById('email');
    var phoneInput = document.getElementById('phone');
    var birthdateInput = document.getElementById('birthdate');
    var genderInput = document.getElementById('gender');
    var password = document.getElementById('password');
    var confirmPassword = document.getElementById('confirmPassword');

    function validateName() {
      var v = nameInput.value.trim();
      if (v.length < 2) { setError(nameInput, 'name-error', 'Name must be at least 2 characters'); return false; }
      if (v.length > 255) { setError(nameInput, 'name-error', 'Name must not exceed 255 characters'); return false; }
      clearError(nameInput, 'name-error'); return true;
    }

    function validateEmail() {
      var pat = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailInput.value) { setError(emailInput, 'email-error', 'Email is required'); return false; }
      if (!pat.test(emailInput.value)) { setError(emailInput, 'email-error', 'Please enter a valid email'); return false; }
      clearError(emailInput, 'email-error'); return true;
    }

    function validatePhone() {
      var pat = /^[\d\s\-\+\(\)]+$/;
      if (phoneInput.value && !pat.test(phoneInput.value)) { setError(phoneInput, 'phone-error', 'Invalid phone number'); return false; }
      if (phoneInput.value && phoneInput.value.length > 20) { setError(phoneInput, 'phone-error', 'Phone too long'); return false; }
      clearError(phoneInput, 'phone-error'); return true;
    }

    function validateBirthdate() {
      var sel = new Date(birthdateInput.value);
      var today = new Date();
      var min = new Date(); min.setFullYear(today.getFullYear() - 120);
      if (!birthdateInput.value) { setError(birthdateInput, 'birthdate-error', 'Birthdate is required'); return false; }
      if (sel > today) { setError(birthdateInput, 'birthdate-error', 'Cannot be in the future'); return false; }
      if (sel < min) { setError(birthdateInput, 'birthdate-error', 'Please enter a valid date'); return false; }
      clearError(birthdateInput, 'birthdate-error'); return true;
    }

    function validateGender() {
      if (!genderInput.value) { setError(genderInput, 'gender-error', 'Please select a gender'); return false; }
      clearError(genderInput, 'gender-error'); return true;
    }

    function validatePasswordRules() {
      var v = password.value;
      return v.length >= 8 && /[A-Za-z]/.test(v) && /[0-9]/.test(v) && /[^A-Za-z0-9]/.test(v);
    }

    function validatePasswordMatch() {
      return confirmPassword.value && confirmPassword.value === password.value;
    }

    nameInput.addEventListener('blur', validateName);
    nameInput.addEventListener('input', validateName);
    emailInput.addEventListener('blur', validateEmail);
    emailInput.addEventListener('input', validateEmail);
    phoneInput.addEventListener('blur', validatePhone);
    phoneInput.addEventListener('input', validatePhone);
    birthdateInput.addEventListener('blur', validateBirthdate);
    birthdateInput.addEventListener('change', validateBirthdate);
    genderInput.addEventListener('change', validateGender);

    document.getElementById('registerForm').addEventListener('submit', function (e) {
      var nameOk = validateName();
      var emailOk = validateEmail();
      var phoneOk = validatePhone();
      var birthOk = validateBirthdate();
      var genderOk = validateGender();
      var rulesOk = validatePasswordRules();
      var matchOk = validatePasswordMatch();

      if (!rulesOk) showToast('Password Error', 'Password does not meet the requirements.', 'error');
      if (!matchOk) showToast('Password Mismatch', 'Passwords do not match.', 'error');

      if (!nameOk || !emailOk || !phoneOk || !birthOk || !genderOk || !rulesOk || !matchOk) {
        e.preventDefault();
      }
    });

    /* ══════════════════════════
       PASSWORD RULES
    ══════════════════════════ */
    var rulesBox = document.getElementById('passwordRules');
    var mismatchTxt = document.getElementById('passwordMismatch');
    var matchTxt = document.getElementById('passwordMatch');
    var hideTimer, mismatchTimer;

    var rules = {
      length: document.getElementById('rule-length'),
      letter: document.getElementById('rule-letter'),
      number: document.getElementById('rule-number'),
      special: document.getElementById('rule-special')
    };

    function updateRule(el, ok) {
      var icon = el.querySelector('i');
      if (ok) {
        el.classList.remove('text-gray-400'); el.style.color = '#16A34A';
        icon.className = 'fa-solid fa-circle-check text-[10px]';
      } else {
        el.style.color = ''; el.classList.add('text-gray-400');
        icon.className = 'fa-solid fa-circle-xmark text-[10px]';
      }
    }

    password.addEventListener('input', function () {
      var v = password.value;
      var checks = {
        length: v.length >= 8,
        letter: /[A-Za-z]/.test(v),
        number: /[0-9]/.test(v),
        special: /[^A-Za-z0-9]/.test(v)
      };
      updateRule(rules.length, checks.length);
      updateRule(rules.letter, checks.letter);
      updateRule(rules.number, checks.number);
      updateRule(rules.special, checks.special);

      rulesBox.style.display = 'grid';
      rulesBox.style.opacity = '1';
      clearTimeout(hideTimer);

      if (Object.values(checks).every(Boolean)) {
        hideTimer = setTimeout(function () {
          rulesBox.classList.add('fade-out');
          setTimeout(function () { rulesBox.style.display = 'none'; }, 400);
        }, 600);
      }
    });

    confirmPassword.addEventListener('input', function () {
      clearTimeout(mismatchTimer);
      mismatchTimer = setTimeout(function () {
        if (!confirmPassword.value) {
          mismatchTxt.style.display = 'none';
          matchTxt.style.display = 'none';
          return;
        }
        if (confirmPassword.value === password.value) {
          mismatchTxt.style.display = 'none';
          matchTxt.style.display = 'block';
          confirmPassword.classList.remove('border-red-500');
          confirmPassword.classList.add('border-green-500');
        } else {
          matchTxt.style.display = 'none';
          mismatchTxt.style.display = 'block';
          confirmPassword.classList.add('border-red-500');
          confirmPassword.classList.remove('border-green-500');
        }
      }, 200);
    });

    /* ══════════════════════════
       STARS CANVAS
    ══════════════════════════ */
    var canvas = document.getElementById('stars');
    var ctx = canvas.getContext('2d');
    var w, h, stars = [];

    function resize() {
      w = canvas.width = window.innerWidth;
      h = canvas.height = window.innerHeight;
      stars = Array.from({ length: 160 }, function () {
        return { x: Math.random() * w, y: Math.random() * h, r: Math.random() * 1.4 + 0.4, v: Math.random() * 0.3 + 0.1 };
      });
    }

    function draw() {
      ctx.clearRect(0, 0, w, h);
      ctx.fillStyle = 'rgba(255,255,200,0.85)';
      stars.forEach(function (s) {
        ctx.beginPath();
        ctx.arc(s.x, s.y, s.r, 0, Math.PI * 2);
        ctx.fill();
        s.y -= s.v;
        if (s.y < 0) { s.y = h; s.x = Math.random() * w; }
      });
      requestAnimationFrame(draw);
    }

    window.addEventListener('resize', resize);
    resize(); draw();

    /* ══════════════════════════
       PASSWORD TOGGLE
    ══════════════════════════ */
    function togglePassword(inputId, eyeId) {
      var input = document.getElementById(inputId);
      var icon = document.getElementById(eyeId);
      if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML =
          '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.042-3.368M6.223 6.223A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.956 9.956 0 01-4.132 5.411M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>' +
          '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18"/>';
      } else {
        input.type = 'password';
        icon.innerHTML =
          '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>' +
          '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
      }
    }
  </script>

  {{-- SESSION TOASTS --}}
  @if(session('error'))
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      showToast('Error', "{{ session('error') }}", 'error');
    });
  </script>
  @endif

  @if(session('success'))
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      showToast('Account Created!', "{{ session('success') }}", 'success');
    });
  </script>
  @endif

  {{-- REGISTRATION SUCCESS: show toast then redirect --}}
  @if(session('registered'))
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      showToast(
        'Account Created Successfully!',
        'Redirecting you to login&hellip;',
        'success'
      );
      setTimeout(function () {
        window.location.href = '/login';
      }, 3000);
    });
  </script>
  @endif

</body>

</html>