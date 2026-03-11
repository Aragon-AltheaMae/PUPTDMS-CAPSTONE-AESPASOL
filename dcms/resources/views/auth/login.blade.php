<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PUPT-DMS Login</title>
  <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">

  <!-- Tailwind  -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- DaisyUI -->
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" />

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
    .shine-text {
      background: linear-gradient(90deg,
          #8B0000,
          #FFD700,
          #8B0000);

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

    /* Eye Icon Animation */
    #eyeIcon {
      transition: all 0.3s ease-in-out;
    }

    #eyeIcon.closing {
      animation: blinkClose 0.3s ease-in-out;
    }

    #eyeIcon.opening {
      animation: blinkOpen 0.3s ease-in-out;
    }

    @keyframes blinkClose {
      0% {
        transform: scaleY(1);
      }

      50% {
        transform: scaleY(0.1);
      }

      100% {
        transform: scaleY(1);
      }
    }

    @keyframes blinkOpen {
      0% {
        transform: scaleY(1);
      }

      50% {
        transform: scaleY(0.1);
      }

      100% {
        transform: scaleY(1);
      }
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
      position: relative;
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

    @keyframes shake {

      0%,
      100% {
        transform: translateX(0);
      }

      25% {
        transform: translateX(-5px);
      }

      75% {
        transform: translateX(5px);
      }
    }

    .toast-notification.shake {
      animation: shake 0.3s ease-in-out;
    }

    input:-webkit-autofill,
    input:-webkit-autofill:hover,
    input:-webkit-autofill:focus,
    input:-webkit-autofill:active {
      -webkit-box-shadow: 0 0 0 30px #F4F4F4 inset !important;
      -webkit-text-fill-color: #333333 !important;
    }

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

<body class="font-inter min-h-screen animated-bg bg-gradient-to-r from-[#8B0000] to-[#FFD700] flex items-center justify-center p-4 sm:p-6">
  <canvas id="stars"></canvas>

  <!-- Toast Notification Container -->
  <div id="toastContainer"></div>

  <div class="bg-[#8B0000] rounded-[1.75rem] shadow-2xl relative z-10 fade-up w-full max-w-[1100px]">
    <div class="flex w-full
            h-auto lg:h-[650px]
            bg-white rounded-xl lg:rounded-[1.5rem]
            overflow-hidden
            flex-col lg:flex-row">

      <!-- Left Image -->
      <div class="flex-[0.85] h-48 sm:h-56 lg:h-auto">
        <img src="/images/PUP TAGUIG CAMPUS.jpg" class="w-full h-full object-cover">
      </div>

      <!-- Right Panel -->
      <div class="flex-[0.9]
            px-5 sm:px-8 lg:px-10
            py-6 sm:py-8 lg:py-0
            flex flex-col justify-center fade-up">
        <h1 class="text-center tracking-wide drop-shadow-lg">
          <span class="block text-2xl sm:text-3xl lg:text-5xl font-extrabold shine-text">
            PUP-TAGUIG
          </span>
          <span class="block text-lg sm:text-xl lg:text-3xl mt-1 sm:mt-2 font-extrabold shine-text">
            DENTAL MANAGEMENT SYSTEM
          </span>
        </h1>

        <p class="text-center text-[#757575] mt-3 sm:mt-4 mb-4 sm:mb-6 text-sm sm:text-base">Log In to your account</p>

        {{-- Login Form --}}
        <form method="POST" action="{{ route('login') }}">
          @csrf

          <label class="text-sm text-[#333333] font-medium mb-2 block">Email</label>
          <input type="email" name="email" required placeholder="Enter email"
            class="w-full px-4 py-2.5 sm:py-3 rounded-lg bg-[#F4F4F4] border border-[#D9D9D9] mb-4 sm:mb-6 focus:outline-none focus:ring-1 focus:ring-[#8B0000] text-sm text-[#333333] placeholder:text-gray-400">

          <label class="text-sm text-[#333333] font-medium block">Password</label>
          <div class="relative mb-2">
            <input
              id="password"
              type="password"
              name="password"
              required
              placeholder="Enter password"
              class="w-full px-4 py-2.5 sm:py-3 rounded-lg bg-[#F4F4F4] border border-[#D9D9D9] pr-12 focus:outline-none focus:ring-1 focus:ring-[#8B0000] text-sm text-[#333333] placeholder:text-gray-400">

            <!-- Eye Icon -->
            <button
              type="button"
              onclick="togglePassword()"
              class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700">
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
            class="group mt-2 w-full py-2.5 sm:py-3 rounded-xl
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
              <span>Log In</span>
              <i class="fa-solid fa-arrow-right transform transition-transform duration-300 group-hover:translate-x-1"></i>
            </span>
          </button>
        </form>

        <!-- Dentist + Admin Login -->
        <div class="mt-3 sm:mt-4 grid grid-cols-2 gap-2 sm:gap-3">

          <!-- Dentist -->
          <a href="{{ route('dentist.login') }}"
            class="group relative py-2.5 sm:py-3 rounded-xl
          bg-gradient-to-br from-[#FFD700] via-[#FFA500] to-[#8B0000]
          text-white font-bold text-sm sm:text-base
          flex items-center justify-center gap-2
          overflow-hidden
          shadow-md
          transition-all duration-500 ease-out
          hover:shadow-xl hover:shadow-[#FFD700]/40
          hover:scale-[1.05]
          active:scale-[0.98]
          before:absolute before:inset-0
          before:bg-gradient-to-br before:from-[#8B0000] before:via-[#FFA500] before:to-[#FFD700]
          before:opacity-0 before:transition-opacity before:duration-500
          hover:before:opacity-100">

            <span class="relative z-10 flex items-center gap-2">
              <i class="fa-solid fa-user-doctor text-base sm:text-lg transform transition-all duration-500 group-hover:rotate-12 group-hover:scale-110"></i>
              <span class="transition-all duration-300 group-hover:tracking-wide">Dentist</span>
            </span>

            <!-- Shine effect -->
            <div class="absolute inset-0 -translate-x-full group-hover:translate-x-full transition-transform duration-1000 ease-in-out bg-gradient-to-r from-transparent via-white/30 to-transparent"></div>
          </a>

          <!-- Admin -->
          <a href="{{ route('admin.login') }}"
            class="group relative py-2.5 sm:py-3 rounded-xl
          bg-gradient-to-br from-[#FFD700] via-[#FFA500] to-[#8B0000]
          text-white font-bold text-sm sm:text-base
          flex items-center justify-center gap-2
          overflow-hidden
          shadow-md
          transition-all duration-500 ease-out
          hover:shadow-xl hover:shadow-[#FFD700]/40
          hover:scale-[1.05]
          active:scale-[0.98]
          before:absolute before:inset-0
          before:bg-gradient-to-br before:from-[#8B0000] before:via-[#FFA500] before:to-[#FFD700]
          before:opacity-0 before:transition-opacity before:duration-500
          hover:before:opacity-100">

            <span class="relative z-10 flex items-center gap-2">
              <i class="fa-solid fa-user-shield text-base sm:text-lg transform transition-all duration-500 group-hover:rotate-[-12deg] group-hover:scale-110"></i>
              <span class="transition-all duration-300 group-hover:tracking-wide">Admin</span>
            </span>

            <!-- Shine effect -->
            <div class="absolute inset-0 -translate-x-full group-hover:translate-x-full transition-transform duration-1000 ease-in-out bg-gradient-to-r from-transparent via-white/30 to-transparent"></div>
          </a>

        </div>

        <!-- New: Redirect to Registration -->
        <p class="mt-4 sm:mt-6 text-center text-xs sm:text-sm text-[#757575]">
          Don't have an account?
          <a href="/register" class="text-[#8B0000] font-bold hover:underline">Register here</a>
        </p>

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

      // Trigger animation
      setTimeout(() => {
        toast.classList.add('show');
      }, 10);

      // Auto hide after 3 seconds
      setTimeout(() => {
        toast.classList.remove('show');
        toast.classList.add('hide');
        setTimeout(() => {
          toast.remove();
        }, 300);
      }, 3000);
    }

    /* ===== PASSWORD ===== */
    function togglePassword() {
      const passwordInput = document.getElementById('password');
      const eyeIcon = document.getElementById('eyeIcon');

      // Add blink animation
      if (passwordInput.type === 'password') {
        eyeIcon.classList.add('closing');

        setTimeout(() => {
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
          eyeIcon.classList.remove('closing');
        }, 150);
      } else {
        eyeIcon.classList.add('opening');

        setTimeout(() => {
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
          eyeIcon.classList.remove('opening');
        }, 150);
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