<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Role Permissions | PUP Taguig Dental Clinic</title>
    <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script>
        tailwind.config = { daisyui: { themes: false } }
    </script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        #sidebar { transition: width 300ms ease, transform 300ms ease; will-change: width, transform; }
        #mainContent { transition: margin-left 300ms ease; }

        .sidebar-link{
            display:flex; align-items:center; width:100%;
            padding:12px; border-radius:12px;
            transition: background-color .2s ease, transform .2s ease;
            position: relative;
        }

        .sidebar-link:hover .sidebar-tooltip{ opacity:1; transform:scale(1); }
        #sidebar[style*="16rem"] .sidebar-tooltip{ display:none; }
        #sidebar[style*="16rem"] .sidebar-link{ justify-content:flex-start; gap:12px; }
        .sidebar-link i{ width:24px; min-width:24px; text-align:center; }
        #sidebar[style*="72px"] .sidebar-link{ justify-content:center; gap:0; }

        .notif-open { opacity: 1 !important; transform: scale(1) !important; pointer-events: auto !important; }
        .notif-close{ opacity: 0 !important; transform: scale(0.95) !important; pointer-events: none !important; }

        body, #sidebar, main, .card { transition: background-color .3s ease, color .3s ease; }

        .permission-section {
            background: #f6ebc6;
        }

        .permission-checkbox {
            width: 18px;
            height: 18px;
            accent-color: #8B0000;
            cursor: pointer;
        }

        .table-sticky thead th {
            position: sticky;
            top: 0;
            z-index: 10;
            background: #f9fafb;
        }
    </style>
</head>

<body class="bg-[#f5f5f5] text-[#333333]">

<!-- HEADER -->
<div class="fixed top-0 left-0 right-0 z-50 bg-gradient-to-r from-[#660000] to-[#8B0000] text-[#F4F4F4] px-6 py-4 flex items-center justify-between">
    <div class="flex items-center gap-3">
        <div class="w-10 rounded-full ml-2">
            <img src="{{ asset('images/PUP.png') }}" alt="PUP Logo"/>
        </div>
        <div class="w-10 rounded-full">
            <img src="{{ asset('images/PUPT-DMS-Logo.png') }}" alt="PUPT DMS Logo"/>
        </div>
        <span class="font-bold text-sm md:text-lg">PUP TAGUIG DENTAL CLINIC</span>
    </div>

    <div class="flex items-center gap-6">
        <div id="notifDropdown" class="relative">
            <button id="notifBtn" type="button" class="btn btn-ghost btn-circle indicator text-[#F4F4F4]">
                <i class="fa-regular fa-bell text-lg"></i>
            </button>

            <div id="notifMenu"
                class="absolute right-0 mt-3 w-80 rounded-2xl bg-white shadow-xl border border-gray-100 z-50
                       opacity-0 scale-95 pointer-events-none transition-all duration-200 ease-out origin-top-right">
                <div class="p-4 border-b flex items-center justify-between">
                    <span class="font-bold text-[#8B0000]">Notifications</span>
                </div>
                <div class="px-4 py-10 text-center">
                    <div class="text-sm font-semibold text-gray-800">No notifications</div>
                    <div class="text-xs text-gray-500 mt-1">You’re all caught up.</div>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <img src="https://i.pravatar.cc/40" class="rounded-full w-9 h-9">
            <div class="leading-tight">
                <p class="text-sm font-semibold text-[#F4F4F4]">Super Admin</p>
                <p class="italic text-[11px] text-[#F4F4F4]/80">System Administrator</p>
            </div>
        </div>
    </div>
</div>

