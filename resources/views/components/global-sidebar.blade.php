@php
    use Illuminate\Support\Facades\Route;
    $sidebarRole = $role ?? (request()->is('admin*') ? 'admin' : (request()->is('dentist*') ? 'dentist' : 'patient'));

    $authUser = auth()->user();

    $drawerDisplayName = $authUser?->name ?? ucwords(str_replace('_', ' ', $sidebarRole));

    $drawerDisplayRole = match ($sidebarRole) {
        'admin' => 'Administrator',
        'dentist' => 'Dentist',
        default => ucwords(str_replace('_', ' ', $sidebarRole)),
    };

    $drawerAvatarUrl = !empty($authUser?->profile_image)
        ? asset('storage/' . $authUser->profile_image)
        : 'https://ui-avatars.com/api/?name=' .
            urlencode($drawerDisplayName) .
            '&background=8B0000&color=ffffff&bold=true';

    $sidebarGroups = [
        'admin' => [
            [
                'section' => 'Clinic Management',
                'label' => 'Clinic Management',
                'sublabel' => 'Core clinical modules',
                'icon' => 'fa-hospital',
                'items' => [
                    [
                        'route' => 'admin.admin.dashboard',
                        'active' => ['admin.admin.dashboard'],
                        'icon' => 'fa-chart-line',
                        'label' => 'Dashboard',
                    ],
                    [
                        'route' => 'admin.patient_directory',
                        'active' => ['admin.patient_directory'],
                        'icon' => 'fa-users',
                        'label' => 'Patients',
                    ],
                    [
                        'route' => 'admin.dental-records.index',
                        'active' => ['admin.dental-records*'],
                        'icon' => 'fa-tooth',
                        'label' => 'Dental Records',
                    ],
                    [
                        'route' => 'admin.admin.appointments',
                        'active' => ['admin.admin.appointments'],
                        'icon' => 'fa-calendar-check',
                        'label' => 'Appointments',
                    ],
                    [
                        'route' => 'admin.document-requests.index',
                        'active' => ['admin.document-requests*'],
                        'icon' => 'fa-file-circle-check',
                        'label' => 'Document Request',
                    ],
                    [
                        'route' => 'admin.reports',
                        'active' => ['admin.reports'],
                        'icon' => 'fa-file',
                        'label' => 'Reports',
                    ],
                ],
            ],
            [
                'section' => 'Maintenance',
                'label' => 'Configuration',
                'sublabel' => 'Settings & scheduling',
                'icon' => 'fa-screwdriver-wrench',
                'items' => [
                    [
                        'route' => 'admin.user_management',
                        'active' => ['admin.user_management*'],
                        'icon' => 'fa-user-gear',
                        'label' => 'User Management',
                    ],
                    [
                        'route' => 'admin.dentist-transitions.index',
                        'active' => ['admin.dentist-transitions*'],
                        'icon' => 'fa-people-arrows',
                        'label' => 'Dentist Continuity',
                    ],
                    [
                        'route' => 'admin.role_permissions',
                        'active' => ['admin.role_permissions'],
                        'icon' => 'fa-user-shield',
                        'label' => 'Roles & Permissions',
                    ],
                    [
                        'route' => 'admin.service-types',
                        'active' => ['admin.service-types*'],
                        'icon' => 'fa-list-check',
                        'label' => 'Service Types',
                    ],
                    [
                        'route' => 'admin.clinic_schedule',
                        'active' => ['admin.clinic_schedule*'],
                        'icon' => 'fa-calendar-days',
                        'label' => 'Clinic Schedule',
                    ],
                    [
                        'route' => 'admin.academic_periods',
                        'active' => ['admin.academic_periods*'],
                        'icon' => 'fa-school',
                        'label' => 'Academic Periods',
                    ],
                    [
                        'route' => 'admin.inventory',
                        'active' => ['admin.inventory*'],
                        'icon' => 'fa-boxes-stacked',
                        'label' => 'Inventory',
                    ],
                    [
                        'route' => 'admin.document-template',
                        'active' => ['admin.document-template*'],
                        'icon' => 'fa-file-pen',
                        'label' => 'Document Templates',
                    ],
                ],
            ],
            [
                'section' => 'System',
                'label' => 'System',
                'sublabel' => 'Admin & configuration',
                'icon' => 'fa-server',
                'items' => [
                    [
                        'route' => 'admin.system_settings',
                        'active' => ['admin.system_settings*'],
                        'icon' => 'fa-sliders',
                        'label' => 'System Settings',
                    ],
                    [
                        'route' => 'admin.assign-cms-access',
                        'active' => ['admin.assign-cms-access'],
                        'icon' => 'fa-user-shield',
                        'label' => 'Assign CMS Access',
                    ],
                    [
                        'route' => 'admin.faculty.integration',
                        'active' => ['admin.faculty.integration'],
                        'icon' => 'fa-user-plus',
                        'label' => 'Faculty Integration',
                    ],
                    [
                        'route' => 'admin.system_logs',
                        'active' => ['admin.system_logs'],
                        'icon' => 'fa-clipboard-list',
                        'label' => 'System Logs',
                    ],
                    [
                        'route' => 'admin.session_management.index',
                        'active' => ['admin.session_management.*'],
                        'icon' => 'fa-shield-halved',
                        'label' => 'Session Dashboard',
                    ],
                ],
            ],
        ],

        'dentist' => [
            [
                'section' => 'Navigation',
                'label' => 'Navigation',
                'sublabel' => 'Dental clinic tools',
                'icon' => 'fa-tooth',
                'items' => [
                    [
                        'route' => 'dentist.dentist.dashboard',
                        'permission' => 'access_dentist_dashboard',
                        'active' => ['dentist.dentist.dashboard'],
                        'icon' => 'fa-chart-line',
                        'label' => 'Dashboard',
                    ],
                    [
                        'route' => 'dentist.dentist.patients',
                        'permission' => 'manage_patient_profiles',
                        'active' => ['dentist.dentist.patients'],
                        'icon' => 'fa-users',
                        'label' => 'Patients',
                    ],
                    [
                        'route' => 'dentist.walk-in.index',
                        'permission' => 'manage_appointments',
                        'active' => ['dentist.walk-in.*'],
                        'icon' => 'fa-person-walking',
                        'label' => 'Walk-in',
                    ],
                    [
                        'route' => 'dentist.existing-record.index',
                        'permission' => 'manage_appointments',
                        'active' => ['dentist.existing-record.*'],
                        'icon' => 'fa-folder-open',
                        'label' => 'Add Existing Record',
                    ],
                    [
                        'route' => 'dentist.dentist.appointments',
                        'permission' => 'manage_appointments',
                        'active' => ['dentist.dentist.appointments'],
                        'icon' => 'fa-calendar-check',
                        'label' => 'Appointments',
                    ],
                    [
                        'route' => 'dentist.dentist.clinic_schedule',
                        'permission' => 'manage_appointments',
                        'active' => ['dentist.dentist.clinic_schedule*'],
                        'icon' => 'fa-calendar-days',
                        'label' => 'Clinic Schedule',
                    ],
                    [
                        'route' => 'dentist.dentist.documentrequests',
                        'permission' => 'manage_document_requests',
                        'active' => ['dentist.dentist.documentrequests'],
                        'icon' => 'fa-file-circle-check',
                        'label' => 'Document Requests',
                    ],
                    [
                        'route' => 'dentist.dentist.inventory',
                        'permission' => 'manage_inventory',
                        'active' => ['dentist.dentist.inventory'],
                        'icon' => 'fa-box',
                        'label' => 'Inventory',
                    ],
                    [
                        'route' => 'dentist.dentist.report',
                        'permission' => 'manage_reports',
                        'active' => ['dentist.dentist.report'],
                        'icon' => 'fa-file',
                        'label' => 'Reports',
                    ],
                ],
            ],
        ],

        'patient' => [
            [
                'section' => 'Navigation',
                'label' => 'Patient',
                'sublabel' => 'Self-service tools',
                'icon' => 'fa-user',
                'items' => [
                    [
                        'route' => 'homepage',
                        'active' => ['homepage'],
                        'paths' => ['patient/dashboard'],
                        'icon' => 'fa-house',
                        'label' => 'Home',
                    ],
                    [
                        'route' => 'patient.appointment.index',
                        'active' => ['patient.appointment.*'],
                        'paths' => ['patient/appointment*'],
                        'icon' => 'fa-calendar-check',
                        'label' => 'Appointments',
                    ],
                    [
                        'route' => 'patient.record',
                        'active' => ['patient.record'],
                        'paths' => ['patient/record*'],
                        'icon' => 'fa-folder-open',
                        'label' => 'Dental Records',
                    ],
                    [
                        'route' => 'patient.about.us',
                        'active' => ['patient.about.us'],
                        'paths' => ['patient/about*'],
                        'icon' => 'fa-circle-info',
                        'label' => 'About Us',
                    ],
                ],
            ],
        ],
    ];

    $groups = $sidebarGroups[$sidebarRole] ?? $sidebarGroups['patient'];

    if ($sidebarRole === 'dentist' && $authUser) {
        $permissionSlugs = $authUser->role?->permissions->pluck('slug')->all() ?? [];
        $isSuperAdmin = $authUser->role?->slug === 'super_admin';

        $groups = collect($groups)
            ->map(function ($group) use ($permissionSlugs, $isSuperAdmin) {
                $group['items'] = array_values(array_filter(
                    $group['items'],
                    fn ($item) => $isSuperAdmin
                        || empty($item['permission'])
                        || in_array($item['permission'], $permissionSlugs, true)
                ));

                return $group;
            })
            ->filter(fn ($group) => !empty($group['items']))
            ->values()
            ->all();
    }

    $resolveItemUrl = function ($item) {
        try {
            if (!empty($item['url'])) {
                return $item['url'];
            }

            if (!empty($item['route']) && Route::has($item['route'])) {
                return route($item['route']);
            }
        } catch (\Throwable $e) {
            return null;
        }

        return null;
    };

    $isItemActive = function ($item) {
        foreach ($item['active'] ?? [$item['route']] as $pattern) {
            if (request()->routeIs($pattern)) {
                return true;
            }
        }

        foreach ($item['paths'] ?? [] as $path) {
            if (request()->is($path)) {
                return true;
            }
        }

        return false;
    };

    $isGroupActive = function ($group) use ($isItemActive) {
        foreach ($group['items'] as $item) {
            if ($isItemActive($item)) {
                return true;
            }
        }

        return false;
    };

    $shouldShowDrawer = in_array($sidebarRole, ['admin', 'dentist'], true);
