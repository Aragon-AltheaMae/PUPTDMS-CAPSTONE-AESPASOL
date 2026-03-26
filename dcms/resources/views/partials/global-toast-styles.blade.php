<style>
    #toastContainer {
        position: fixed;
        top: 80px;
        right: 24px;
        bottom: auto;
        z-index: 99999;
        display: flex;
        flex-direction: column;
        gap: 12px;
        pointer-events: none;
    }

    .custom-toast {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 18px;
        min-width: 280px;
        max-width: 380px;
        transform: translateX(120%);
        opacity: 0;
        transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        pointer-events: auto;
        border-left: 4px solid #333;
    }

    .custom-toast.show {
        transform: translateX(0);
        opacity: 1;
    }

    .custom-toast.hide {
        transform: translateX(120%);
        opacity: 0;
    }

    .custom-toast.success {
        border-left-color: #10B981;
    }

    .custom-toast.error {
        border-left-color: #EF4444;
    }

    .custom-toast.success .toast-icon-wrap {
        color: #10B981;
        font-size: 22px;
    }

    .custom-toast.error .toast-icon-wrap {
        color: #EF4444;
        font-size: 22px;
    }

    .toast-body {
        flex: 1;
    }

    .toast-title {
        font-size: 14px;
        font-weight: 800;
        color: #1f2937;
    }

    .toast-msg {
        font-size: 12px;
        color: #6b7280;
        margin-top: 2px;
        line-height: 1.4;
    }

    .toast-close {
        background: none;
        border: none;
        color: #9ca3af;
        cursor: pointer;
        font-size: 16px;
        transition: color 0.2s;
    }

    .toast-close:hover {
        color: #374151;
    }

    /* Dark Mode Support */
    [data-theme="dark"] .custom-toast {
        background: #1f2937;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
    }

    [data-theme="dark"] .toast-title {
        color: #f3f4f6;
    }

    [data-theme="dark"] .toast-msg {
        color: #9ca3af;
    }

    [data-theme="dark"] .toast-close:hover {
        color: #f3f4f6;
    }
</style>
