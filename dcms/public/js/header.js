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

    const themeToggle = document.getElementById('userMenuThemeToggle');
    if (themeToggle) {
        const options = themeToggle.querySelectorAll('.theme-option');

        options.forEach(option => {
            option.addEventListener('click', function () {
                options.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                const selectedTheme = this.dataset.theme;

                if (selectedTheme === 'dark') {
                    themeToggle.classList.add('dark-active');
                    document.documentElement.setAttribute('data-theme', 'dark');
                    localStorage.setItem('theme', 'dark');
                } else {
                    themeToggle.classList.remove('dark-active');
                    document.documentElement.setAttribute('data-theme', 'light');
                    localStorage.setItem('theme', 'light');
                }
            });
        });

        const savedTheme = localStorage.getItem('theme') || 'light';
        const activeBtn = themeToggle.querySelector(`[data-theme="${savedTheme}"]`);

        options.forEach(btn => btn.classList.remove('active'));
        activeBtn?.classList.add('active');

        if (savedTheme === 'dark') {
            themeToggle.classList.add('dark-active');
            document.documentElement.setAttribute('data-theme', 'dark');
        } else {
            themeToggle.classList.remove('dark-active');
            document.documentElement.setAttribute('data-theme', 'light');
        }
    }
});