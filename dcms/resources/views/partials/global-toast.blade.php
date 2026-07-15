<div id="toastContainer" role="region" aria-live="polite"></div>

@php
    $flashToasts = [];

    if (session('success')) {
        $flashToasts[] = [
            'type' => 'success',
            'title' => 'Success',
            'message' => session('success'),
        ];
    }

    if (session('error')) {
        $flashToasts[] = [
            'type' => 'error',
            'title' => 'Error',
            'message' => session('error'),
        ];
    }

    if ($errors->any()) {
        $flashToasts[] = [
            'type' => 'error',
            'title' => 'Validation Error',
            'message' => $errors->first(),
        ];
    }

    if (session('login_as')) {
        $flashToasts[] = [
            'type' => 'success',
            'title' => 'Login Successful',
            'message' => 'Logged in successfully as <strong>' . session('login_as') . '</strong>',
        ];
    }

    if (request('reason') === 'idle') {
        $flashToasts[] = [
            'type' => 'warning',
            'title' => 'Session Timeout',
            'message' => 'Your session ended after 10 minutes of inactivity. Please sign in again.',
        ];
    } elseif (request()->boolean('logged_out')) {
        $flashToasts[] = [
            'type' => 'success',
            'title' => 'Signed Out',
            'message' => 'You have been signed out successfully.',
        ];
    }
@endphp

<script type="application/json" id="flashToastPayload">
{!! json_encode($flashToasts, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE) !!}
</script>

<script>
    (function () {
        const iconMap = {
            success: 'fa-solid fa-circle-check',
            error: 'fa-solid fa-circle-xmark',
            warning: 'fa-solid fa-triangle-exclamation',
            info: 'fa-solid fa-circle-info',
        };

        const escapeHtml = (value) => String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');

        const createToast = (toast) => {
            const container = document.getElementById('toastContainer');

            if (!container || !toast?.message) {
                return;
            }

            const type = ['success', 'error', 'warning', 'info'].includes(toast.type) ? toast.type : 'info';
            const item = document.createElement('div');
            item.className = `toast-item toast-${type}`;

            item.innerHTML = `
                <div class="toast-icon-wrap">
                    <i class="${iconMap[type]}"></i>
                </div>
                <div class="toast-content">
                    <div class="toast-title">${escapeHtml(toast.title || 'Notice')}</div>
                    <div class="toast-message">${toast.message}</div>
                </div>
                <button type="button" class="toast-close" aria-label="Dismiss notification">
                    <i class="fa-solid fa-xmark"></i>
                </button>
                <span class="toast-progress"></span>
            `;

            const removeToast = () => {
                if (item.dataset.closing === '1') {
                    return;
                }

                item.dataset.closing = '1';
                item.classList.add('toast-exit');
                window.setTimeout(() => item.remove(), 260);
            };

            const progress = item.querySelector('.toast-progress');
            if (progress) {
                progress.style.animationDuration = `${toast.duration || 5000}ms`;
            }

            item.querySelector('.toast-close')?.addEventListener('click', removeToast);
            item.addEventListener('mouseenter', () => item.classList.add('is-paused'));
            item.addEventListener('mouseleave', () => item.classList.remove('is-paused'));

            container.appendChild(item);
            window.setTimeout(removeToast, toast.duration || 5000);
        };

        const bootToasts = () => {
            const payload = document.getElementById('flashToastPayload');

            if (!payload || payload.dataset.booted === '1') {
                return;
            }

            payload.dataset.booted = '1';

            let toasts = [];

            try {
                toasts = JSON.parse(payload.textContent || '[]');
            } catch (error) {
                console.error('Failed to parse flash toast payload.', error);
            }

            toasts.forEach((toast, index) => {
                window.setTimeout(() => createToast(toast), index * 120);
            });
        };

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', bootToasts, { once: true });
        } else {
            bootToasts();
        }

        window.showGlobalToast = createToast;
    })();
</script>
