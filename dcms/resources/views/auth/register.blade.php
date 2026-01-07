<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Patient Registration</title>

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

<body class="font-inter min-h-screen bg-gradient-to-r from-primary to-[#F2B233] flex items-center justify-center">

<div class="bg-primary p-5 rounded-[1.75rem] shadow-2xl">
  <div class="flex w-[1100px] h-[650px] bg-white rounded-[1.5rem] overflow-hidden max-w-[95vw] max-h-[95vh] flex-col lg:flex-row">

    <!-- Left Image -->
    <div class="flex-[1.2] h-60 lg:h-auto">
      <img src="/images/PUP TAGUIG CAMPUS.jpg" class="w-full h-full object-cover">
    </div>

    <!-- Right Panel -->
    <div class="flex-[0.8] px-10 py-12 overflow-y-auto">

      <h1 class="text-4xl font-extrabold text-accent text-center mb-2">Create Account</h1>
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
          <input type="password" name="password" required
            class="w-full px-4 py-2 rounded-lg bg-lightbg border border-mediumgray focus:ring-2 focus:ring-primary">
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Confirm Password</label>
          <input type="password" name="password_confirmation" required
            class="w-full px-4 py-2 rounded-lg bg-lightbg border border-mediumgray focus:ring-2 focus:ring-primary">
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

</body>
</html>
