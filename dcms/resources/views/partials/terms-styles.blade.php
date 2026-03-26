<style>
    #termsModal {
        border: none;
        padding: 0;
        border-radius: 18px;
        width: min(94vw, 480px);
        box-shadow: 0 24px 60px rgba(0, 0, 0, .2);
        overflow: hidden;
    }

    #termsModal::backdrop {
        background: rgba(0, 0, 0, .55);
        backdrop-filter: blur(4px);
    }

    .terms-header {
        background: linear-gradient(135deg, #6b0000 0%, #8B0000 100%);
        padding: 20px 22px 18px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .terms-header-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: rgba(255, 255, 255, .15);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .terms-header-icon i {
        font-size: 15px;
        color: rgba(255, 255, 255, .9);
    }

    .terms-header h2 {
        color: #fff;
        font-size: 1rem;
        font-weight: 800;
        margin: 0;
    }

    .terms-header p {
        color: rgba(255, 255, 255, .6);
        font-size: .7rem;
        margin: 2px 0 0;
    }

    .terms-body {
        padding: 20px 24px 18px;
    }

    .terms-body p {
        font-size: .83rem;
        color: #4b5563;
        line-height: 1.75;
        margin-bottom: 10px;
    }

    .terms-body strong {
        color: #1f2937;
        font-weight: 700;
    }

    .terms-divider {
        height: 1px;
        background: #f0e8e8;
        margin: 4px 0 14px;
    }

    .terms-checkbox-row {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        background: #fdf5f5;
        border: 1px solid #fce8e8;
        border-radius: 10px;
        padding: 11px 13px;
        margin-bottom: 18px;
        cursor: pointer;
    }

    .terms-checkbox-row input[type="checkbox"] {
        margin-top: 2px;
        cursor: pointer;
        accent-color: #8B0000;
        width: 14px;
        height: 14px;
        flex-shrink: 0;
    }

    .terms-checkbox-row span {
        font-size: .8rem;
        font-weight: 600;
        color: #374151;
        line-height: 1.5;
    }

    .terms-actions {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
    }

    .terms-cancel-btn {
        padding: 8px 18px;
        border-radius: 9px;
        border: 1px solid #e5e7eb;
        background: #f9fafb;
        color: #6b7280;
        font-weight: 600;
        font-size: .8rem;
        cursor: pointer;
        transition: all .15s;
        font-family: 'Inter', sans-serif;
    }

    .terms-cancel-btn:hover {
        background: #f3f4f6;
        color: #374151;
    }

    .terms-continue-btn {
        padding: 8px 20px;
        border-radius: 9px;
        border: none;
        background: #9ca3af;
        color: white;
        font-weight: 700;
        font-size: .8rem;
        cursor: not-allowed;
        transition: all .2s;
        font-family: 'Inter', sans-serif;
    }

    .terms-continue-btn:not(:disabled) {
        background: #8B0000;
        cursor: pointer;
        box-shadow: 0 2px 10px rgba(139, 0, 0, .3);
    }

    .terms-continue-btn:not(:disabled):hover {
        background: #6b0000;
        box-shadow: 0 4px 14px rgba(139, 0, 0, .4);
    }

    /* Dark Mode */
    [data-theme="dark"] #termsModal {
        background: #161b22;
    }

    [data-theme="dark"] .terms-body p {
        color: #9ca3af;
    }

    [data-theme="dark"] .terms-body strong {
        color: #e5e7eb;
    }

    [data-theme="dark"] .terms-divider {
        background: #21262d;
    }

    [data-theme="dark"] .terms-checkbox-row {
        background: #1c1c1c;
        border-color: #2d1a1a;
    }

    [data-theme="dark"] .terms-checkbox-row span {
        color: #d1d5db;
    }

    [data-theme="dark"] .terms-cancel-btn {
        background: #1f2937;
        border-color: #374151;
        color: #9ca3af;
    }

    [data-theme="dark"] .terms-cancel-btn:hover {
        background: #374151;
        color: #e5e7eb;
    }
</style>