@endphp

<aside id="sidebar" class="global-sidebar sidebar-{{ $sidebarRole }}">
    <div class="sidebar-inner">
        <div class="toggle-row flex justify-end mb-3">
            <button type="button" id="sidebarToggleBtn" class="sidebar-toggle-btn" aria-label="Toggle sidebar"
                data-sidebar-toggle>
                <i id="sidebarIcon" class="fa-solid fa-xmark"></i>
            </button>
        </div>

        @foreach ($groups as $group)
            <div class="nav-section-label">{{ $group['section'] }}</div>

            <div class="nav-group">
                @if ($sidebarRole === 'admin')
                    <button type="button"
                        class="sidebar-group-trigger {{ $isGroupActive($group) ? 'active-group' : '' }}"
                        data-admin-group-toggle aria-expanded="false">

                        <div class="sidebar-group-icon">
                            <i class="fa-solid {{ $group['icon'] }}"></i>
                        </div>

                        <div class="sidebar-group-text">
                            <span class="group-label">{{ $group['label'] }}</span>
                            <span class="group-sublabel">{{ $group['sublabel'] }}</span>
                        </div>

                        <span class="sidebar-item-tooltip">
                            {{ $group['label'] }}
                        </span>
                    </button>
                @endif

                <div class="group-body"
                    @if ($sidebarRole === 'admin') data-group-label="{{ $group['label'] }}"
                data-group-sublabel="{{ $group['sublabel'] }}" @endif>
                    @foreach ($group['items'] as $item)
                        @php($itemUrl = $resolveItemUrl($item))

                        @if ($itemUrl)
                            @if ($sidebarRole === 'dentist')
                                <a href="{{ $itemUrl }}"
                                    class="sidebar-item {{ $isItemActive($item) ? 'active' : '' }}">

                                    <span class="sidebar-item-icon">
                                        <i class="fa-solid {{ $item['icon'] }}"></i>
                                    </span>

                                    <span class="sidebar-item-text">
                                        {{ $item['label'] }}
                                    </span>

                                    <span class="sidebar-item-tooltip">
                                        {{ $item['label'] }}
                                    </span>
                                </a>
                            @else
                                <a href="{{ $itemUrl }}"
                                    class="sidebar-item {{ $isItemActive($item) ? 'active' : '' }}">

                                    @if ($sidebarRole === 'patient')
                                        <span class="sidebar-item-icon">
                                            <i class="fa-solid {{ $item['icon'] }}"></i>
                                        </span>
                                    @else
                                        <i class="sidebar-item-inline-icon fa-solid {{ $item['icon'] }}"></i>
                                    @endif

                                    <span class="sidebar-item-text">
                                        {{ $item['label'] }}
                                    </span>

                                    <span class="sidebar-item-tooltip">
                                        {{ $item['label'] }}
                                    </span>
                                </a>
                            @endif
                        @endif
                    @endforeach
                </div>
            </div>

            @if (!$loop->last)
                <div class="nav-sep"></div>
            @endif
        @endforeach
    </div>

    <div class="sidebar-bottom">
        <div class="sidebar-theme-block mb-2">
            <div class="theme-toggle-container sidebar-theme-expanded">
                <button type="button" class="theme-option active" data-theme-choice="light" aria-label="Light mode">
                    <i class="fa-solid fa-sun"></i>
                </button>

                <button type="button" class="theme-option" data-theme-choice="dark" aria-label="Dark mode">
                    <i class="fa-regular fa-moon"></i>
                </button>

                <div class="theme-indicator"></div>
            </div>

            <div class="sidebar-theme-collapsed" data-sidebar-theme-dropdown>
                <button type="button" class="sidebar-theme-mini-btn sidebar-mini-control" data-sidebar-theme-trigger
                    aria-label="Switch Mode">
                    <i class="fa-solid fa-sun" data-sidebar-theme-icon></i>
                    <span class="sidebar-item-tooltip">Switch Mode</span>
                </button>

                <div class="sidebar-theme-popover">
                    <button type="button" class="sidebar-theme-popover-option theme-option active"
                        data-theme-choice="light">
                        <i class="fa-solid fa-sun"></i>
                        <span>Light</span>
                    </button>

                    <button type="button" class="sidebar-theme-popover-option theme-option" data-theme-choice="dark">
                        <i class="fa-regular fa-moon"></i>
                        <span>Dark</span>
                    </button>
                </div>
            </div>
        </div>

        <form action="{{ route('logout') }}" method="POST" class="js-logout-form">
            @csrf

            <button type="submit" class="logout-btn sidebar-mini-control">
                <span class="sidebar-control-icon">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </span>

                <span class="sidebar-item-text">Log Out</span>
                <span class="sidebar-item-tooltip">Log Out</span>
            </button>
        </form>
    </div>
