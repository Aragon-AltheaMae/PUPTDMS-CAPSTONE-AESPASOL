<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @if(auth()->check())
        <meta name="auth-user-id" content="{{ auth()->id() }}">
    @endif

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dental Clinic</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="role-{{ $role ?? (optional(optional(auth()->user())->role)->slug ?? 'patient') }}">
    <div class="container">
        @yield('content')
    </div>
</body>

</html>