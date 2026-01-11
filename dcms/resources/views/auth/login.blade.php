<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PUPTSIS Login</title>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>

  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: { inter: ['Inter', 'sans-serif'] }
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

<body class="font-inter min-h-screen animated-bg bg-gradient-to-r from-[#8B0000] to-[#F2B233] flex items-center justify-center">
<canvas id="stars"></canvas>
<div class="bg-[#8B0000] rounded-[1.75rem] shadow-2xl relative z-10">
  <div class="flex w-[1100px] h-[600px] bg-white rounded-[1.5rem] overflow-hidden max-w-[95vw] max-h-[95vh] flex-col lg:flex-row">

    <!-- Left Image -->
    <div class="flex-[1.2] h-60 lg:h-auto">
      <img src="{{ asset('images/PUP TAGUIG CAMPUS.jpg') }}" alt="Campus" class="w-full h-full object-cover">
    </div>

    <!-- Right Panel -->
    <div class="flex-[0.8] px-10 py-16 flex flex-col justify-center fade-up">
      <h1 class="text-center tracking-wide drop-shadow-lg">
        <span class="block text-4xl lg:text-5xl font-extrabold shine-text">
          PUP-TAGUIG
        </span>
        <span class="block text-2xl lg:text-3xl mt-2 font-extrabold shine-text">
          DENTAL MANAGEMENT SYSTEM
        </span>
    </h1>

      <p class="text-center text-gray-600 mt-4 text-base">Log In to your account</p>

      {{-- Login Form --}}
      <form method="POST" action="{{ route('login') }}">
        @csrf

        <label class="text-sm font-medium mb-1">Email</label>
        <input type="email" name="email" required
          class="w-full px-4 py-3 rounded-lg bg-[#ECECEC] mb-6 focus:outline-none focus:ring-2 focus:ring-[#F2B233]">

        <label class="text-sm font-medium mb-1">Password</label>
        <div class="relative mb-6">
        <input
          id="password"
          type="password"
          name="password"
          required
          class="w-full px-4 py-3 rounded-lg bg-[#ECECEC] pr-12 focus:outline-none focus:ring-2 focus:ring-[#F2B233]"
        >
          <!-- Eye Icon -->
          <button
            type="button"
            onclick="togglePassword()"
            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700"
          >
            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
              viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7
                  -1.274 4.057-5.064 7-9.542 7
                  -4.477 0-8.268-2.943-9.542-7z" />
            </svg>
          </button>
        </div>

        <button type="submit"
          class="mt-2 w-full py-3 rounded-xl bg-[#8B0000] text-white font-semibold hover:opacity-90 transition">
          Log In
        </button>
      </form>

      <a href="{{ route('dentist.login') }}"
        class="mt-4 w-full py-3 rounded-xl bg-gradient-to-r from-[#FFD166] to-[#8B0000] text-[#F4F4F4] font-semibold hover:opacity-90 transition flex items-center justify-center gap-2">
        <img src="{{ asset('images/dentist-login.png') }}" alt="Dentist" class="w-7 h-7">
        <span>Log in as Dentist</span>
      </a>

        <!-- New: Redirect to Registration -->
        <p class="mt-6 text-center text-sm text-gray-600">
        Don't have an account?
        <a href="/register" class="text-[#F2B233] font-semibold hover:underline">Register here</a>
        </p>

</p>

    </div>
    </div>
  </div>
</div>

<script>
/* ===== PASSWORD ===== */
function togglePassword() {
  const passwordInput = document.getElementById('password');
  const eyeIcon = document.getElementById('eyeIcon');

  if (passwordInput.type === 'password') {
    passwordInput.type = 'text';
    eyeIcon.innerHTML = `
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M13.875 18.825A10.05 10.05 0 0112 19
           c-4.478 0-8.268-2.943-9.542-7
           a9.956 9.956 0 012.042-3.368M6.223 6.223
           A9.956 9.956 0 0112 5
           c4.478 0 8.268 2.943 9.542 7
           a9.956 9.956 0 01-4.132 5.411M15 12
           a3 3 0 11-6 0 3 3 0 016 0z" />
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M3 3l18 18" />
    `;
  } else {
    passwordInput.type = 'password';
    eyeIcon.innerHTML = `
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M2.458 12C3.732 7.943 7.523 5 12 5
           c4.478 0 8.268 2.943 9.542 7
           -1.274 4.057-5.064 7-9.542 7
           -4.477 0-8.268-2.943-9.542-7z" />
    `;
  }
}
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
</script>

</body>
</html>
