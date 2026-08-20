@php
    $layoutRole =
        trim($__env->yieldContent('layout-role')) ?:
        optional(optional(auth()->user())->role)->slug ?? (session('role') ?? 'patient');

    if ($layoutRole === 'super_admin') {
        $layoutRole = 'admin';
    }

    $isAdmin = $layoutRole === 'admin';
    $isDentist = $layoutRole === 'dentist';
    $isPatient = $layoutRole === 'patient';

    $hideSidebar = View::hasSection('hide-sidebar');
    $hideMobileNav = View::hasSection('hide-mobile-nav');
    $hidePatientModals = View::hasSection('hide-patient-modals');

    $showMobileMenu = ($isAdmin || $isDentist) && !$hideSidebar;
    $showSettings = $isAdmin;

    $accessibilityOffset = $isPatient && !$hideMobileNav ? '18,118' : '18,24';
@endphp

<!DOCTYPE html>
<html lang="en" data-theme="{{ session('theme', 'light') }}">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @if (auth()->check())
        <meta name="auth-user-id" content="{{ auth()->id() }}">
    @endif

    <script>
        (function() {
            const savedTheme =
                localStorage.getItem('theme');

            const theme =
                savedTheme === 'dark' ?
                'dark' :
                'light';

            const isDark =
                theme === 'dark';

            const role =
                @json($layoutRole);

            document.documentElement.setAttribute(
                'data-theme',
                theme
            );

            document.documentElement.classList.toggle(
                'dark',
                isDark
            );

            document.documentElement.style.colorScheme =
                isDark ?
                'dark' :
                'light';

            document.documentElement.style.backgroundColor =
                isDark ?
                '#101111' :
                '#F4F4F4';

            const sidebarKeys = {
                admin: 'adminSidebarCollapsed',
                dentist: 'dentistSidebarCollapsed',
                patient: 'patientSidebarCollapsed'
            };

            document.documentElement.classList.add('sidebar-preload');

            try {
                if (localStorage.getItem(sidebarKeys[role]) === '1') {
                    document.documentElement.classList.add(
                        'sidebar-collapsed-init'
                    );
                }
            } catch (error) {}
        })();
    </script>

    <style>
        html.accessibility-preload .header,
        html.accessibility-preload #sidebar,
        html.accessibility-preload #mainContent,
        html.accessibility-preload #siteFooter {
            visibility: hidden !important;
        }
    </style>

    <script>
        (function() {
            const root = document.documentElement;

            root.classList.add('accessibility-preload');

            const releaseAccessibilityPreload = () => {
                requestAnimationFrame(() => {
                    requestAnimationFrame(() => {
                        root.classList.remove(
                            'accessibility-preload'
                        );
                    });
                });
            };

            window.releaseAccessibilityPreload =
                releaseAccessibilityPreload;
            setTimeout(
                releaseAccessibilityPreload,
                1500
            );
        })();
    </script>

    <title>
        @hasSection('title')
            @yield('title') | PUP Taguig Dental Clinic
        @else
            PUP Taguig Dental Clinic
        @endif
    </title>

    <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @yield('styles')
    @stack('styles')
</head>

