<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Patient Registration</title>
  <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">

  <!-- Tailwind  -->
  <script src="https://cdn.tailwindcss.com"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

    <!-- Font Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <style>
      body {
      font-family: 'Inter';
      }

  .shine-text {
    background: linear-gradient(
      90deg,
      #8B0000,
      #FFD700,
      #8B0000
    );

    background-size: 200% auto;
    -webkit-background-clip: text;
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

  </style>
</head>

<body class="font-inter min-h-screen bg-gradient-to-r from-[#8B0000] to-[#FFD700] flex items-center justify-center">
<canvas id="stars"></canvas>
<div class="bg-[#8B0000] rounded-[1.75rem] shadow-2xl relative z-10 fade-up">
  <div class="flex w-[1100px] h-[700px] bg-white rounded-[1.5rem] overflow-hidden max-w-[95vw] max-h-[95vh] flex-col lg:flex-row">

    <!-- Left Image -->
    <div class="flex-[0.75] lg:h-auto">
      <img src="/images/PUP TAGUIG CAMPUS.jpg" class="w-full h-full object-cover">
    </div>

    <!-- Right Panel -->
    <div class="flex-[0.9] px-10 flex flex-col justify-center fade-up">

      <h1 class="text-4xl text-center font-extrabold shine-text">Create Account</h1>
      <p class="text-sm text-center text-[#757575] mt-2">Register a new patient account</p>

      {{-- Validation Errors --}}
      @if ($errors->any())
        <div class="bg-red-100 text-[#8B0000] px-4 py-2 rounded mb-4 font-semibold">
          <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      {{-- Success --}}
      @if (session('success'))
        <div class="bg-yellow-100 text-[#8B0000] px-4 py-2 rounded mb-4 text-center font-semibold">
          {{ session('success') }}
        </div>
      @endif
      
      <form method="POST" action="/register" class="grid grid-cols-2 gap-x-6 gap-y-4">
        @csrf

        <div class="col-span-2">
          <label class="block text-sm text-[#333333] font-medium mt-4 mb-1">Full Name</label>
          <input name="name" value="{{ old('name') }}" required
            class="w-full px-4 py-[7px] rounded-lg bg-[#F4F4F4] border border-[#D9D9D9] text-[#333333] focus:outline-none focus:ring-1 focus:ring-[#8B0000]">
        </div>

        <div>
          <label class="block text-sm text-[#333333] font-medium mb-1">Email</label>
          <input type="email" name="email" value="{{ old('email') }}" required
            class="w-full px-4 py-[7px] rounded-lg bg-[#F4F4F4] border border-[#D9D9D9] text-[#333333] focus:outline-none focus:ring-1 focus:ring-[#8B0000]">
        </div>

        <div>
          <label class="block text-sm text-[#333333] font-medium mb-1">Phone</label>
          <input name="phone" value="{{ old('phone') }}"
            class="w-full px-4 py-[7px] rounded-lg bg-[#F4F4F4] border border-[#D9D9D9] text-[#333333] focus:outline-none focus:ring-1 focus:ring-[#8B0000]">
        </div>

        <div>
          <label class="block text-sm text-[#333333] font-medium mb-1">Birthdate</label>
          <input type="date" name="birthdate" value="{{ old('birthdate') }}" required
            class="w-full px-2 py-[7px] rounded-lg bg-[#F4F4F4] border border-[#D9D9D9] text-[#333333] focus:outline-none focus:ring-1 focus:ring-[#8B0000]">
        </div>

        <div>
          <label class="block text-sm text-[#333333] font-medium mb-1">Gender</label>
          <select name="gender" required
            class="w-full px-2 py-[10px] rounded-lg bg-[#F4F4F4] border border-[#D9D9D9] text-[#333333] focus:outline-none focus:ring-1 focus:ring-[#8B0000]">
            <option value="">Select</option>
            <option value="Male" {{ old('gender')=='Male'?'selected':'' }}>Male</option>
            <option value="Female" {{ old('gender')=='Female'?'selected':'' }}>Female</option>
          </select>
        </div>

        <div class="col-span-2">
        <label class="block text-sm text-[#333333] font-medium mb-1">Password</label>
        <div class="relative">
          <input
            id="password"
            type="password"
            name="password"
            required
            class="w-full px-4 py-[7px] pr-12 rounded-lg bg-[#F4F4F4] border border-[#D9D9D9] text-[#333333] focus:outline-none focus:ring-1 focus:ring-[#8B0000]">

          <button
            type="button"
            onclick="togglePassword('password','eyePassword')"
            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700">
            <svg id="eyePassword" xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M2.458 12C3.732 7.943 7.523 5 12 5
                  c4.478 0 8.268 2.943 9.542 7
                  -1.274 4.057-5.064 7-9.542 7
                  -4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
          </button>
        </div>

        <!-- Password Rules -->
        <ul id="passwordRules"
            class="mt-2 grid grid-cols-2 gap-x-6 gap-y-1 text-xs transition-opacity duration-300">

          <li id="rule-length" class="flex items-center gap-2 text-gray-500">
            <i class="fa-solid fa-circle-xmark"></i> At least 8 characters
          </li>

          <li id="rule-letter" class="flex items-center gap-2 text-gray-500">
            <i class="fa-solid fa-circle-xmark"></i> At least one letter
          </li>

          <li id="rule-number" class="flex items-center gap-2 text-gray-500">
            <i class="fa-solid fa-circle-xmark"></i> At least one number
          </li>

          <li id="rule-special" class="flex items-center gap-2 text-gray-500">
            <i class="fa-solid fa-circle-xmark"></i> At least one special symbol
          </li>
        </ul>
      </div>

      <!-- Confirm Password -->
      <div class="col-span-2">
        <label class="block text-sm text-[#333333] font-medium mb-1">Confirm Password</label>
        <div class="relative">
          <input
            id="confirmPassword"
            type="password"
            name="password_confirmation"
            required
            class="w-full px-4 py-[7px] pr-12 rounded-lg bg-[#F4F4F4] border border-[#D9D9D9] text-[#333333] focus:outline-none focus:ring-1 focus:ring-[#8B0000]">

          <button
            type="button"
            onclick="togglePassword('confirmPassword','eyeConfirmPassword')"
            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700">
            <svg id="eyeConfirmPassword" xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M2.458 12C3.732 7.943 7.523 5 12 5
                  c4.478 0 8.268 2.943 9.542 7
                  -1.274 4.057-5.064 7-9.542 7
                  -4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
          </button>
        </div>
      </div>
      <p id="passwordMismatch"
        class="hidden mt-1 text-xs text-red-600 font-medium">
        Password does not match
      </p>

      <p id="passwordMatch"
        class="hidden mt-1 text-xs text-green-600 font-medium flex items-center gap-2">
        <i class="fa-solid fa-circle-check"></i> Passwords match
      </p>

      <div class="col-span-2">
        <button class="w-full py-2 rounded-lg bg-[#8B0000] text-[#F4F4F4] font-bold hover:bg-[#660000] transition">
          Register
        </button>
      </div>

      <p class="col-span-2 mt-4 text-center text-sm text-[#757575]">
        Already have an account?
        <a href="/login" class="text-[#8B0000] font-bold hover:underline">Login here</a>
      </p>

    </div>
  </div>
</div>


<script>
// PASSWORD RULES
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
    icon.className = 'fa-solid fa-circle-check';
  } else {
    rule.classList.remove('text-green-600');
    rule.classList.add('text-gray-500');
    icon.className = 'fa-solid fa-circle-xmark';
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

  // Always show rules while typing
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
    } else {
      matchText.classList.add('hidden');
      mismatchText.classList.remove('hidden');
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
  stars = Array.from({ length: 180 }, () => ({
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

/* ===== PASSWORD ===== */
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

</body>
</html>
