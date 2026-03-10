<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Patient Registration</title>
  <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">

  <!-- Tailwind  -->
  <script src="https://cdn.tailwindcss.com"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

  <!-- Font Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            inter: ['Inter', 'sans-serif']
          }
        }
      }
    }
  </script>

  <style>
    body {
      font-family: 'Inter';
    }

    .shine-text {
      background: linear-gradient(90deg, #8B0000, #FFD700, #8B0000);
      background-size: 200% auto;
      background-clip: text;
      -webkit-text-fill-color: transparent;
      animation: shine 6s linear infinite;
    }

    @keyframes shine {
      0% {
        background-position: 200% center;
      }

      100% {
        background-position: -200% center;
      }
    }

    #stars {
      position: fixed;
      inset: 0;
      z-index: 1;
      pointer-events: none;
    }

    @keyframes fadeUp {
      0% {
        opacity: 0;
        transform: translateY(10px);
      }

      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .fade-up {
      animation: fadeUp 0.6s ease-out forwards;
    }

    .fade-out {
      opacity: 0;
      transition: opacity 0.4s ease;
    }

    /* Toast Notification Styles */
    .toast-notification {
      min-width: 300px;
      max-width: 500px;
      background: white;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      padding: 16px 20px 16px 24px;
      display: flex;
      align-items: center;
      gap: 12px;
      opacity: 0;
      transform: translateX(420px);
      transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    .toast-notification::before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      bottom: 0;
      width: 4px;
      background: linear-gradient(180deg, #8B0000, #FFD700);
      border-radius: 8px 0 0 8px;
    }

    #toastContainer {
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 99999;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .toast-notification.show {
      opacity: 1;
      transform: translateX(0);
    }

    .toast-notification.hide {
      opacity: 0;
      transform: translateX(400px);
    }

    /* Prevent autofill background color change */
    input:-webkit-autofill,
    input:-webkit-autofill:hover,
    input:-webkit-autofill:focus,
    input:-webkit-autofill:active {
      -webkit-box-shadow: 0 0 0 30px #F4F4F4 inset !important;
      -webkit-text-fill-color: #333333 !important;
    }

    /* Mobile responsive toast */
    @media (max-width: 640px) {
      #toastContainer {
        right: 10px;
        left: 10px;
      }

      .toast-notification {
        min-width: unset;
        max-width: unset;
        width: 100%;
      }
    }
  </style>
</head>

<body class="font-inter min-h-screen bg-gradient-to-r from-[#8B0000] to-[#FFD700] flex items-center justify-center p-4 sm:p-6">
  <canvas id="stars"></canvas>

  <!-- Toast Notification Container -->
  <div id="toastContainer"></div>

  <div class="bg-[#8B0000] rounded-[1.75rem] shadow-2xl relative z-10 fade-up w-full max-w-[1100px]">
    <div class="flex w-full h-auto lg:h-[700px] bg-white rounded-xl lg:rounded-[1.5rem] overflow-hidden flex-col lg:flex-row">

      <!-- Left Image -->
      <div class="flex-[0.75] h-48 sm:h-56 lg:h-auto">
        <img src="/images/PUP TAGUIG CAMPUS.jpg" class="w-full h-full object-cover">
      </div>

      <!-- Right Panel -->
      <div class="flex-[0.9] px-5 sm:px-8 lg:px-10 py-6 sm:py-8 lg:py-10 flex flex-col justify-center fade-up overflow-y-auto">

        <h1 class="text-3xl sm:text-4xl text-center font-extrabold shine-text">Create Account</h1>
        <p class="text-xs sm:text-sm text-center text-[#757575] mt-2 mb-4">Register a new patient account</p>

        <form method="POST" action="/register" class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 sm:gap-x-6 gap-y-3 sm:gap-y-4">
          @csrf

          <div class="sm:col-span-2">
            <label class="block text-xs sm:text-sm text-[#333333] font-medium mb-1">Full Name</label>
            <input
              id="name"
              name="name"
              value="{{ old('name') }}"
              placeholder="Enter your full name"
              required
              class="w-full px-3 sm:px-4 py-2 sm:py-[7px] rounded-lg bg-[#F4F4F4] border border-[#D9D9D9] text-sm text-[#333333] focus:outline-none focus:ring-1 focus:ring-[#8B0000] placeholder:text-gray-400">
            <p id="name-error" class="hidden mt-1 text-xs text-red-600"></p>
          </div>

          <div class="sm:col-span-1">
            <label class="block text-xs sm:text-sm text-[#333333] font-medium mb-1">Email</label>
            <input
              id="email"
              type="email"
              name="email"
              value="{{ old('email') }}"
              placeholder="Enter your email"
              required
              class="w-full px-3 sm:px-4 py-2 sm:py-[7px] rounded-lg bg-[#F4F4F4] border border-[#D9D9D9] text-sm text-[#333333] focus:outline-none focus:ring-1 focus:ring-[#8B0000] placeholder:text-gray-400">
            <p id="email-error" class="hidden mt-1 text-xs text-red-600"></p>
          </div>

          <div class="sm:col-span-1">
            <label class="block text-xs sm:text-sm text-[#333333] font-medium mb-1">Phone</label>
            <input
              id="phone"
              name="phone"
              value="{{ old('phone') }}"
              placeholder="Enter your phone number"
              class="w-full px-3 sm:px-4 py-2 sm:py-[7px] rounded-lg bg-[#F4F4F4] border border-[#D9D9D9] text-sm text-[#333333] focus:outline-none focus:ring-1 focus:ring-[#8B0000] placeholder:text-gray-400">
            <p id="phone-error" class="hidden mt-1 text-xs text-red-600"></p>
          </div>

          <div class="sm:col-span-1">
            <label class="block text-xs sm:text-sm text-[#333333] font-medium mb-1">Birthdate</label>
            <input
              id="birthdate"
              type="date"
              name="birthdate"
              value="{{ old('birthdate') }}"
              required
              class="w-full px-2 sm:px-2 py-2 sm:py-[7px] rounded-lg bg-[#F4F4F4] border border-[#D9D9D9] text-sm text-[#333333] focus:outline-none focus:ring-1 focus:ring-[#8B0000]">
            <p id="birthdate-error" class="hidden mt-1 text-xs text-red-600"></p>
          </div>

          <div class="sm:col-span-1">
            <label class="block text-xs sm:text-sm text-[#333333] font-medium mb-1">Gender</label>
            <select
              id="gender"
              name="gender"
              required
              class="w-full px-2 py-2 sm:py-[10px] rounded-lg bg-[#F4F4F4] border border-[#D9D9D9] text-sm text-[#333333] focus:outline-none focus:ring-1 focus:ring-[#8B0000]">
              <option value="">Select Gender</option>
              <option value="Male" {{ old('gender')=='Male'?'selected':'' }}>Male</option>
              <option value="Female" {{ old('gender')=='Female'?'selected':'' }}>Female</option>
            </select>
            <p id="gender-error" class="hidden mt-1 text-xs text-red-600"></p>
          </div>

          <div class="sm:col-span-2">
            <label class="block text-xs sm:text-sm text-[#333333] font-medium mb-1">Password</label>
            <div class="relative">
              <input
                id="password"
                type="password"
                name="password"
                placeholder="Enter your password"
                required
                class="w-full px-3 sm:px-4 py-2 sm:py-[7px] pr-10 sm:pr-12 rounded-lg bg-[#F4F4F4] border border-[#D9D9D9] text-sm text-[#333333] focus:outline-none focus:ring-1 focus:ring-[#8B0000] placeholder:text-gray-400">

              <button
                type="button"
                onclick="togglePassword('password','eyePassword')"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700">
                <svg id="eyePassword" xmlns="http://www.w3.org/2000/svg"
                  class="h-4 w-4 sm:h-5 sm:w-5" fill="none"
                  viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5
                      c4.478 0 8.268 2.943 9.542 7
                      -1.274 4.057-5.064 7-9.542 7
                      -4.477 0-8.268-2.943-9.542-7z" />
                </svg>
              </button>
            </div>

            <!-- Password Rules -->
            <ul id="passwordRules"
              class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-x-4 sm:gap-x-6 gap-y-1 text-xs transition-opacity duration-300">

              <li id="rule-length" class="flex items-center gap-2 text-gray-500">
                <i class="fa-solid fa-circle-xmark text-xs"></i> At least 8 characters
              </li>

              <li id="rule-letter" class="flex items-center gap-2 text-gray-500">
                <i class="fa-solid fa-circle-xmark text-xs"></i> At least one letter
              </li>

              <li id="rule-number" class="flex items-center gap-2 text-gray-500">
                <i class="fa-solid fa-circle-xmark text-xs"></i> At least one number
              </li>

              <li id="rule-special" class="flex items-center gap-2 text-gray-500">
                <i class="fa-solid fa-circle-xmark text-xs"></i> At least one special symbol
              </li>
            </ul>
          </div>

          <!-- Confirm Password -->
          <div class="sm:col-span-2">
            <label class="block text-xs sm:text-sm text-[#333333] font-medium mb-1">Confirm Password</label>
            <div class="relative">
              <input
                id="confirmPassword"
                type="password"
                name="password_confirmation"
                placeholder="Re-enter your password"
                required
                class="w-full px-3 sm:px-4 py-2 sm:py-[7px] pr-10 sm:pr-12 rounded-lg bg-[#F4F4F4] border border-[#D9D9D9] text-sm text-[#333333] focus:outline-none focus:ring-1 focus:ring-[#8B0000] placeholder:text-gray-400">

              <button
                type="button"
                onclick="togglePassword('confirmPassword','eyeConfirmPassword')"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700">
                <svg id="eyeConfirmPassword" xmlns="http://www.w3.org/2000/svg"
                  class="h-4 w-4 sm:h-5 sm:w-5" fill="none"
                  viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5
                      c4.478 0 8.268 2.943 9.542 7
                      -1.274 4.057-5.064 7-9.542 7
                      -4.477 0-8.268-2.943-9.542-7z" />
                </svg>
              </button>
            </div>

            <p id="passwordMismatch" class="hidden mt-1 text-xs text-red-600 font-medium">
              <i class="fa-solid fa-circle-xmark"></i> Passwords do not match
            </p>

            <p id="passwordMatch" class="hidden mt-1 text-xs text-green-600 font-medium flex items-center gap-2">
              <i class="fa-solid fa-circle-check"></i> Passwords match
            </p>
          </div>

          <div class="sm:col-span-2">
            <button
              type="submit"
              class="group w-full py-2.5 sm:py-3 rounded-xl
                bg-gradient-to-r from-[#8B0000] to-[#A52A2A]
                text-white font-bold text-sm sm:text-base
                relative overflow-hidden
                transition-all duration-300 ease-out
                hover:shadow-lg hover:shadow-[#8B0000]/50
                hover:scale-[1.02]
                active:scale-[0.98]
                before:absolute before:inset-0
                before:bg-gradient-to-r before:from-[#A52A2A] before:to-[#8B0000]
                before:opacity-0 before:transition-opacity before:duration-300
                hover:before:opacity-100">
              <span class="relative z-10 flex items-center justify-center gap-2">
                <span>Register</span>
                <i class="fa-solid fa-user-plus transform transition-transform duration-300 group-hover:scale-110"></i>
              </span>
            </button>
          </div>

          <p class="sm:col-span-2 mt-2 text-center text-xs sm:text-sm text-[#757575]">
            Already have an account?
            <a href="/login" class="text-[#8B0000] font-bold hover:underline">Login here</a>
          </p>
        </form>

      </div>
    </div>
  </div>

  <script>
    /* ===== TOAST NOTIFICATION ===== */
    function showToast(message, type = 'error') {
      const container = document.getElementById('toastContainer');

      const toast = document.createElement('div');
      toast.className = 'toast-notification';

      const iconColor = type === 'error' ? '#8B0000' : '#10B981';
      const icon = type === 'error' ?
        '<i class="fa-solid fa-circle-exclamation text-xl"></i>' :
        '<i class="fa-solid fa-circle-check text-xl"></i>';

      toast.innerHTML = `
        <div style="color: ${iconColor}">
          ${icon}
        </div>
        <div class="flex-1">
          <p class="text-sm font-semibold text-gray-800">${type === 'error' ? 'Error' : 'Success'}</p>
          <p class="text-xs text-gray-600 mt-0.5">${message}</p>
        </div>
        <button onclick="this.parentElement.classList.add('hide')" class="text-gray-400 hover:text-gray-600">
          <i class="fa-solid fa-xmark"></i>
        </button>
      `;

      container.appendChild(toast);

      setTimeout(() => {
        toast.classList.add('show');
      }, 10);

      setTimeout(() => {
        toast.classList.remove('show');
        toast.classList.add('hide');
        setTimeout(() => {
          toast.remove();
        }, 300);
      }, 3000);
    }

    /* ===== REAL-TIME VALIDATION ===== */
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('phone');
    const birthdateInput = document.getElementById('birthdate');
    const genderInput = document.getElementById('gender');

    function setError(inputEl, errorId, message) {
      const errorEl = document.getElementById(errorId);
      errorEl.textContent = message;
      errorEl.classList.remove('hidden');
      inputEl.classList.add('border-red-500');
      inputEl.classList.remove('border-green-500');
    }

    function clearError(inputEl, errorId) {
      const errorEl = document.getElementById(errorId);
      errorEl.classList.add('hidden');
      inputEl.classList.remove('border-red-500');
      inputEl.classList.add('border-green-500');
    }

    function validateName() {
      const v = nameInput.value.trim();
      if (v.length < 2) return setError(nameInput, 'name-error', 'Name must be at least 2 characters'), false;
      if (v.length > 255) return setError(nameInput, 'name-error', 'Name must not exceed 255 characters'), false;
      clearError(nameInput, 'name-error');
      return true;
    }

    function validateEmail() {
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailInput.value) return setError(emailInput, 'email-error', 'Email is required'), false;
      if (!emailPattern.test(emailInput.value)) return setError(emailInput, 'email-error', 'Please enter a valid email address'), false;
      clearError(emailInput, 'email-error');
      return true;
    }

    function validatePhone() {
      const phonePattern = /^[\d\s\-\+\(\)]+$/;
      if (phoneInput.value && !phonePattern.test(phoneInput.value)) return setError(phoneInput, 'phone-error', 'Please enter a valid phone number'), false;
      if (phoneInput.value && phoneInput.value.length > 20) return setError(phoneInput, 'phone-error', 'Phone number must not exceed 20 characters'), false;
      clearError(phoneInput, 'phone-error');
      return true;
    }

    function validateBirthdate() {
      const selectedDate = new Date(birthdateInput.value);
      const today = new Date();
      const minDate = new Date();
      minDate.setFullYear(today.getFullYear() - 120);
      if (!birthdateInput.value) return setError(birthdateInput, 'birthdate-error', 'Birthdate is required'), false;
      if (selectedDate > today) return setError(birthdateInput, 'birthdate-error', 'Birthdate cannot be in the future'), false;
      if (selectedDate < minDate) return setError(birthdateInput, 'birthdate-error', 'Please enter a valid birthdate'), false;
      clearError(birthdateInput, 'birthdate-error');
      return true;
    }

    function validateGender() {
      if (!genderInput.value) return setError(genderInput, 'gender-error', 'Please select a gender'), false;
      clearError(genderInput, 'gender-error');
      return true;
    }

    function validatePasswordRules() {
      const value = password.value;
      return value.length >= 8 && /[A-Za-z]/.test(value) && /[0-9]/.test(value) && /[^A-Za-z0-9]/.test(value);
    }

    function validatePasswordMatch() {
      return confirmPassword.value && confirmPassword.value === password.value;
    }

    // Attach blur/change listeners
    nameInput.addEventListener('blur', validateName);
    nameInput.addEventListener('input', validateName);
    emailInput.addEventListener('blur', validateEmail);
    emailInput.addEventListener('input', validateEmail);
    phoneInput.addEventListener('blur', validatePhone);
    phoneInput.addEventListener('input', validatePhone);
    birthdateInput.addEventListener('blur', validateBirthdate);
    birthdateInput.addEventListener('change', validateBirthdate);
    genderInput.addEventListener('change', validateGender);

    // Prevent form submit if validation fails
    document.querySelector('form').addEventListener('submit', function(e) {
      const nameOk = validateName();
      const emailOk = validateEmail();
      const phoneOk = validatePhone();
      const birthOk = validateBirthdate();
      const genderOk = validateGender();
      const rulesOk = validatePasswordRules();
      const matchOk = validatePasswordMatch();

      if (!rulesOk) {
        showToast('Password does not meet the requirements.', 'error');
      }
      if (!matchOk) {
        showToast('Passwords do not match.', 'error');
      }

      if (!nameOk || !emailOk || !phoneOk || !birthOk || !genderOk || !rulesOk || !matchOk) {
        e.preventDefault();
      }
    });

    /* ===== PASSWORD RULES ===== */
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirmPassword');
    const mismatchText = document.getElementById('passwordMismatch');
    const matchText = document.getElementById('passwordMatch');
    const rulesBox = document.getElementById('passwordRules');

    let mismatchTimer = null;
    let hideRulesTimer = null;

    const rules = {
      length: document.getElementById('rule-length'),
      letter: document.getElementById('rule-letter'),
      number: document.getElementById('rule-number'),
      special: document.getElementById('rule-special')
    };

    function updateRule(rule, condition) {
      const icon = rule.querySelector('i');
      if (condition) {
        rule.classList.remove('text-gray-500');
        rule.classList.add('text-green-600');
        icon.className = 'fa-solid fa-circle-check text-xs';
      } else {
        rule.classList.remove('text-green-600');
        rule.classList.add('text-gray-500');
        icon.className = 'fa-solid fa-circle-xmark text-xs';
      }
    }

    password.addEventListener('input', () => {
      const value = password.value;

      const checks = {
        length: value.length >= 8,
        letter: /[A-Za-z]/.test(value),
        number: /[0-9]/.test(value),
        special: /[^A-Za-z0-9]/.test(value)
      };

      updateRule(rules.length, checks.length);
      updateRule(rules.letter, checks.letter);
      updateRule(rules.number, checks.number);
      updateRule(rules.special, checks.special);

      const allValid = Object.values(checks).every(Boolean);

      rulesBox.classList.remove('hidden', 'fade-out');
      rulesBox.style.opacity = '1';

      clearTimeout(hideRulesTimer);

      if (allValid) {
        hideRulesTimer = setTimeout(() => {
          rulesBox.classList.add('fade-out');
          setTimeout(() => {
            rulesBox.classList.add('hidden');
          }, 400);
        }, 100);
      }
    });

    confirmPassword.addEventListener('input', () => {
      clearTimeout(mismatchTimer);

      mismatchTimer = setTimeout(() => {
        if (!confirmPassword.value) {
          mismatchText.classList.add('hidden');
          matchText.classList.add('hidden');
          return;
        }

        if (confirmPassword.value === password.value) {
          mismatchText.classList.add('hidden');
          matchText.classList.remove('hidden');
          confirmPassword.classList.remove('border-red-500');
          confirmPassword.classList.add('border-green-500');
        } else {
          matchText.classList.add('hidden');
          mismatchText.classList.remove('hidden');
          confirmPassword.classList.add('border-red-500');
          confirmPassword.classList.remove('border-green-500');
        }
      }, 100);
    });

    /* ===== CANVAS STARS ===== */
    const canvas = document.getElementById("stars");
    const ctx = canvas.getContext("2d");

    let w, h;
    let stars = [];

    function resize() {
      w = canvas.width = window.innerWidth;
      h = canvas.height = window.innerHeight;
      stars = Array.from({
        length: 180
      }, () => ({
        x: Math.random() * w,
        y: Math.random() * h,
        r: Math.random() * 1.5 + 0.5,
        v: Math.random() * 0.3 + 0.1
      }));
    }

    function draw() {
      ctx.clearRect(0, 0, w, h);
      ctx.fillStyle = "rgba(255,255,220,0.9)";

      for (const s of stars) {
        ctx.beginPath();
        ctx.arc(s.x, s.y, s.r, 0, Math.PI * 2);
        ctx.fill();

        s.y -= s.v;
        if (s.y < 0) {
          s.y = h;
          s.x = Math.random() * w;
        }
      }

      requestAnimationFrame(draw);
    }

    window.addEventListener("resize", resize);
    resize();
    draw();

    /* ===== PASSWORD TOGGLE ===== */
    function togglePassword(inputId, eyeId) {
      const input = document.getElementById(inputId);
      const icon = document.getElementById(eyeId);

      if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = `
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M13.875 18.825A10.05 10.05 0 0112 19
               c-4.478 0-8.268-2.943-9.542-7
               a9.956 9.956 0 012.042-3.368M6.223 6.223
               A9.956 9.956 0 0112 5
               c4.478 0 8.268 2.943 9.542 7
               a9.956 9.956 0 01-4.132 5.411M15 12
               a3 3 0 11-6 0 3 3 0 016 0z"/>
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M3 3l18 18"/>
        `;
      } else {
        input.type = 'password';
        icon.innerHTML = `
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M2.458 12C3.732 7.943 7.523 5 12 5
               c4.478 0 8.268 2.943 9.542 7
               -1.274 4.057-5.064 7-9.542 7
               -4.477 0-8.268-2.943-9.542-7z"/>
        `;
      }
    }
  </script>

  @if(session('error'))
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      showToast("{{ session('error') }}", 'error');
    });
  </script>
  @endif

  @if(session('success'))
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      showToast("{{ session('success') }}", 'success');
    });
  </script>
  @endif

</body>

</html>