<body
    class="
        role-{{ $layoutRole }}
        {{ $hideSidebar ? 'layout-no-sidebar' : '' }}
        {{ $hideMobileNav ? 'layout-no-mobile-nav' : '' }}
        @yield('body-class', 'bg-[#F4F4F4]')">

    @include('partials.header', [
        'role' => $layoutRole,
        'patient' => $patient ?? null,
        'notifications' => $notifications ?? [],
        'showMobileMenu' => $showMobileMenu,
        'showSettings' => $showSettings,
    ])

    @if (!$hideSidebar)
        @include('components.global-sidebar', [
            'role' => $layoutRole,
        ])
    @endif

    @if ($isPatient && !$hideMobileNav)
        @include('partials.patient.mobile-nav')
    @endif

    @if ($isPatient && !$hidePatientModals)
        @include('components.patient-document-modals')
        @include('components.patient-record-modal')
    @endif

    @if ($isPatient)
        @include('partials.impersonation-banner')
    @endif

    @if ($isDentist)
        @include('partials.impersonation-banner')
        @include('components.reschedule-modal')
        @include('components.cancel-modal')
        @include('components.patient-record-modal')
    @endif

    @if ($isAdmin)
        @include('components.patient-record-modal')
    @endif

    @yield('content')

    @include('partials.footer')

    @include('components.active-appointment-modal')
    
    @include('components.discard-changes')

    @include('partials.global-toast')

    <div id="logoutConfirmModal" class="ui-modal logout-confirm-modal modal-theme-warning" role="dialog"
        aria-modal="true" aria-labelledby="logoutConfirmTitle" aria-describedby="logoutConfirmDescription"
        aria-hidden="true">
        <div class="ui-modal-card modal-sm logout-confirm-card">
            <div class="modal-hd">
                <div class="modal-heading">
                    <div class="modal-icon logout-confirm-icon">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </div>

                    <div class="modal-copy">
                        <h2 id="logoutConfirmTitle" class="modal-title">
                            Confirm Logout
                        </h2>

                        <p class="modal-subtitle">
                            You are about to end your current session.
                        </p>
                    </div>
                </div>

                <button type="button" class="modal-x" data-logout-modal-close aria-label="Close logout confirmation">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="modal-bd">
                <div class="logout-confirm-message">
                    <div class="logout-confirm-message-icon">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>

                    <div>
                        <p id="logoutConfirmDescription">
                            Are you sure you want to log out?
                        </p>

                        <span>
                            You will need to sign in again to access your account.
                        </span>
                    </div>
                </div>
            </div>

            <div class="modal-ft logout-confirm-actions">
                <button type="button" class="btn-close-modal" data-logout-modal-close>
                    Stay Signed In
                </button>

                <button type="button" id="confirmLogoutBtn" class="modal-btn-confirm danger">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Log Out</span>
                </button>
            </div>
        </div>
    </div>

    @include('partials.terms-modal')

    @if ($isDentist && View::hasSection('usesAppointmentCalendar'))
        @include('components.appointment-calendar-script', [
            'mode' => 'booking',
            'calendarContainerId' => 'calGridWrapReschedule',
            'calGridId' => 'calGrid',
            'calMonthLabelId' => 'calMonthLabel',
            'calYearLabelId' => 'calYearLabel',
            'dateInputId' => 'new_appointment_date',
            'timeInputId' => 'new_appointment_time',
            'dateBannerId' => 'dateBanner',
            'slotPlaceholderId' => 'slotPlaceholder',
            'slotContainerId' => 'slotContainer',
            'slotGridId' => 'slotGrid',
            'selectedSlotDisplayId' => 'selectedSlotDisplay',
            'selectedSlotTextId' => 'selectedSlotText',
            'selectedTimePillId' => 'selectedTimePill',
            'selectedTimeTextId' => 'selectedTimeText',
            'datePillId' => 'datePill',
            'dateErrorId' => 'dateError',
            'timeErrorId' => 'timeError',
            'calendarWrapSelector' => '#rescheduleModal .cal-wrap',
            'slotsWrapSelector' => '#rescheduleModal .slots-wrap',
            'slotEndpoint' => route('dentist.appointment.slots'),
        
            'scheduleRules' => isset($schedules)
                ? $schedules
                : (isset($scheduleRules)
                    ? $scheduleRules
                    : \App\Models\ClinicSchedule::active()->get()->values()->toArray()),
        
            'blockedDates' => $blockedDates ?? [],
            'appointmentCountsPerDay' => $appointmentCountsPerDay ?? [],
            'philippineHolidays' => $philippineHolidays ?? [],
        
            'disallowToday' => true,
            'allowToggleOffDate' => true,
            'useDynamicScheduleRules' => true,
            'renderStyle' => 'dentist',
        ])
    @endif

    @if ($isPatient && !$hideMobileNav && !$hidePatientModals)
        <script>
            function openQuickAction(type) {
                if (type === 'record') {
                    document
                        .getElementById('dentalHealthRecordModal')
                        ?.showModal();
                }

                if (type === 'clearance') {
                    document
                        .getElementById('dentalClearanceModal')
                        ?.showModal();
                }
            }
        </script>
    @endif

    <div id="globalActionTooltip" class="global-action-tooltip" role="tooltip" aria-hidden="true">
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sienna-accessibility@latest/dist/sienna-accessibility.umd.js"
        data-position="bottom-right" data-offset="{{ $accessibilityOffset }}" defer></script>

    <script>
        document.addEventListener(
            'DOMContentLoaded',
            function() {
                const release = () => {
                    window.releaseAccessibilityPreload?.();
                };

                if (document.querySelector('.asw-widget')) {
                    release();
                    return;
                }

                const observer = new MutationObserver(() => {
                    if (
                        !document.querySelector(
                            '.asw-widget'
                        )
                    ) {
                        return;
                    }

                    observer.disconnect();
                    release();
                });

                observer.observe(document.body, {
                    childList: true,
                    subtree: true
                });

                setTimeout(() => {
                    observer.disconnect();
                    release();
                }, 1500);
            }
        );
    </script>

    @include('partials.chatbot')

    @stack('scripts')
    @yield('scripts')
</body>

</html>
