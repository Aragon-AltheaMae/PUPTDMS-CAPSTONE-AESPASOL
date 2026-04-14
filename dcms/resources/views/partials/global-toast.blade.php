<div id="toastContainer" role="region" aria-live="polite"></div>

<script>
    function showToast(title, message, type) {
        type = type || 'error';
        var container = document.getElementById('toastContainer');
        if (!container) return;

        var t = document.createElement('div');
        t.className = 'custom-toast ' + type;

        var icon = type === 'error' ?
            '<i class="fa-solid fa-circle-exclamation toast-icon-wrap"></i>' :
            '<i class="fa-solid fa-circle-check toast-icon-wrap"></i>';

        t.innerHTML = '<div class="toast-icon-wrap">' + icon + '</div>' +
            '<div class="toast-body"><div class="toast-title">' + title + '</div>' +
            '<div class="toast-msg">' + message + '</div></div>' +
            '<button class="toast-close" onclick="this.closest(\'.custom-toast\').classList.add(\'hide\')">' +
            '<i class="fa-solid fa-xmark"></i></button>';

        container.appendChild(t);
        requestAnimationFrame(() => requestAnimationFrame(() => t.classList.add('show')));
        setTimeout(() => {
            t.classList.remove('show');
            t.classList.add('hide');
            setTimeout(() => t.remove(), 400);
        }, 4500);
    }

    document.addEventListener('DOMContentLoaded', function() {
        @if (session('success'))
            showToast('Success', '{!! addslashes(session('success')) !!}', 'success');
        @endif

        @if (session('error'))
            showToast('Error', '{!! addslashes(session('error')) !!}', 'error');
        @endif

        @if (session('login_as'))
            showToast('Login Successful', 'Logged in successfully as <strong>{!! addslashes(session('login_as')) !!}</strong>',
                'success');
        @endif
    });
</script>
