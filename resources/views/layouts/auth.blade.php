<!DOCTYPE html>
<html lang="en" data-theme="{{ session('theme', 'light') }}">

<head>
    <meta charset="UTF-8" />
    <title>@yield('title', 'PUP Taguig Dental Clinic')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        (function() {
            const theme = localStorage.getItem('theme') || 'light';
            if (theme === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
                document.documentElement.classList.add('dark');
                document.documentElement.style.backgroundColor = '#0F172A';
            } else {
                document.documentElement.setAttribute('data-theme', 'light');
                document.documentElement.classList.remove('dark');
                document.documentElement.style.backgroundColor = '#F8F9FA';
            }
        })();
    </script>

    <script>
        window.chatbotContext = {
            page: 'login',
            pageLabel: 'Login page',
            isGuest: true
        };
    </script>

    @yield('styles')
</head>

<body>
    <div class="auth-container">
        @yield('content')
        @include('partials.global-toast')
        @include('partials.voice-logic')
        @include('partials.chatbot')

        {{-- Sienna Accessibility Widget --}}
        <script src="https://cdn.jsdelivr.net/npm/sienna-accessibility@latest/dist/sienna-accessibility.umd.js"
            data-position="bottom-right" data-offset="18,118" defer></script>


        @include('partials.footer')
    </div>

    <script>
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        const html = document.documentElement;

        if (themeToggle && themeIcon) {
            function updateThemeIcon() {
                const isDark = html.getAttribute('data-theme') === 'dark';
                themeIcon.classList = isDark ? 'fas fa-sun' : 'fas fa-moon';
            }

            themeToggle.addEventListener('click', () => {
                const currentTheme = html.getAttribute('data-theme') || 'light';
                const newTheme = currentTheme === 'light' ? 'dark' : 'light';

                html.setAttribute('data-theme', newTheme);
                html.classList.toggle('dark', newTheme === 'dark');
                localStorage.setItem('theme', newTheme);

                if (newTheme === 'dark') {
                    html.style.backgroundColor = '#0F172A';
                } else {
                    html.style.backgroundColor = '#F8F9FA';
                }

                updateThemeIcon();
            });

            updateThemeIcon();
        }
    </script>

    @yield('scripts')
</body>

</html>
