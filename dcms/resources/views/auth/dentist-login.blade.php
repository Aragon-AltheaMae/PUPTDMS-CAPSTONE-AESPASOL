<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dentist Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex items-center justify-center bg-[#8B0000]">

<div class="bg-white p-10 rounded-2xl shadow-xl w-[400px]">
    <h2 class="text-2xl font-bold text-center text-[#8B0000] mb-6">
        Dentist Login
    </h2>

    @if(session('error'))
        <p class="text-red-600 text-sm mb-4 text-center">
            {{ session('error') }}
        </p>
    @endif

    <form method="POST" action="{{ route('dentist.login.submit') }}">
        @csrf

        <label class="block text-sm mb-1">Username</label>
        <input type="text" name="email" required
               class="w-full mb-4 px-4 py-2 rounded bg-gray-100">

        <label class="block text-sm mb-1">Password</label>
        <input type="password" name="password" required
               class="w-full mb-6 px-4 py-2 rounded bg-gray-100">

        <button type="submit"
                class="w-full py-2 bg-[#8B0000] text-white rounded hover:opacity-90">
            Log In
        </button>
    </form>

    <p class="mt-4 text-center text-sm">
        <a href="/login" class="text-[#8B0000] hover:underline">
            ← Back to Patient Login
        </a>
    </p>
</div>

</body>
</html>
