<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dentist Login</title>
  <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- DaisyUI -->
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" />

  <!-- Inter Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <style>
    body { font-family: 'Inter'; }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(8px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .fade-in {
      animation: fadeIn 0.6s ease-out forwards;
    }

    #stars {
      position: fixed;
      inset: 0;
      z-index: 1;
      pointer-events: none;
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
  </style>
</head>

<body class="min-h-screen bg-gradient-to-r from-[#8B0000] to-[#FFD700] flex items-center justify-center">
  <canvas id="stars"></canvas>
  <div class="fade-in bg-white w-[420px] rounded-3xl shadow-2xl px-10 py-12 relative z-10">

    <!-- Header -->
    <div class="text-center mb-8">
      <h1 class="text-3xl font-extrabold shine-text">
        Dentist Portal
      </h1>
      <p class="text-sm text-[#757575] mt-2">
        PUP Taguig Dental Clinic
      </p>
    </div>

    <!-- Error -->
    @if(session('error'))
      <div class="alert alert-error text-sm mb-5">
        {{ session('error') }}
      </div>
    @endif

    <!-- Login Form -->
    <form method="POST" action="{{ route('dentist.login.submit') }}" class="space-y-5">
      @csrf

      <div>
        <label class="label">
          <span class="label-text text-[#333333] text-sm font-medium">Username</span>
        </label>
        <input type="text" name="email" required
               class="input input-bordered w-full px-4 py-[7px] rounded-lg bg-[#F4F4F4] border border-[#D9D9D9]
               text-[#333333] focus:outline-none focus:ring-1 focus:ring-[#8B0000]" />
      </div>

      <div>
      <label class="label">
        <span class="label-text text-[#333333] text-sm font-medium">Password</span>
      </label>

      <div class="relative">
        <input
          id="dentistPassword"
          type="password"
          name="password"
          required
          class="input input-bordered w-full px-4 py-[7px] rounded-lg bg-[#F4F4F4] border border-[#D9D9D9]
          text-[#333333] focus:outline-none focus:ring-1 focus:ring-[#8B0000]"/>

        <!-- Eye icon -->
        <button
          type="button"
          onclick="toggleDentistPassword()"
          class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700">
          <svg id="dentistEyeIcon" xmlns="http://www.w3.org/2000/svg"
              class="h-5 w-5" fill="none"
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
    </div>

      <button type="submit"
        class="mt-2 w-full py-3 rounded-xl bg-[#8B0000] text-[#F4F4F4] font-bold hover:bg-[#660000] transition">
        Log In
      </button>
    </form>

    <!-- Back link -->
    <div class="text-center mt-6">
      <a href="/login"
         class="text-sm text-[#8B0000] font-medium hover:underline">
        ← Back to Patient Login
      </a>
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
function toggleDentistPassword() {
  const input = document.getElementById('dentistPassword');
  const icon = document.getElementById('dentistEyeIcon');

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
           a3 3 0 11-6 0 3 3 0 016 0z" />
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M3 3l18 18" />
    `;
  } else {
    input.type = 'password';
    icon.innerHTML = `
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
</script>

</body>
</html>
