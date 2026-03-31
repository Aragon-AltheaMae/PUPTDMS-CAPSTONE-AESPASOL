document.addEventListener('DOMContentLoaded', function () {

    const notifBtn = document.getElementById('notifBtn');
    const notifMenu = document.getElementById('notifMenu');
    const notifDropdown = document.getElementById('notifDropdown');

    const userBtn = document.getElementById('userBtn');
    const userMenu = document.getElementById('userMenu');
    const userDropdown = document.getElementById('userDropdown');

    function closeMenus(except = null) {
        if (notifMenu && except !== 'notif') notifMenu.classList.remove('show');
        if (userMenu && except !== 'user') userMenu.classList.remove('show');
    }

    if (notifBtn && notifMenu) {
        notifBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            const isOpen = notifMenu.classList.contains('show');
            closeMenus();
            if (!isOpen) notifMenu.classList.add('show');
        });
    }

    if (userBtn && userMenu) {
        userBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            const isOpen = userMenu.classList.contains('show');
            closeMenus();
            if (!isOpen) userMenu.classList.add('show');
        });
    }

    document.addEventListener('click', function (e) {
        if (notifDropdown && !notifDropdown.contains(e.target)) {
            notifMenu?.classList.remove('show');
        }

        if (userDropdown && !userDropdown.contains(e.target)) {
            userMenu?.classList.remove('show');
        }
    });

    const themeCheckbox = document.getElementById('themeSwitchCheckbox');
    const themeIcon = document.getElementById('themeIcon');

    if (themeCheckbox && themeIcon) {
        const currentTheme = localStorage.getItem('theme') || 'light';

        if (currentTheme === 'dark') {
            themeCheckbox.checked = true;
            document.documentElement.setAttribute('data-theme', 'dark');
            themeIcon.className = 'fa-solid fa-moon text-gray-400 text-base';
        } else {
            themeCheckbox.checked = false;
            document.documentElement.setAttribute('data-theme', 'light');
            themeIcon.className = 'fa-regular fa-sun text-gray-400 text-base';
        }

        themeCheckbox.addEventListener('change', (e) => {
            if (e.target.checked) {
                document.documentElement.setAttribute('data-theme', 'dark');
                localStorage.setItem('theme', 'dark');
                themeIcon.className = 'fa-solid fa-moon text-gray-400 text-base';
            } else {
                document.documentElement.setAttribute('data-theme', 'light');
                localStorage.setItem('theme', 'light');
                themeIcon.className = 'fa-regular fa-sun text-gray-400 text-base';
            }
        });
    }
});