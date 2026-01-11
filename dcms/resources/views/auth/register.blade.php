<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Patient Registration</title>
  <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">

  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#8B0000',
            secondary: '#660000',
            accent: '#FFD700',
            lightbg: '#F4F4F4',
            mediumgray: '#D9D9D9'
          },
          fontFamily: { inter: ['Inter','sans-serif'] }
        }
      }
    }
  </script>
</head>

<style>
.shine-text {
  background: linear-gradient(
    90deg,
    #8B0000,
    #F2B233,
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
</style>

<body class="font-inter min-h-screen bg-gradient-to-r from-primary to-[#F2B233] flex items-center justify-center">
<canvas id="stars"></canvas>
<div class="bg-primary p-5 rounded-[1.75rem] shadow-2xl relative z-10">
  <div class="flex w-[1100px] h-[650px] bg-white rounded-[1.5rem] overflow-hidden max-w-[95vw] max-h-[95vh] flex-col lg:flex-row">

    <!-- Left Image -->
    <div class="flex-[1.2] h-60 lg:h-auto">
      <img src="/images/PUP TAGUIG CAMPUS.jpg" class="w-full h-full object-cover">
    </div>

    <!-- Right Panel -->
    <div class="flex-[0.8] px-10 py-12 overflow-y-auto">

      <h1 class="text-4xl text-center font-extrabold shine-text">Create Account</h1>
      <p class="text-center text-gray-600 mb-8">Register a new patient account</p>

      {{-- Validation Errors --}}
      @if ($errors->any())
        <div class="bg-red-100 text-primary px-4 py-2 rounded mb-4 font-semibold">
          <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      {{-- Success --}}
      @if (session('success'))
        <div class="bg-yellow-100 text-primary px-4 py-2 rounded mb-4 text-center font-semibold">
          {{ session('success') }}
        </div>
      @endif

      <form method="POST" action="/register" class="space-y-4">
        @csrf

        <div>
          <label class="block text-sm font-medium mb-1">Full Name</label>
          <input name="name" value="{{ old('name') }}" required
            class="w-full px-4 py-2 rounded-lg bg-lightbg border border-mediumgray focus:ring-2 focus:ring-primary">
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Email</label>
          <input type="email" name="email" value="{{ old('email') }}" required
            class="w-full px-4 py-2 rounded-lg bg-lightbg border border-mediumgray focus:ring-2 focus:ring-primary">
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Phone</label>
          <input name="phone" value="{{ old('phone') }}"
            class="w-full px-4 py-2 rounded-lg bg-lightbg border border-mediumgray focus:ring-2 focus:ring-primary">
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Birthdate</label>
          <input type="date" name="birthdate" value="{{ old('birthdate') }}" required
            class="w-full px-4 py-2 rounded-lg bg-lightbg border border-mediumgray focus:ring-2 focus:ring-primary">
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Gender</label>
          <select name="gender" required
            class="w-full px-4 py-2 rounded-lg bg-lightbg border border-mediumgray focus:ring-2 focus:ring-primary">
            <option value="">Select</option>
            <option value="Male" {{ old('gender')=='Male'?'selected':'' }}>Male</option>
            <option value="Female" {{ old('gender')=='Female'?'selected':'' }}>Female</option>
          </select>
        </div>

        <div>
        <label class="block text-sm font-medium mb-1">Password</label>
        <div class="relative">
          <input
            id="password"
            type="password"
            name="password"
            required
            class="w-full px-4 py-2 pr-12 rounded-lg bg-lightbg border border-mediumgray focus:ring-2 focus:ring-primary"
          >

          <button
            type="button"
            onclick="togglePassword('password','eyePassword')"
            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700"
          >
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
      </div>

      <!-- Confirm Password -->
      <div>
        <label class="block text-sm font-medium mb-1">Confirm Password</label>
        <div class="relative">
          <input
            id="confirmPassword"
            type="password"
            name="password_confirmation"
            required
            class="w-full px-4 py-2 pr-12 rounded-lg bg-lightbg border border-mediumgray focus:ring-2 focus:ring-primary"
          >

          <button
            type="button"
            onclick="togglePassword('confirmPassword','eyeConfirmPassword')"
            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700"
          >
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

        <button class="w-full py-2 rounded-lg bg-primary text-accent font-semibold hover:bg-secondary transition">
          Register
        </button>
      </form>

      <p class="mt-6 text-center text-sm text-gray-600">
        Already have an account?
        <a href="/login" class="text-primary font-semibold hover:text-secondary">Login here</a>
      </p>

    </div>
  </div>
</div>


<script>
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
