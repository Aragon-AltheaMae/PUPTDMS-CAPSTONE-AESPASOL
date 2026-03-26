<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dentist Portal | PUP Taguig Dental Clinic')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>

    <script>
        tailwind.config = {
            daisyui: {
                themes: false
            }
        }
    </script>

    <style>
        body {
            background-color: #F4F4F4;
            color: #333333;
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
            margin: 0;
        }
    </style>

    @include('partials.dentist.styles')
    @include('partials.terms-styles')
    @include('partials.global-toast-styles')

    @yield('styles')

</head>

<body class="@yield('body-class', 'bg-[#F4F4F4]')">

    @include('partials.dentist.header')
    @include('partials.dentist.sidebar')
    @include('partials.dentist.drawer')

    @yield('content')

    @include('partials.footer')

    @include('partials.dentist.scripts')

    @include('partials.voice-logic')

    <script src="https://cdn.jsdelivr.net/npm/sienna-accessibility@latest/dist/sienna-accessibility.umd.js" defer></script>

    @include('partials.global-toast')

    {{-- GLOBAL TERMS MODAL --}}
    @include('partials.terms-modal')
    @include('partials.terms-scripts')

    @stack('scripts')
    @yield('scripts')

</body>

</html>
