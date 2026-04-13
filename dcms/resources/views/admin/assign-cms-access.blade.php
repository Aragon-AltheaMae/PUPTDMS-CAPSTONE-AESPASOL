@extends('layouts.admin')

@section('title', 'Assign CMS Access | PUP Taguig Dental Clinic')

@section('styles')
    <style>
        .access-page {
            padding-top: var(--header-h, 0);
            min-height: 100vh;
            background: #f5f6fa;
        }

        .access-shell {
            padding: 2rem;
        }

        .access-card {
            max-width: 980px;
            margin: 0 auto;
            background: #fff;
            border-radius: 24px;
            border: 1px solid rgba(0, 0, 0, .05);
            box-shadow: 0 14px 42px rgba(0, 0, 0, .10);
            overflow: visible;
        }

        .access-card-header {
            background: linear-gradient(135deg, #8b0000 0%, #a40000 100%);
            color: #fff;
            border-radius: 24px 24px 0 0;
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .access-header-left {
            display: flex;
            align-items: center;
            gap: .85rem;
        }

        .access-header-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: rgba(255, 255, 255, .14);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        .access-title {
            margin: 0;
            font-size: 1.6rem;
            font-weight: 800;
            line-height: 1.1;
        }

        .access-subtitle {
            margin: .2rem 0 0;
            font-size: .84rem;
            color: rgba(255, 255, 255, .78);
        }

        .access-card-body {
            padding: 1.5rem;
        }

        .access-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem 1.15rem;
        }

        .access-grid-3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 1rem 1.15rem;
        }

        .field-group {
            min-width: 0;
        }

        .field-group.full {
            grid-column: 1 / -1;
        }

        .field-label {
            display: block;
            font-size: .92rem;
            font-weight: 700;
            color: #7a4b4b;
            margin-bottom: .45rem;
        }

        .required-mark {
            color: #dc2626;
            margin-left: 2px;
        }

        .access-input,
        .access-select {
            width: 100%;
            border: 1px solid #e7d7d7;
            border-radius: 14px;
            padding: .95rem 1rem;
            font-size: 1rem;
            line-height: 1.3;
            background: #fff;
            color: #374151;
            outline: none;
            transition: all .15s ease;
        }

        .access-input:focus,
        .access-select:focus {
            border-color: #b91c1c;
            box-shadow: 0 0 0 4px rgba(185, 28, 28, .08);
        }

        .search-combo {
            position: relative;
        }

        .search-input-wrap {
            display: grid;
            grid-template-columns: 1fr 54px;
            gap: .6rem;
        }

        .dropdown-toggle-btn {
            border: 1px solid #e7d7d7;
            border-radius: 14px;
            background: #fff;
            color: #7b7b86;
            font-size: 1rem;
            cursor: pointer;
            transition: all .15s ease;
        }

        .dropdown-toggle-btn:hover {
            background: #fdf2f2;
            border-color: #d8b4b4;
            color: #8b0000;
        }

        .dropdown-toggle-btn:focus {
            outline: none;
            border-color: #b91c1c;
            box-shadow: 0 0 0 4px rgba(185, 28, 28, .08);
        }

        .search-results {
            position: absolute;
            left: 0;
            right: 0;
            top: calc(100% + 8px);
            background: #fff;
            border: 1px solid #eadede;
            border-radius: 18px;
            box-shadow: 0 18px 40px rgba(0, 0, 0, .12);
            max-height: 290px;
            overflow-y: auto;
            display: none;
            z-index: 9999;
        }

        .search-results::-webkit-scrollbar {
            width: 6px;
        }

        .search-results::-webkit-scrollbar-thumb {
            background: #ddd;
            border-radius: 10px;
        }

        .search-item {
            width: 100%;
            border: 0;
            background: #fff;
            text-align: left;
            padding: 1rem 1.1rem;
            cursor: pointer;
            border-bottom: 1px solid #f3eded;
            transition: background .15s ease;
        }

        .search-item:last-child {
            border-bottom: none;
        }

        .search-item:hover {
            background: #fff6f6;
        }

        .search-name {
            font-size: 1rem;
            font-weight: 800;
            color: #111827;
            margin-bottom: .2rem;
        }

        .search-email {
            font-size: .88rem;
            color: #6b7280;
        }

        .search-empty {
            padding: .95rem 1rem;
            font-size: .92rem;
            color: #7c7c89;
        }

        .field-help {
            margin-top: .45rem;
            font-size: .82rem;
            color: #7c7c89;
        }

        .section-note {
            margin: .3rem 0 1.15rem;
            font-size: .84rem;
            color: #7c7c89;
        }

        .access-card-footer {
            padding: 1.15rem 1.5rem 1.4rem;
            border-top: 1px solid #f1f1f4;
            display: flex;
            justify-content: flex-end;
            gap: .8rem;
        }

        .btn-cancel,
        .btn-save {
            border: none;
            border-radius: 14px;
            padding: .95rem 1.3rem;
            font-size: .98rem;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            gap: .6rem;
            cursor: pointer;
            transition: all .15s ease;
        }

        .btn-cancel {
            background: #f3f4f6;
            color: #4b5563;
            border: 1px solid #e5e7eb;
        }

        .btn-cancel:hover {
            background: #e5e7eb;
        }

        .btn-save {
            background: linear-gradient(135deg, #8b0000 0%, #a40000 100%);
            color: #fff;
            box-shadow: 0 10px 24px rgba(139, 0, 0, .22);
        }

        .btn-save:hover {
            transform: translateY(-1px);
            box-shadow: 0 12px 28px rgba(139, 0, 0, .28);
        }

        @media (max-width: 900px) {
            .access-shell {
                padding: 1rem;
            }

            .access-grid,
            .access-grid-3 {
                grid-template-columns: 1fr;
            }

            .access-card-footer {
                flex-direction: column;
            }

            .btn-cancel,
            .btn-save {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
@endsection

@section('content')
    <main class="access-page">
        <div class="access-shell">
            <div class="access-card">
                <div class="access-card-header">
                    <div class="access-header-left">
                        <div class="access-header-icon">
                            <i class="fa-solid fa-user-plus"></i>
                        </div>
                        <div>
                            <h2 class="access-title">Assign CMS Access</h2>
                            <p class="access-subtitle">Select a user from the external admin list and review the synced
                                information below.</p>
                        </div>
                    </div>
                </div>
                @if (session('success'))
                    <div
                        style="margin: 1rem 1.5rem 0; padding: .9rem 1rem; border-radius: 12px; background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0;">
                        {{ session('success') }}
                    </div>
                @endif

                <form id="assignCmsAccessForm" method="POST" action="{{ route('admin.assign-cms-access.store') }}">
                    @csrf

                    <div class="access-card-body">
                        <div class="section-note">
                            Use the search box or open the dropdown list to choose an admin user.
                        </div>

                        <div class="access-grid">
                            <div class="field-group full search-combo">
                                <label for="user_search" class="field-label">
                                    Select User<span class="required-mark">*</span>
                                </label>

                                <div class="search-input-wrap">
                                    <input type="text" id="user_search" class="access-input"
                                        placeholder="Search faculty by name or email" autocomplete="off">

                                    <button type="button" id="toggleUserDropdown" class="dropdown-toggle-btn"
                                        aria-label="Show user list">
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </button>
                                </div>

                                <div id="searchResults" class="search-results"></div>

                                <div class="field-help">
                                    Click the dropdown button to view available users, or type to filter the list.
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="external_admin_id" id="external_admin_id">

                        <div class="access-grid" style="margin-top:1rem;">
                            <div class="field-group">
                                <label for="fname" class="field-label">First Name</label>
                                <input type="text" name="fname" id="fname" class="access-input">
                            </div>

                            <div class="field-group">
                                <label for="lname" class="field-label">Last Name</label>
                                <input type="text" name="lname" id="lname" class="access-input">
                            </div>

                            <div class="field-group">
                                <label for="email" class="field-label">Email</label>
                                <input type="email" name="email" id="email" class="access-input">
                            </div>

                            <div class="field-group">
                                <label for="office" class="field-label">Office</label>
                                <input type="text" name="office" id="office" class="access-input">
                            </div>

                            <div class="field-group">
                                <label for="address" class="field-label">Address</label>
                                <input type="text" name="address" id="address" class="access-input">
                            </div>

                            <div class="field-group">
                                <label for="age" class="field-label">Age</label>
                                <input type="number" name="age" id="age" class="access-input">
                            </div>
                        </div>

                        <div class="access-grid-3" style="margin-top:1rem;">
                            <div class="field-group">
                                <label for="gender" class="field-label">Gender</label>
                                <input type="text" name="gender" id="gender" class="access-input">
                            </div>

                            <div class="field-group">
                                <label for="contact_number" class="field-label">Contact Number</label>
                                <input type="text" name="contact_number" id="contact_number" class="access-input">
                            </div>

                            <div class="field-group">
                                <label for="senior_pwd" class="field-label">Senior/PWD</label>
                                <input type="text" name="senior_pwd" id="senior_pwd" class="access-input">
                            </div>

                            <div class="field-group">
                                <label for="cms_role" class="field-label">CMS Role<span
                                        class="required-mark">*</span></label>
                                <select name="cms_role" id="cms_role" class="access-select" required>
                                    <option value="">Select CMS role</option>
                                    <option value="admin">Admin</option>
                                    <option value="patient">Patient</option>
                                    <option value="dentist">Dentist</option>
                                </select>
                            </div>
                            <div class="field-group">
                                <label for="cms_status" class="field-label">CMS Access Status<span
                                        class="required-mark">*</span></label>
                                <select name="cms_status" id="cms_status" class="access-select" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="access-card-footer">
                        <button type="button" class="btn-cancel">
                            <i class="fa-solid fa-xmark"></i>
                            Cancel
                        </button>

                        <button type="submit" class="btn-save">
                            <i class="fa-solid fa-user-plus"></i>
                            Save Access
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('user_search');
            const toggleButton = document.getElementById('toggleUserDropdown');
            const resultsBox = document.getElementById('searchResults');

            const externalAdminId = document.getElementById('external_admin_id');
            const fname = document.getElementById('fname');
            const lname = document.getElementById('lname');
            const email = document.getElementById('email');
            const office = document.getElementById('office');
            const address = document.getElementById('address');
            const age = document.getElementById('age');
            const gender = document.getElementById('gender');
            const contactNumber = document.getElementById('contact_number');
            const seniorPwd = document.getElementById('senior_pwd');

            let debounceTimer = null;
            let abortController = null;
            let requestSequence = 0;
            let lastLoadedUsers = [];
            let dropdownOpen = false;
            let isLoadingUsers = false;

            function hideResults() {
                resultsBox.style.display = 'none';
                dropdownOpen = false;
            }

            function showResults() {
                resultsBox.style.display = 'block';
                dropdownOpen = true;
            }

            function clearFormFields() {
                externalAdminId.value = '';
                fname.value = '';
                lname.value = '';
                email.value = '';
                office.value = '';
                address.value = '';
                age.value = '';
                gender.value = '';
                contactNumber.value = '';
                seniorPwd.value = '';
            }

            function fillUser(user) {
                externalAdminId.value = user.admin_id ?? '';
                searchInput.value = user.full_name ?? '';
                fname.value = user.fname ?? '';
                lname.value = user.lname ?? '';
                email.value = user.email ?? '';
                office.value = user.office ?? '';
                address.value = user.address ?? '';
                age.value = user.age ?? '';
                gender.value = user.gender ?? '';
                contactNumber.value = user.contact_number ?? '';
                seniorPwd.value = user.senior_pwd ?? '';
                hideResults();
            }

            function renderNoResults(message = 'No results found.') {
                resultsBox.innerHTML = `<div class="search-empty">${message}</div>`;
                showResults();
            }

            function renderResults(users) {
                resultsBox.innerHTML = '';

                users.forEach(user => {
                    const item = document.createElement('button');
                    item.type = 'button';
                    item.className = 'search-item';

                    item.innerHTML = `
                <div class="search-name">${user.full_name ?? ''}</div>
                <div class="search-email">${user.email ?? ''}</div>
            `;

                    item.addEventListener('click', function(event) {
                        event.preventDefault();
                        fillUser(user);
                    });

                    resultsBox.appendChild(item);
                });

                showResults();
            }

            async function fetchUsers(query = '') {
                const trimmedQuery = query.trim();

                if (isLoadingUsers) return;
                isLoadingUsers = true;

                if (abortController) {
                    abortController.abort();
                }

                abortController = new AbortController();
                const currentRequest = ++requestSequence;

                const url = trimmedQuery.length > 0 ?
                    `/admin/external-admins/search?search=${encodeURIComponent(trimmedQuery)}` :
                    `/admin/external-admins/search`;

                try {
                    const response = await fetch(url, {
                        method: 'GET',
                        signal: abortController.signal,
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}`);
                    }

                    const data = await response.json();

                    if (currentRequest !== requestSequence) return;

                    if (!data || !data.success || !Array.isArray(data.data)) {
                        throw new Error('Invalid response format');
                    }

                    lastLoadedUsers = data.data;

                    if (data.data.length === 0) {
                        renderNoResults(trimmedQuery ? 'No results found.' : 'No users available.');
                        return;
                    }

                    renderResults(data.data);
                } catch (error) {
                    if (error.name === 'AbortError') return;

                    console.error('Search error:', error);

                    if (lastLoadedUsers.length > 0) {
                        renderResults(lastLoadedUsers);
                        return;
                    }

                    renderNoResults('Unable to load users.');
                } finally {
                    isLoadingUsers = false;
                }
            }

            searchInput.addEventListener('input', function() {
                const query = this.value.trim();

                clearTimeout(debounceTimer);
                clearFormFields();

                debounceTimer = setTimeout(() => {
                    if (query.length === 0) {
                        if (lastLoadedUsers.length > 0) {
                            renderResults(lastLoadedUsers);
                        } else {
                            fetchUsers('');
                        }
                    } else {
                        fetchUsers(query);
                    }
                }, 300);
            });

            toggleButton.addEventListener('click', function(event) {
                event.preventDefault();
                event.stopPropagation();

                if (dropdownOpen) {
                    hideResults();
                    return;
                }

                if (searchInput.value.trim().length > 0) {
                    fetchUsers(searchInput.value.trim());
                    return;
                }

                if (lastLoadedUsers.length > 0) {
                    renderResults(lastLoadedUsers);
                    return;
                }

                fetchUsers('');
            });

            searchInput.addEventListener('focus', function() {
                if (this.value.trim().length > 0) {
                    if (lastLoadedUsers.length > 0) {
                        renderResults(lastLoadedUsers);
                    } else {
                        fetchUsers(this.value.trim());
                    }
                    return;
                }

                if (lastLoadedUsers.length > 0) {
                    renderResults(lastLoadedUsers);
                }
            });

            searchInput.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    hideResults();
                }
            });

            document.addEventListener('click', function(event) {
                const clickedInside =
                    searchInput.contains(event.target) ||
                    toggleButton.contains(event.target) ||
                    resultsBox.contains(event.target);

                if (!clickedInside) {
                    hideResults();
                }
            });
        });
    </script>
@endsection
