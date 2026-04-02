<style>
    :root {
        --crimson: #8B0000;
        --crimson-dark: #6b0000;
        --crimson-light: #fef2f2;
        --crimson-mid: #fce8e8;
        --sidebar-w: 220px;
        --header-h: 64px;
    }

    body {
        font-family: 'Inter';
    }

    html.sidebar-preload #sidebar,
    html.sidebar-preload #mainContent {
        transition: none !important;
    }

    html.sidebar-collapsed-init #sidebar {
        width: 64px !important;
    }

    html.sidebar-collapsed-init #mainContent {
        margin-left: 64px !important;
    }

    html.sidebar-collapsed-init #sidebar .sidebar-nav-text,
    html.sidebar-collapsed-init #sidebar .nav-section-label {
        display: none;
    }

    html.sidebar-collapsed-init #sidebar .sidebar-nav-item {
        justify-content: center;
        width: 100%;
        padding: 8px 0;
        gap: 0;
        overflow: visible;
    }

    html.sidebar-collapsed-init #sidebar .toggle-row {
        justify-content: center !important;
    }

    .fade-in {
        animation: fadeIn .6s ease-out forwards;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(6px)
        }

        to {
            opacity: 1;
            transform: translateY(0)
        }
    }

    /* ════════ SIDEBAR ════════ */
    #sidebar {
        position: fixed;
        left: 0;
        top: var(--header-h);
        width: var(--sidebar-w);
        height: calc(100vh - var(--header-h));
        background: #fff;
        border-right: 1px solid #eff0f2;
        box-shadow: 4px 0 24px rgba(0, 0, 0, .04);
        z-index: 40;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .sidebar-inner {
        flex: 1;
        overflow-y: auto;
        padding: 16px 10px 8px;
    }

    .sidebar-nav-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 10px;
        border-radius: 10px;
        color: #4a5568;
        font-size: .78rem;
        font-weight: 600;
        transition: all .15s ease;
        white-space: nowrap;
        overflow: visible;
        position: relative;
    }

    .sidebar-tooltip {
        position: absolute;
        left: calc(100% + 12px);
        top: 50%;
        transform: translateY(-50%);
        background: linear-gradient(135deg, #8B0000, #6B0000);
        color: #ffffff;
        font-size: 12px;
        font-weight: 600;
        padding: 6px 10px;
        border-radius: 8px;
        white-space: nowrap;
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transition: opacity .18s ease, visibility .18s ease;
        box-shadow: 0 8px 24px rgba(0, 0, 0, .18);
        z-index: 9999;
    }

    #sidebar.collapsed .sidebar-nav-item:hover .sidebar-tooltip,
    #sidebar.collapsed .sidebar-nav-item:focus-visible .sidebar-tooltip {
        opacity: 1;
        visibility: visible;
    }

    #sidebar:not(.collapsed) .sidebar-tooltip {
        display: none;
    }

    #sidebar.collapsed {
        overflow: visible !important;
    }

    #sidebar.collapsed .sidebar-inner {
        padding-left: 8px;
        padding-right: 8px;
        overflow: visible !important;
    }

    #sidebar.collapsed nav {
        align-items: center;
        overflow: visible;
        position: relative;
    }

    #sidebar.collapsed .sidebar-nav-icon {
        margin: 0;
    }

    #sidebar.collapsed .toggle-row {
        justify-content: center !important;
    }

    .sidebar-nav-item:hover {
        background: #fef2f2;
        color: #8B0000;
    }

    .sidebar-nav-item.active {
        background: linear-gradient(135deg, #8B0000, #6b0000);
        color: #fff;
        box-shadow: 0 3px 10px rgba(139, 0, 0, .25);
    }

    .sidebar-nav-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: rgba(139, 0, 0, .07);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        color: #8B0000;
        flex-shrink: 0;
    }

    .sidebar-nav-item.active .sidebar-nav-icon {
        background: rgba(255, 255, 255, .2);
        color: #fff;
    }

    .nav-section-label {
        font-size: .6rem;
        font-weight: 800;
        color: #b0b7c3;
        text-transform: uppercase;
        letter-spacing: .1em;
        padding: 0 8px 6px;
        margin-top: 4px;
    }

    #sidebar.collapsed {
        width: 64px !important;
    }

    #sidebar.collapsed .sidebar-nav-text,
    #sidebar.collapsed .nav-section-label {
        display: none;
    }

    #sidebar.collapsed .sidebar-nav-item {
        justify-content: center;
        align-items: center;
        width: 100%;
        padding: 8px 0;
        gap: 0;
        overflow: visible;
    }

    #sidebar.collapsed .sidebar-tooltip {
        left: calc(100% + 12px);
    }

    /* ════════ MOBILE DRAWER ════════ */
    #mobileMenuBtn {
        display: none;
        background: rgba(255, 255, 255, .12);
        border: none;
        color: #fff;
        width: 36px;
        height: 36px;
        border-radius: 9px;
        cursor: pointer;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    #mobileDrawerOverlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .45);
        z-index: 998;
        backdrop-filter: blur(2px);
        opacity: 0;
        pointer-events: none;
        transition: opacity .25s;
    }

    #mobileDrawerOverlay.open {
        opacity: 1;
        pointer-events: auto;
    }

    #mobileDrawer {
        position: fixed;
        top: 0;
        left: 0;
        width: 280px;
        height: 100vh;
        background: #fff;
        z-index: 999;
        display: flex;
        flex-direction: column;
        transform: translateX(-100%);
        transition: transform .3s;
    }

    #mobileDrawer.open {
        transform: translateX(0);
    }

    .drawer-header {
        background: linear-gradient(135deg, var(--crimson-dark) 0%, var(--crimson) 100%);
        padding: 20px 18px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .drawer-brand {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .drawer-brand-text {
        font-size: .75rem;
        font-weight: 800;
        color: #fff;
        letter-spacing: .03em;
        line-height: 1.25;
        text-transform: uppercase;
    }

    .drawer-nav {
        flex: 1;
        overflow-y: auto;
        padding: 10px 10px 6px;
    }

    .drawer-section-label {
        font-size: .6rem;
        font-weight: 800;
        color: #b0b7c3;
        text-transform: uppercase;
        padding: 6px 8px 8px;
    }

    .drawer-nav-link {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 12px;
        border-radius: 10px;
        color: #4a5568;
        font-size: .8rem;
        font-weight: 600;
        transition: all .15s;
        margin-bottom: 3px;
    }

    .drawer-nav-link:hover {
        background: #fef2f2;
        color: #8B0000;
        transform: translateX(3px);
    }

    .drawer-nav-link.active {
        background: linear-gradient(135deg, #8B0000, #6b0000);
        color: #fff;
        box-shadow: 0 3px 12px rgba(139, 0, 0, .25);
    }

    .dnav-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: rgba(139, 0, 0, .08);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #8B0000;
    }

    .drawer-nav-link.active .dnav-icon {
        background: rgba(255, 255, 255, .2);
        color: #fff;
    }

    .drawer-footer {
        padding: 10px 12px 16px;
        border-top: 1px solid #f3f4f6;
    }

    .drawer-close-btn {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        background: rgba(255, 255, 255, .15);
        color: #fff;
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
        border: none;
    }

    /* ════════ MAIN CONTENT ════════ */
    #mainContent {
        margin-left: var(--sidebar-w);
        /* 220px by default */
        transition: margin-left 0.3s ease;
        /* Smooth sliding animation */
    }

    @media (max-width: 767px) {
        #sidebar {
            display: none !important;
        }

        #mainContent {
            margin-left: 0 !important;
        }

        #mobileMenuBtn {
            display: flex !important;
        }
    }


    [data-theme="dark"] body {
        background-color: #000D1A;
        color: #E5E7EB;
    }

    [data-theme="dark"] #sidebar {
        background-color: #000D1A;
        border-color: #1F1F1F;
    }

    [data-theme="dark"] .bg-white {
        background-color: #000D1A !important;
    }

    [data-theme="dark"] .text-\[\#333333\] {
        color: #E5E7EB !important;
    }

    .cancel-modal-panel,
    .reschedule-modal-panel {
        animation: modalUp .3s cubic-bezier(.34, 1.56, .64, 1) forwards;
    }

    @keyframes modalUp {
        from {
            opacity: 0;
            transform: translateY(24px) scale(.97);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .cancel-icon-ring {
        position: relative;
        width: 72px;
        height: 72px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .cancel-icon-ring::before,
    .cancel-icon-ring::after {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 50%;
        border: 2px solid rgba(220, 38, 38, .35);
        animation: ringPulse 2s ease-out infinite;
    }

    .cancel-icon-ring::after {
        animation-delay: .7s;
    }

    .cancel-icon-core {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: linear-gradient(135deg, #fef2f2, #fee2e2);
        border: 2px solid #fca5a5;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 16px rgba(220, 38, 38, .2);
        z-index: 1;
    }

    .reschedule-icon-ring,
    .reschedule-icon-core {
        all: unset;
    }

    .reason-chip input[type="radio"] {
        display: none;
    }

    .reason-chip label {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 9999px;
        border: 1.5px solid #e5e7eb;
        font-size: 12px;
        font-weight: 500;
        color: #6b7280;
        cursor: pointer;
        transition: all .15s;
        background: white;
        user-select: none;
    }

    .reason-chip label:hover {
        border-color: #fca5a5;
        color: #9f1239;
        background: #fff1f2;
    }

    .reason-chip input[type="radio"]:checked+label {
        border-color: #dc2626;
        background: #fef2f2;
        color: #dc2626;
        font-weight: 600;
        box-shadow: 0 2px 6px rgba(220, 38, 38, .15);
    }

    @keyframes errorShake {

        0%,
        100% {
            transform: translateX(0);
        }

        20% {
            transform: translateX(-5px);
        }

        40% {
            transform: translateX(5px);
        }

        60% {
            transform: translateX(-3px);
        }

        80% {
            transform: translateX(3px);
        }
    }

    .chips-error-shake {
        animation: errorShake .35s ease;
    }

    @keyframes ringPulse {
        0% {
            transform: scale(.85);
            opacity: .8;
        }

        100% {
            transform: scale(1.5);
            opacity: 0;
        }
    }

    /* ===== Shared modal mobile polish ===== */
    @media (max-width: 640px) {

        #cancelAppointmentModal,
        #rescheduleModal {
            align-items: flex-end !important;
        }

        .cancel-modal-panel,
        .reschedule-modal-panel {
            width: 100% !important;
            max-width: 100% !important;
            min-height: auto;
            max-height: 92vh;
            border-radius: 20px 20px 0 0 !important;
            overflow: hidden;
        }

        #cancelAppointmentModal>.cancel-modal-panel,
        #rescheduleModal>.reschedule-modal-panel {
            display: flex;
            flex-direction: column;
        }

        #cancelAppointmentModal .bg-gray-50,
        #rescheduleModal .bg-gray-50 {
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* Header spacing */
        #cancelAppointmentModal .relative.bg-gradient-to-r,
        #rescheduleModal .relative.bg-gradient-to-r {
            padding-left: 20px !important;
            padding-right: 20px !important;
            padding-top: 18px !important;
            padding-bottom: 22px !important;
        }

        /* Body spacing */
        #cancelAppointmentModal .bg-gray-50,
        #rescheduleModal .bg-gray-50 {
            padding-left: 16px !important;
            padding-right: 16px !important;
            padding-top: 16px !important;
            padding-bottom: max(16px, env(safe-area-inset-bottom)) !important;
        }

        /* Current info cards stack better */
        #cancelAppointmentModal .bg-white.border.border-gray-100.rounded-xl,
        #rescheduleModal .bg-white.border.border-gray-100.rounded-xl {
            padding: 14px 14px !important;
        }

        #cancelAppointmentModal .bg-white.border.border-gray-100.rounded-xl .flex.items-center.gap-3 {
            align-items: flex-start !important;
            gap: 10px !important;
        }

        #cancelAppointmentModal .text-right.flex-shrink-0 {
            text-align: left !important;
            width: 100%;
            margin-top: 6px;
        }

        #rescheduleModal .grid.grid-cols-1.sm\\:grid-cols-3 {
            grid-template-columns: 1fr !important;
            gap: 10px !important;
        }

        #rescheduleModal .two-col {
            display: flex !important;
            flex-direction: column !important;
            gap: 12px !important;
        }

        #rescheduleModal .cal-wrap,
        #rescheduleModal .slots-wrap {
            width: 100% !important;
        }

        #rescheduleModal #calendarContainer {
            overflow-x: hidden;
        }

        /* Legend wrap */
        #rescheduleModal .legend {
            display: flex;
            flex-wrap: wrap;
            gap: 8px 12px;
        }

        #rescheduleModal .legend-item {
            font-size: 11px;
        }

        /* Slot chips larger tap targets */
        #rescheduleModal .slot-chip {
            min-height: 42px;
            font-size: 13px;
            justify-content: center;
        }

        /* Reason chips easier to tap */
        .reason-chip label {
            min-height: 38px;
            padding: 8px 12px;
            font-size: 12px;
        }

        /* Textarea */
        #rescheduleModal .reason-textarea {
            min-height: 88px;
            font-size: 14px;
        }

        /* Buttons stack on mobile */
        #cancelAppointmentModal .flex.items-center.gap-3,
        #rescheduleModal .btn-row {
            display: flex !important;
            flex-direction: column-reverse !important;
            gap: 10px !important;
        }

        #cancelAppointmentModal .flex.items-center.gap-3>button,
        #rescheduleModal .btn-row>button {
            width: 100% !important;
            min-height: 44px;
            justify-content: center;
        }

        /* Sticky footer actions feel better on long modal */
        #cancelAppointmentModal .flex.items-center.gap-3,
        #rescheduleModal .btn-row {
            position: sticky;
            bottom: 0;
            background: inherit;
            padding-top: 10px;
        }

        /* Selected time/date pills */
        #rescheduleModal .slots-date-pill,
        #rescheduleModal .selected-time-pill {
            width: 100%;
            justify-content: center;
            text-align: center;
        }

        /* Close button */
        #cancelAppointmentModal .absolute.top-4.right-4,
        #rescheduleModal .absolute.top-4.right-4 {
            top: 12px !important;
            right: 12px !important;
        }

        /* Icons slightly smaller on mobile */
        .cancel-icon-ring,
        .reschedule-icon-ring {
            width: 60px;
            height: 60px;
        }

        .cancel-icon-core,
        .reschedule-icon-core {
            width: 48px;
            height: 48px;
        }
    }

    /* ===== RESCHEDULE MODAL (SCOPED) ===== */
    #rescheduleModal .section-label {
        font-size: .7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: #9a7b7b;
        margin-bottom: .75rem;
        display: flex;
        align-items: center;
        gap: .4rem;
    }

    #rescheduleModal .section-label::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #ecdada;
    }

    #rescheduleModal .two-col {
        display: grid;
        grid-template-columns: 1.15fr .85fr;
        gap: 1.25rem;
        align-items: start;
    }

    @media (max-width: 1024px) {
        #rescheduleModal .two-col {
            grid-template-columns: 1fr;
        }
    }

    /* Calendar */
    #rescheduleModal .cal-wrap {
        border: 1.5px solid #ecdada;
        border-radius: 14px;
        padding: 1rem;
        background: #fff;
    }

    #rescheduleModal .cal-day-hdr {
        font-size: .6rem;
        font-weight: 700;
        text-transform: uppercase;
        color: #9a7b7b;
    }

    #rescheduleModal .cal-cell-wrap {
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    #rescheduleModal .cal-cell {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        font-size: .75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: .15s;
    }

    #rescheduleModal .cal-cell:hover:not(.disabled) {
        background: #fff0f0;
        color: #8B0000;
    }

    #rescheduleModal .cal-cell.selected,
    #rescheduleModal .cal-cell.today {
        background: #8B0000;
        color: #fff;
        font-weight: 700;
    }

    #rescheduleModal .cal-cell.full {
        background: #fef2f2;
        color: #dc2626;
    }

    #rescheduleModal .cal-cell.holiday {
        background: #eff6ff;
        color: #2563eb;
    }

    #rescheduleModal .cal-dot {
        position: absolute;
        bottom: 2px;
        width: 4px;
        height: 4px;
        border-radius: 50%;
    }

    #rescheduleModal .dot-red {
        background: #ef4444;
    }

    #rescheduleModal .dot-blue {
        background: #3b82f6;
    }

    /* Tooltip fix */
    #rescheduleModal .cal-tooltip {
        opacity: 0;
        transition: opacity .15s;
        pointer-events: none;
    }

    #rescheduleModal .cal-cell-wrap:hover .cal-tooltip {
        opacity: 1;
    }

    /* Slots */
    #rescheduleModal .slots-wrap {
        border: 1.5px solid #ecdada;
        border-radius: 14px;
        padding: 1rem;
        background: #fff;
        min-height: 220px;
    }

    #rescheduleModal .slots-placeholder {
        min-height: 110px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        text-align: center;
        gap: .5rem;
    }

    #rescheduleModal .slots-date-pill {
        background: linear-gradient(135deg, #8B0000, #a31515);
        color: #fff;
        border-radius: 10px;
        padding: .45rem .85rem;
        font-size: .75rem;
        font-weight: 600;
        margin-bottom: .75rem;
        display: none;
    }

    #rescheduleModal .slots-date-pill.show {
        display: block;
    }

    #rescheduleModal .slots-placeholder {
        text-align: center;
        color: #9a7b7b;
        font-size: .8rem;
    }

    #rescheduleModal .slots-grid {
        display: flex;
        flex-wrap: wrap;
        gap: .4rem;
    }

    #rescheduleModal .slot-chip {
        padding: .35rem .75rem;
        border-radius: 9999px;
        border: 1.5px solid #ecdada;
        font-size: .72rem;
        cursor: pointer;
        transition: .12s;
    }

    #rescheduleModal .slot-chip:hover {
        border-color: #8B0000;
        background: #fff0f0;
        color: #8B0000;
    }

    #rescheduleModal .slot-chip.selected {
        background: #8B0000;
        color: #fff;
    }

    /* Selected time */
    #rescheduleModal .selected-time-pill {
        margin-top: .6rem;
        font-size: .75rem;
        font-weight: 600;
        color: #8B0000;
        display: none;
    }

    #rescheduleModal .selected-time-pill.show {
        display: flex;
    }

    /* Legend */
    #rescheduleModal .legend {
        display: flex;
        flex-wrap: wrap;
        gap: .6rem .9rem;
        margin-top: .75rem;
    }

    #rescheduleModal .legend-item {
        font-size: .7rem;
        color: #9a7b7b;
    }

    #rescheduleModal .legend-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
    }

    /* Reason */
    #rescheduleModal .reason-textarea {
        width: 100%;
        border: 1.5px solid #ecdada;
        border-radius: 12px;
        padding: .75rem 1rem;
        font-size: .82rem;
    }

    /* Buttons */
    #rescheduleModal .btn-row {
        display: flex;
        justify-content: flex-end;
        gap: .75rem;
        margin-top: 1rem;
    }

    #rescheduleModal .btn {
        padding: .72rem 1.35rem;
        border-radius: 12px;
        font-size: .82rem;
        font-weight: 700;
        transition: all .18s ease;
        box-shadow: 0 1px 2px rgba(0, 0, 0, .03);
    }

    #rescheduleModal .btn-cancel {
        background: #fff;
        border: 1px solid #e8ddd6;
        color: #7a1f1f;
    }

    #rescheduleModal .btn-cancel:hover {
        background: #fdf7f5;
        border-color: #d9c7bc;
    }

    #rescheduleModal .btn-confirm {
        background: linear-gradient(135deg, #7a0d0d, #a31515);
        color: #fff;
        box-shadow: 0 8px 20px rgba(139, 0, 0, .16);
    }

    #rescheduleModal .btn-confirm:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 24px rgba(139, 0, 0, .22);
    }

    #rescheduleModal .reschedule-modal-panel {
        border: 1px solid rgba(255, 255, 255, .18);
        box-shadow: 0 20px 60px rgba(0, 0, 0, .22);
    }

    #rescheduleModal .reschedule-modal-body {
        background:
            linear-gradient(to bottom, rgba(255, 255, 255, .72), rgba(255, 255, 255, .72)),
            #fcfbfa;
    }

    /* Errors */
    #rescheduleModal .error-msg {
        font-size: .72rem;
        font-weight: 600;
        color: #be123c;
        background: #fff1f2;
        border: 1.5px solid #fecdd3;
        border-radius: 8px;
        padding: .4rem .75rem;
        margin-bottom: .5rem;
    }

    #rescheduleModal .cal-wrap.error,
    #rescheduleModal .slots-wrap.error {
        border-color: #fca5a5;
        background: #fffafa;
    }

    .cal-cell.disabled {
        pointer-events: auto;
        cursor: not-allowed;
    }

    #rescheduleModal {
        padding: 16px;
    }

    #rescheduleModal .reschedule-modal-panel {
        max-height: min(92vh, 900px);
        display: flex;
        flex-direction: column;
    }

    #rescheduleModal .reschedule-modal-body {
        flex: 1 1 auto;
        overflow-y: auto;
        overscroll-behavior: contain;
        -webkit-overflow-scrolling: touch;
    }

    @media (min-width: 640px) {
        #rescheduleModal .reschedule-modal-panel {
            width: min(1100px, calc(100vw - 48px));
        }
    }

    @media (max-width: 640px) {
        #rescheduleModal {
            padding: 0;
        }

        #rescheduleModal .reschedule-modal-panel {
            max-height: 92vh;
            border-radius: 20px 20px 0 0 !important;
        }

        #rescheduleModal .reschedule-modal-body {
            padding-bottom: max(16px, env(safe-area-inset-bottom));
        }
    }

    #toastContainer {
  position: fixed;
  bottom: 28px;
  right: 28px;
  z-index: 99999;
  display: flex;
  flex-direction: column;
  gap: 10px;
  pointer-events: none;
}

