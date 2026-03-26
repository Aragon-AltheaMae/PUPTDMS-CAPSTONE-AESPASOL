<script>
    /* DATE */
    document.addEventListener('DOMContentLoaded', function() {
        const dateEl = document.getElementById('currentDate');
        const dateIconEl = document.getElementById('currentDateIcon');

        if (!dateEl) return;

        function updateDateTime() {
            const now = new Date();

            const dateText = now.toLocaleDateString('en-US', {
                timeZone: 'Asia/Manila',
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });

            const timeText = now.toLocaleTimeString('en-US', {
                timeZone: 'Asia/Manila',
                hour: 'numeric',
                minute: '2-digit',
                hour12: true
            });

            dateEl.textContent = dateText + ' | ' + timeText;

            if (dateIconEl) {
                const hourInManila = Number(new Intl.DateTimeFormat('en-US', {
                    timeZone: 'Asia/Manila',
                    hour: 'numeric',
                    hour12: false
                }).format(now));

                if (hourInManila >= 5 && hourInManila < 12) {
                    dateIconEl.className = 'fa-solid fa-sun';
                    dateIconEl.style.color = '#fcd34d';
                } else if (hourInManila >= 12 && hourInManila < 18) {
                    dateIconEl.className = 'fa-solid fa-sun';
                    dateIconEl.style.color = '#fb923c';
                } else {
                    dateIconEl.className = 'fa-solid fa-moon';
                    dateIconEl.style.color = '#c4b5fd';
                }
            }
        }

        updateDateTime();
        setInterval(updateDateTime, 1000);
    });

    /* NOTIF */
    document.getElementById('notifBtn').addEventListener('click', e => {
        e.stopPropagation();
        document.getElementById('notifMenu').classList.toggle('open');
    });
    document.addEventListener('click', () => document.getElementById('notifMenu').classList.remove('open'));

    /* USER DROPDOWN */
    document.getElementById('userBtn').addEventListener('click', e => {
        e.stopPropagation();
        document.getElementById('notifMenu').classList.remove('open'); // close notif if open
        document.getElementById('userMenu').classList.toggle('open');
    });
    document.addEventListener('click', () => document.getElementById('userMenu').classList.remove('open'));

    /* Sync user menu theme toggle */
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('#userMenuThemeToggle .theme-option').forEach(o =>
            o.addEventListener('click', e => {
                e.stopPropagation();
                applyTheme(o.getAttribute('data-theme'));
            })
        );
    });

    /* THEME */
    const html = document.documentElement;

    function applyTheme(theme) {
        html.setAttribute('data-theme', theme);
        localStorage.setItem('theme', theme);
        document.querySelectorAll('.theme-option').forEach(o =>
            o.getAttribute('data-theme') === theme ? o.classList.add('active') : o.classList.remove('active')
        );
        document.querySelectorAll('.theme-indicator').forEach(ind =>
            theme === 'dark' ? ind.classList.add('dark-mode') : ind.classList.remove('dark-mode')
        );
    }
    document.addEventListener('DOMContentLoaded', () => {
        applyTheme(localStorage.getItem('theme') || 'light');
        document.querySelectorAll('.theme-option').forEach(o =>
            o.addEventListener('click', e => {
                e.stopPropagation();
                applyTheme(o.getAttribute('data-theme'));
            })
        );
    });

    /* MOBILE DRAWER */
    function openDrawer() {
        const drawer = document.getElementById('mobileDrawer');
        const overlay = document.getElementById('mobileDrawerOverlay');
        overlay.style.display = 'block';
        requestAnimationFrame(() => {
            overlay.classList.add('open');
            drawer.classList.add('open');
        });
        document.body.style.overflow = 'hidden';
    }

    function closeDrawer() {
        const drawer = document.getElementById('mobileDrawer');
        const overlay = document.getElementById('mobileDrawerOverlay');
        drawer.classList.remove('open');
        overlay.classList.remove('open');
        setTimeout(() => {
            overlay.style.display = 'none';
        }, 250);
        document.body.style.overflow = '';
    }
    document.getElementById('mobileMenuBtn')?.addEventListener('click', e => {
        e.stopPropagation();
        openDrawer();
    });
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeDrawer();
    });
</script>