<!-- SIDEBAR -->
<aside id="sidebar"
    class="fixed left-0 top-[80px] h-[calc(100vh-80px)] w-[72px]
           bg-[#FAFAFA] drop-shadow-xl transition-all duration-300
           flex flex-col justify-between z-40">

    <div>
        <div id="sidebarToggleWrapper" class="flex items-center justify-center px-4 py-6 transition-all duration-300">
            <button onclick="toggleSidebar()" id="sidebarToggleBtn"
                class="w-10 h-10 flex items-center justify-center rounded-full
                       text-[#757575] hover:text-[#8B0000] hover:bg-[#D9D9D9]
                       transition-all duration-300">
                <i id="sidebarIcon" class="fa-solid fa-bars text-lg"></i>
            </button>
        </div>

        <nav class="space-y-2 px-3 text-gray-600 text-sm">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link hover:bg-[#8B0000] hover:text-[#F4F4F4]">
                <i class="fa-solid fa-chart-line text-lg"></i>
                <span class="sidebar-text font-bold opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">Dashboard</span>
                <span class="sidebar-tooltip absolute left-full ml-8 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">
                    Dashboard
                </span>
            </a>

            <a href="#" class="sidebar-link hover:bg-[#8B0000] hover:text-[#F4F4F4]">
                <i class="fa-solid fa-users text-lg"></i>
                <span class="sidebar-text opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">Patients</span>
                <span class="sidebar-tooltip absolute left-full ml-8 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">
                    Patients
                </span>
            </a>

            <a href="#" class="sidebar-link hover:bg-[#8B0000] hover:text-[#F4F4F4]">
                <i class="fa-solid fa-calendar-check text-lg"></i>
                <span class="sidebar-text opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">Appointments</span>
                <span class="sidebar-tooltip absolute left-full ml-8 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">
                    Appointments
                </span>
            </a>

            <a href="#" class="sidebar-link hover:bg-[#8B0000] hover:text-[#F4F4F4]">
                <i class="fa-solid fa-school text-lg"></i>
                <span class="sidebar-text opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">Academic Periods</span>
                <span class="sidebar-tooltip absolute left-full ml-8 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">
                    Academic Periods
                </span>
            </a>

            <a href="#" class="sidebar-link hover:bg-[#8B0000] hover:text-[#F4F4F4]">
                <i class="fa-solid fa-file-circle-check text-lg"></i>
                <span class="sidebar-text opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">Document Requests</span>
                <span class="sidebar-tooltip absolute left-full ml-8 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">
                    Document Requests
                </span>
            </a>

            <a href="#" class="sidebar-link hover:bg-[#8B0000] hover:text-[#F4F4F4]">
                <i class="fa-solid fa-file-pen text-lg"></i>
                <span class="sidebar-text opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">Document Template</span>
                <span class="sidebar-tooltip absolute left-full ml-8 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">
                    Document Template
                </span>
            </a>

            <a href="#" class="sidebar-link hover:bg-[#8B0000] hover:text-[#F4F4F4]">
                <i class="fa-solid fa-file text-lg"></i>
                <span class="sidebar-text opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">Reports</span>
                <span class="sidebar-tooltip absolute left-full ml-8 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">
                    Reports
                </span>
            </a>

            <div class="pt-3 text-[10px] uppercase tracking-widest text-gray-400 px-2">System</div>

            <a href="#" class="sidebar-link hover:bg-[#8B0000] hover:text-[#F4F4F4]">
                <i class="fa-solid fa-database text-lg"></i>
                <span class="sidebar-text opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">Data Backup</span>
                <span class="sidebar-tooltip absolute left-full ml-8 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">
                    Data Backup
                </span>
            </a>

            <a href="#" class="sidebar-link hover:bg-[#8B0000] hover:text-[#F4F4F4]">
                <i class="fa-solid fa-clipboard-list text-lg"></i>
                <span class="sidebar-text opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">System Logs</span>
                <span class="sidebar-tooltip absolute left-full ml-8 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">
                    System Logs
                </span>
            </a>

            <a href="#" class="sidebar-link hover:bg-[#8B0000] hover:text-[#F4F4F4]">
                <i class="fa-solid fa-gear text-lg"></i>
                <span class="sidebar-text opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">System Settings</span>
                <span class="sidebar-tooltip absolute left-full ml-8 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">
                    System Settings
                </span>
            </a>

            <a href="{{ route('admin.role_permissions') }}" class="sidebar-link bg-[#8B0000] text-[#F4F4F4] hover:bg-[#8B0000] hover:text-[#F4F4F4] relative">
                <span class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000] opacity-100"></span>
                <i class="fa-solid fa-user-shield text-lg"></i>
                <span class="sidebar-text font-bold opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">Roles</span>
                <span class="sidebar-tooltip absolute left-full ml-8 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">
                    Roles
                </span>
            </a>
        </nav>
    </div>

    <div class="px-3 pb-5 space-y-2">
        <button id="themeToggle"
            class="sidebar-link relative flex items-center justify-center w-full px-2 py-1.5 rounded-xl
                   bg-[#7B6CF6] text-[#F4F4F4] transition-all duration-200 hover:scale-105">
            <i id="themeIcon" class="fa-regular fa-moon text-sm"></i>
            <span class="sidebar-text text-sm opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">Dark Mode</span>
            <span class="sidebar-tooltip absolute left-full ml-8 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">
                Dark Mode
            </span>
        </button>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="sidebar-link w-full relative flex items-center px-3 py-2 rounded-xl text-sm
                           text-red-600 hover:bg-red-50 transition-all duration-200">
                <i class="fa-solid fa-right-from-bracket text-sm"></i>
                <span class="sidebar-text opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">Log out</span>
                <span class="sidebar-tooltip absolute left-full ml-8 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">
                    Log out
                </span>
            </button>
        </form>
    </div>
</aside>

<!-- MAIN -->
<main id="mainContent" class="pt-[100px] px-6 pb-10 w-full">
    <div class="max-w-7xl mx-auto">

        <div class="mb-5">
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <i class="fa-solid fa-shield-halved text-[#8B0000] text-xs"></i>
                <p>System Role and Permission Management</p>
            </div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-[#8B0000] mt-1">Role Permissions</h1>
            <p class="text-gray-500 mt-2">Manage access for Super Admin, Dentist, and Patient by module and feature.</p>
        </div>

        @if(session('success'))
            <div class="mb-5 rounded-xl bg-green-50 border border-green-200 px-4 py-3 text-green-800 text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow border overflow-hidden">
            <div class="px-6 py-4 border-b flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <div>
                    <h2 class="text-xl font-bold text-[#8B0000]">Permissions Matrix</h2>
                    <p class="text-sm text-gray-500">Check or uncheck access for each role, then save your changes.</p>
                </div>

                <div class="flex gap-3">
                    <form action="{{ route('admin.role_permissions.reset') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 font-semibold hover:bg-gray-50">
                            Reset Defaults
                        </button>
                    </form>

                    <button type="submit" form="permissions-form"
                        class="px-4 py-2 rounded-lg bg-[#8B0000] text-white font-semibold hover:bg-[#6f0000]">
                        Save Changes
                    </button>
                </div>
            </div>

            <form id="permissions-form" action="{{ route('admin.role_permissions.update') }}" method="POST">
                @csrf

                <div class="overflow-x-auto max-h-[70vh] table-sticky">
                    <table class="min-w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="text-left px-6 py-4 border-b font-bold text-gray-700 min-w-[300px]">
                                    Module / Feature
                                </th>

                                @foreach($roles as $role)
                                    <th class="text-center px-6 py-4 border-b font-bold text-gray-700 min-w-[180px]">
                                        <div>{{ $role->name }}</div>
                                        <div class="text-xs font-medium text-gray-400 mt-1">
                                            {{ $role->slug }}
                                        </div>
                                    </th>
                                @endforeach
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($groupedPermissions as $module => $permissions)
                                <tr class="permission-section">
                                    <td colspan="{{ count($roles) + 1 }}"
                                        class="px-6 py-3 border-b font-extrabold uppercase tracking-wider text-gray-800 text-sm">
                                        {{ $module }}
                                    </td>
                                </tr>

                                @foreach($permissions as $permission)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 border-b text-gray-800">
                                            <div class="font-semibold">{{ $permission->name }}</div>
                                            <div class="text-xs text-gray-400 mt-1">{{ $permission->slug }}</div>
                                        </td>

                                        @foreach($roles as $role)
                                            <td class="px-6 py-4 border-b text-center">
                                                <input
                                                    type="checkbox"
                                                    name="permissions[{{ $role->id }}][]"
                                                    value="{{ $permission->id }}"
                                                    class="permission-checkbox"
                                                    {{ $role->permissions->contains('id', $permission->id) ? 'checked' : '' }}
                                                >
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="{{ count($roles) + 1 }}" class="px-6 py-10 text-center text-gray-500">
                                        No permissions found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </form>
        </div>

        <div class="mt-5">
            <a href="{{ route('admin.dashboard') }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-[#8B0000] text-white font-semibold hover:bg-[#6f0000]">
                <i class="fa-solid fa-arrow-left"></i>
                Back to Dashboard
            </a>
        </div>
    </div>
</main>

<footer class="footer sm:footer-horizontal mt-auto bg-[#660000] text-[#F4F4F4] p-10"></footer>

<script>
    let sidebarOpen = false;

    function applyLayout(sidebarWidth) {
        const sidebar = document.getElementById('sidebar');
        const main = document.getElementById('mainContent');
        sidebar.style.width = sidebarWidth;
        main.style.marginLeft = sidebarWidth;
        main.style.width = 'auto';
    }

    function toggleSidebar() {
        const toggleWrapper = document.getElementById('sidebarToggleWrapper');
        const toggleBtn = document.getElementById('sidebarToggleBtn');
        const texts = document.querySelectorAll('.sidebar-text');
        const icon = document.getElementById('sidebarIcon');

        sidebarOpen = !sidebarOpen;

        if (sidebarOpen) {
            applyLayout('16rem');
            texts.forEach(t => {
                t.classList.remove('opacity-0', 'w-0');
                t.classList.add('opacity-100', 'w-auto');
            });
            toggleWrapper.classList.remove('justify-center');
            toggleWrapper.classList.add('justify-end');
            toggleBtn.classList.add('translate-x-2');
            icon.classList.replace('fa-bars', 'fa-xmark');
        } else {
            applyLayout('72px');
            texts.forEach(t => {
                t.classList.add('opacity-0', 'w-0');
                t.classList.remove('opacity-100', 'w-auto');
            });
            toggleWrapper.classList.remove('justify-end');
            toggleWrapper.classList.add('justify-center');
            toggleBtn.classList.remove('translate-x-2');
            icon.classList.replace('fa-xmark', 'fa-bars');
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        sidebarOpen = false;
        applyLayout('72px');
    });

    document.addEventListener("DOMContentLoaded", () => {
        const btn = document.getElementById("notifBtn");
        const menu = document.getElementById("notifMenu");
        if (!btn || !menu) return;

        let isOpen = false;

        function openMenu() {
            isOpen = true;
            menu.classList.remove("notif-close");
            menu.classList.add("notif-open");
        }

        function closeMenu() {
            isOpen = false;
            menu.classList.remove("notif-open");
            menu.classList.add("notif-close");
        }

        btn.addEventListener("click", (e) => {
            e.stopPropagation();
            isOpen ? closeMenu() : openMenu();
        });

        menu.addEventListener("click", (e) => e.stopPropagation());
        document.addEventListener("click", () => { if (isOpen) closeMenu(); });
        document.addEventListener("keydown", (e) => { if (e.key === "Escape" && isOpen) closeMenu(); });

        closeMenu();
    });
</script>

</body>
</html>