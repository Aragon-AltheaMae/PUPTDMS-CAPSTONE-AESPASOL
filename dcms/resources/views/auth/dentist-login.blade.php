<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dentist Login | PUP Taguig Dental Clinic</title>

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- DaisyUI -->
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" />

  <!-- Inter Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <script>
    tailwind.config = {
      daisyui: { themes: false },
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
    body { font-family: 'Inter'; }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(8px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .fade-in {
      animation: fadeIn 0.6s ease-out forwards;
    }
  </style>
</head>

<body class="min-h-screen bg-gradient-to-r from-[#8B0000] to-[#F2B233] flex items-center justify-center">

  <div class="fade-in bg-white w-[420px] rounded-3xl shadow-2xl px-10 py-12">

    <!-- Header -->
    <div class="text-center mb-8">
      <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-[#8B0000] to-[#F2B233]">
        Dentist Portal
      </h1>
      <p class="text-sm text-gray-500 mt-2">
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
          <span class="label-text text-sm font-medium">Username</span>
        </label>
        <input type="text" name="email" required
               class="input input-bordered w-full focus:outline-none focus:ring-2 focus:ring-[#F2B233]" />
      </div>

      <div>
        <label class="label">
          <span class="label-text text-sm font-medium">Password</span>
        </label>
        <input type="password" name="password" required
               class="input input-bordered w-full focus:outline-none focus:ring-2 focus:ring-[#F2B233]" />
      </div>

      <button type="submit"
        class="btn w-full rounded-xl text-white font-semibold
               bg-gradient-to-r from-[#8B0000] to-[#F2B233]
               hover:opacity-90 transition">
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

</body>
</html>