.toast-item {
  display: flex;
  align-items: flex-start;
  gap: 12px;
  background: #1a1a1a;
  border: 1px solid #2d2d2d;
  border-radius: 14px;
  padding: 14px 16px;
  min-width: 280px;
  max-width: 360px;
  box-shadow: 0 8px 32px rgba(0, 0, 0, .35);
  pointer-events: auto;
  position: relative;
  overflow: hidden;
  animation: toastIn .4s cubic-bezier(.34, 1.56, .64, 1) forwards;
}

.toast-item.toast-exit {
  animation: toastOut .35s ease forwards;
}

@keyframes toastIn {
  from { opacity: 0; transform: translateX(60px) scale(.95); }
  to { opacity: 1; transform: translateX(0) scale(1); }
}

@keyframes toastOut {
  from { opacity: 1; transform: translateX(0); max-height: 100px; }
  to { opacity: 0; transform: translateX(60px); max-height: 0; }
}

.toast-progress {
  position: absolute;
  bottom: 0;
  left: 0;
  height: 3px;
  border-radius: 0 0 14px 14px;
  animation: toastProg linear forwards;
}

@keyframes toastProg {
  from { width: 100%; }
  to { width: 0%; }
}

.toast-icon-wrap {
  width: 36px;
  height: 36px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.toast-title {
  font-size: 13px;
  font-weight: 700;
  color: #f3f4f6;
  line-height: 1.3;
  margin-bottom: 2px;
}

.toast-message {
  font-size: 12px;
  color: #9ca3af;
  line-height: 1.4;
}

.toast-close {
  width: 22px;
  height: 22px;
  border-radius: 6px;
  background: rgba(255, 255, 255, .06);
  border: none;
  cursor: pointer;
  color: #6b7280;
  font-size: 11px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background .15s;
}

.toast-close:hover {
  background: rgba(255, 255, 255, .12);
  color: #e5e7eb;
}

@media (max-width: 767px) {
  #toastContainer {
    bottom: 16px;
    right: 16px;
    left: 16px;
  }

  .toast-item {
    min-width: unset;
    max-width: 100%;
  }
}

.toast-item.toast-success .toast-icon-wrap {
  background: rgba(34, 197, 94, .15);
  border: 1px solid rgba(34, 197, 94, .25);
}

.toast-item.toast-success .toast-progress {
  background: linear-gradient(90deg, #16a34a, #4ade80);
}

.toast-item.toast-danger .toast-icon-wrap {
  background: rgba(220, 38, 38, .15);
  border: 1px solid rgba(220, 38, 38, .25);
}

.toast-item.toast-danger .toast-progress {
  background: linear-gradient(90deg, #dc2626, #f87171);
}
</style>
