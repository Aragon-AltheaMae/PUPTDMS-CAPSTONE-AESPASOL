<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        @yield('title', 'Page Unavailable')
        — PUP Taguig Dental Clinic
    </title>

    <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">

    @vite('resources/css/pages/error-pages.css')
</head>

<body class="error-page error-page--@yield('tone', 'general')">

    @php
        $primaryUrl = trim($__env->yieldContent('primary_url')) ?: url('/');

        $primaryLabel = trim($__env->yieldContent('primary_label')) ?: 'Return Home';
    @endphp

    <main class="error-stage">

        <div class="error-ripples" aria-hidden="true">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>

        <section class="error-panel" aria-labelledby="errorPageTitle">

            <header class="error-panel__header">

                <a href="{{ url('/') }}" class="error-brand" aria-label="Return to PUP Taguig Dental Clinic">

                    <span class="error-brand__logo">
                        <img src="{{ asset('images/PUPT-DMS-Logo.png') }}" alt="">
                    </span>

                    <span class="error-brand__copy">
                        <strong>
                            PUP Taguig Dental Clinic
                        </strong>

                        <small>
                            Dental Management System
                        </small>
                    </span>
                </a>

                <span class="error-reference-badge">
                    Reference @yield('code')
                </span>
            </header>

            <div class="error-panel__body">

                <div class="error-symbol">
                    @yield('notice_icon')
                </div>

                <p class="error-eyebrow">
                    @yield('label')
                </p>

                <h1 id="errorPageTitle" class="error-heading">

                    @yield('message')
                </h1>

                <p class="error-description">
                    @yield('description')
                </p>

                <div class="error-guidance">
                    <span class="error-guidance__icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                            aria-hidden="true">

                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 3a7 7 0 0 0-4 12.75V19h8v-3.25A7 7 0 0 0 12 3Z">
                            </path>

                            <path stroke-linecap="round" d="M9.5 22h5">
                            </path>
                        </svg>
                    </span>

                    <p>
                        @yield('notice_text')
                    </p>
                </div>

                <div class="error-actions">

                    <a href="{{ $primaryUrl }}" class="error-action error-action--primary">

                        <i class="fa-solid fa-house" aria-hidden="true"></i>

                        <span>
                            {{ $primaryLabel }}
                        </span>
                    </a>

                    <button type="button" class="error-action error-action--secondary" onclick="history.back()">

                        <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>

                        <span>Go Back</span>
                    </button>

                </div>

                <p class="error-support">
                    Need help? Contact the system administrator and provide
                    reference code <strong>@yield('code')</strong>.
                </p>
            </div>
        </section>

    </main>
</body>

</html>
