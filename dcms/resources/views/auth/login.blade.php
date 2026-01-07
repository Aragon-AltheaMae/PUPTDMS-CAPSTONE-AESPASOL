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

<body class="font-inter min-h-screen bg-gradient-to-r from-[#8B0000] to-[#F2B233] flex items-center justify-center">

<div class="bg-[#8B0000] p-5 rounded-[1.75rem] shadow-2xl">
  <div class="flex w-[1100px] h-[600px] bg-white rounded-[1.5rem] overflow-hidden max-w-[95vw] max-h-[95vh] flex-col lg:flex-row">

    <!-- Left Image -->
    <div class="flex-[1.2] h-60 lg:h-auto">
      <img src="{{ asset('images/PUP TAGUIG CAMPUS.jpg') }}" alt="Campus" class="w-full h-full object-cover">
    </div>

    <!-- Right Panel -->
    <div class="flex-[0.8] px-10 py-16 flex flex-col justify-center">

                <h1 class="text-center font-extrabold tracking-wide drop-shadow-lg">
        <span class="block text-4xl lg:text-5xl text-transparent bg-clip-text bg-gradient-to-r from-[#FFD166] to-[#8B0000]">
            PUP-TAGUIG
        </span>
        <span class="block text-2xl lg:text-3xl text-[#F2B233] mt-2">
            DENTAL CLINIC
        </span>
        </h1>

            <p class="text-center text-gray-600 mt-4 text-base">Log In to your account</p>


      {{-- Login Form --}}
      <form method="POST" action="{{ route('login') }}">
        @csrf

        <label class="text-sm font-medium mb-1">Email</label>
        <input type="email" name="email" required
          class="w-full px-4 py-3 rounded-lg bg-gray-100 mb-6 focus:outline-none focus:ring-2 focus:ring-[#F2B233]">

        <label class="text-sm font-medium mb-1">Password</label>
        <div class="relative mb-6">
          <input id="password" type="password" name="password" required
            class="w-full px-4 py-3 rounded-lg bg-gray-100 pr-12 focus:outline-none focus:ring-2 focus:ring-[#F2B233]">

          <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
          </button>
        </div>

        <button type="submit"
          class="mt-4 w-full py-3 rounded-xl bg-gradient-to-r from-[#FFD166] to-[#8B0000] text-white font-semibold hover:opacity-90 transition">
          Log In
        </button>
      </form>

        <!-- New: Redirect to Registration -->
        <p class="mt-6 text-center text-sm text-gray-600">
        Don't have an account?
        <a href="/register" class="text-[#F2B233] font-semibold hover:underline">Register here</a>
        </p>

        <p class="mt-4 text-center text-sm text-gray-600">
    Are you a dentist?
    <a href="{{ route('dentist.login') }}"
       class="text-[#8B0000] font-semibold hover:underline">
        Log in as Dentist
    </a>
</p>

    </div>

    </div>
  </div>
</div>

<script>
function togglePassword() {
  const p = document.getElementById('password');
  p.type = p.type === 'password' ? 'text' : 'password';
}
</script>

</body>
</html>
