function initGlobalDateTime() {
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

        dateEl.textContent = `${dateText} | ${timeText}`;

        if (!dateIconEl) return;

        const hourInManila = Number(new Intl.DateTimeFormat('en-US', {
            timeZone: 'Asia/Manila',
            hour: 'numeric',
            hour12: false
        }).format(now));

        if (hourInManila >= 5 && hourInManila < 18) {
            dateIconEl.className = 'fa-solid fa-sun';
            dateIconEl.style.color = hourInManila < 12 ? '#fcd34d' : '#fb923c';
        } else {
            dateIconEl.className = 'fa-solid fa-moon';
            dateIconEl.style.color = '#c4b5fd';
        }
    }

    updateDateTime();
    setInterval(updateDateTime, 60000);
}

function initPatientMobileFab() {
    const mobFab = document.getElementById('mobFab');
    const mobFabMenu = document.getElementById('mobFabMenu');

    if (!mobFab || !mobFabMenu) return;

    mobFab.addEventListener('click', event => {
        event.stopPropagation();

        window.closeHeaderMenus?.();

        mobFabMenu.classList.toggle('open');
        mobFab.classList.toggle('open');
    });

    mobFabMenu.addEventListener('click', event => {
        event.stopPropagation();
    });

    document.addEventListener('click', event => {
        const clickedInsideMenu = mobFabMenu.contains(event.target);
        const clickedFab = mobFab.contains(event.target);

        if (!clickedInsideMenu && !clickedFab) {
            mobFabMenu.classList.remove('open');
            mobFab.classList.remove('open');
        }
    });

    document.querySelectorAll('[data-quick-action]').forEach(button => {
        if (button.dataset.quickActionInitialized === 'true') return;

        button.dataset.quickActionInitialized = 'true';

        button.addEventListener('click', event => {
            event.preventDefault();
            event.stopPropagation();

            mobFabMenu.classList.remove('open');
            mobFab.classList.remove('open');

            if (typeof window.openQuickAction === 'function') {
                window.openQuickAction(button.dataset.quickAction);
            }
        });
    });
}

document.addEventListener(
    'DOMContentLoaded',
    () => {
        initGlobalDateTime();
        initPatientMobileFab();
    }
);