</aside>

@if ($shouldShowDrawer)
    <div id="mobileDrawerOverlay" data-drawer-close></div>

    <div id="mobileDrawer">
        <div class="drawer-header">
            <div class="drawer-header-left">
                <img src="{{ asset('images/PUPT-DMS-Logo.png') }}" class="drawer-logo" alt="DMS">

                <div>
                    <div class="drawer-title">PUP TAGUIG</div>
                    <div class="drawer-subtitle">Dental Clinic</div>
                </div>
            </div>

            <button type="button" class="drawer-close" data-drawer-close aria-label="Close menu">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="drawer-user">
            <span class="patient-avatar patient-avatar-md drawer-user-avatar" data-patient-avatar
                data-patient-name="{{ $drawerDisplayName }}" data-patient-url="{{ $drawerAvatarUrl }}"
                aria-label="{{ $drawerDisplayName }}">
            </span>

            <div>
                <div class="drawer-user-name">{{ $drawerDisplayName }}</div>
                <div class="drawer-user-role">{{ $drawerDisplayRole }}</div>
            </div>
        </div>

        <div class="drawer-inner">
            @foreach ($groups as $group)
                <div class="drawer-group">
                    <div class="drawer-group-header">
                        <span class="drawer-group-icon" aria-hidden="true">
                            <i class="fa-solid {{ $group['icon'] }}"></i>
                        </span>

                        <span class="drawer-group-label">
                            {{ $group['section'] }}
                        </span>
                    </div>

                    @foreach ($group['items'] as $item)
                        @php($itemUrl = $resolveItemUrl($item))

                        @if ($itemUrl)
                            <a href="{{ $itemUrl }}"
                                class="drawer-link {{ $isItemActive($item) ? 'active' : '' }}">

                                <span class="drawer-link-icon" aria-hidden="true">
                                    <i class="fa-solid {{ $item['icon'] }}"></i>
                                </span>

                                <span class="drawer-link-text">
                                    {{ $item['label'] }}
                                </span>
                            </a>
                        @endif
                    @endforeach
                </div>

                @if (!$loop->last)
                    <div class="drawer-sep"></div>
                @endif
            @endforeach
        </div>

        <div class="drawer-bottom">
            <div class="theme-toggle-container mb-2">
                <button type="button" class="theme-option active" data-theme-choice="light"
                    aria-label="Light mode">
                    <i class="fa-solid fa-sun"></i>
                </button>

                <button type="button" class="theme-option" data-theme-choice="dark" aria-label="Dark mode">
                    <i class="fa-regular fa-moon"></i>
                </button>

                <div class="theme-indicator" aria-hidden="true"></div>
            </div>

            <form action="{{ route('logout') }}" method="POST" class="js-logout-form">
                @csrf

                <button type="submit" class="drawer-logout-btn">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Log Out</span>
                </button>
            </form>
        </div>
    </div>
@endif
