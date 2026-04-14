@extends('layouts.admin')

@section('title', 'Faculty Integration | PUP Taguig Dental Clinic')

@section('styles')
    <style>
        .access-page {
            padding-top: var(--header-h, 0);
            min-height: 100vh;
            background: #f5f6fa;
            width: 100%;
            overflow-x: hidden;
            box-sizing: border-box;
            padding-left: 280px;
        }

        .access-shell {
            padding: 2rem;
            width: 100%;
            box-sizing: border-box;
        }

        .access-card {
            width: 100%;
            max-width: none;
            margin: 0;
            background: #fff;
            border-radius: 24px;
            border: 1px solid rgba(0, 0, 0, .05);
            box-shadow: 0 14px 42px rgba(0, 0, 0, .10);
            overflow: visible;
            box-sizing: border-box;
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
            box-sizing: border-box;
        }

        .access-input:focus,
        .access-select:focus {
            border-color: #b91c1c;
            box-shadow: 0 0 0 4px rgba(185, 28, 28, .08);
        }

        .access-input[readonly] {
            background: #fafafa;
            color: #4b5563;
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
            text-decoration: none;
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

        .alert-success {
            margin: 1rem 1.5rem 0;
            padding: .9rem 1rem;
            border-radius: 12px;
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert-error {
            margin: 1rem 1.5rem 0;
            padding: .9rem 1rem;
            border-radius: 12px;
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        @media (max-width: 900px) {
            .access-page {
                padding-left: 0;
            }

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
                            <i class="fa-solid fa-user-graduate"></i>
                        </div>
                        <div>
                            <h2 class="access-title">Faculty Integration</h2>
                            <p class="access-subtitle">
                                Select a faculty member from the external system and review the synced information below.
                            </p>
                        </div>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert-error">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert-error">
                        <ul style="margin: 0; padding-left: 1.2rem;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.faculty.store') }}">
                    @csrf

                    <div class="access-card-body">
                        <div class="section-note">
                            Use the search box or open the dropdown list to choose a faculty member.
                        </div>

                        <div class="access-grid">
                            <div class="field-group full search-combo">
                                <label for="faculty_search" class="field-label">
                                    Select Faculty<span class="required-mark">*</span>
                                </label>

                                <div class="search-input-wrap">
                                    <input type="text" id="faculty_search" class="access-input"
                                        placeholder="Search faculty by name or email" autocomplete="off">

                                    <button type="button" id="toggleFacultyDropdown" class="dropdown-toggle-btn"
                                        aria-label="Show faculty list">
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </button>
                                </div>

                                <div id="facultyResults" class="search-results"></div>

                                <div class="field-help">
                                    Click the dropdown button to view available faculty, or type to filter the list.
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="faculty_json" name="faculty_json">

                        <div class="access-grid" style="margin-top: 1rem;">
                            <div class="field-group">
                                <label for="faculty_id" class="field-label">External Faculty ID</label>
                                <input type="text" id="faculty_id" class="access-input" readonly>
                            </div>

                            <div class="field-group">
                                <label for="faculty_code" class="field-label">Faculty Code</label>
                                <input type="text" id="faculty_code" class="access-input" readonly>
                            </div>

                            <div class="field-group">
                                <label for="first_name" class="field-label">First Name</label>
                                <input type="text" id="first_name" class="access-input" readonly>
                            </div>

                            <div class="field-group">
                                <label for="middle_name" class="field-label">Middle Name</label>
                                <input type="text" id="middle_name" class="access-input" readonly>
                            </div>

                            <div class="field-group">
                                <label for="last_name" class="field-label">Last Name</label>
                                <input type="text" id="last_name" class="access-input" readonly>
                            </div>

                            <div class="field-group">
                                <label for="suffix_name" class="field-label">Suffix Name</label>
                                <input type="text" id="suffix_name" class="access-input" readonly>
                            </div>

                            <div class="field-group">
                                <label for="faculty_type" class="field-label">Faculty Type</label>
                                <input type="text" id="faculty_type" class="access-input" readonly>
                            </div>

                            <div class="field-group">
                                <label for="department" class="field-label">Department</label>
                                <input type="text" id="department" class="access-input" readonly>
                            </div>

                            <div class="field-group full">
                                <label for="email" class="field-label">Email</label>
                                <input type="email" id="email" class="access-input" readonly>
                            </div>
                        </div>

                        <div class="access-grid-3" style="margin-top: 1rem;">
                            <div class="field-group">
                                <label for="birthday" class="field-label">Birthday</label>
                                <input type="text" id="birthday" class="access-input" readonly>
                            </div>

                            <div class="field-group">
                                <label for="gender" class="field-label">Gender</label>
                                <input type="text" id="gender" class="access-input" readonly>
                            </div>

                            <div class="field-group">
                                <label for="zipcode" class="field-label">Zipcode</label>
                                <input type="text" id="zipcode" class="access-input" readonly>
                            </div>
                        </div>

                        <div class="access-grid-3" style="margin-top: 1rem;">
                            <div class="field-group">
                                <label for="house_num" class="field-label">House / Unit No.</label>
                                <input type="text" id="house_num" class="access-input" readonly>
                            </div>

                            <div class="field-group">
                                <label for="street" class="field-label">Street</label>
                                <input type="text" id="street" class="access-input" readonly>
                            </div>

                            <div class="field-group">
                                <label for="barangay" class="field-label">Barangay</label>
                                <input type="text" id="barangay" class="access-input" readonly>
                            </div>

                            <div class="field-group">
                                <label for="city" class="field-label">City</label>
                                <input type="text" id="city" class="access-input" readonly>
                            </div>

                            <div class="field-group">
                                <label for="province" class="field-label">Province</label>
                                <input type="text" id="province" class="access-input" readonly>
                            </div>

                            <div class="field-group">
                                <label for="country" class="field-label">Country</label>
                                <input type="text" id="country" class="access-input" readonly>
                            </div>
                        </div>

                        <div class="access-grid" style="margin-top: 1rem;">
                            <div class="field-group">
                                <label for="cms_role" class="field-label">
                                    CMS Role<span class="required-mark">*</span>
                                </label>
                                <select name="cms_role" id="cms_role" class="access-select" required>
                                    <option value="">Select CMS Role</option>
                                    <option value="patient">Patient</option>
                                    <option value="admin">Admin</option>
                                    <option value="dentist">Dentist</option>
                                </select>
                            </div>

                            <div class="field-group">
                                <label for="account_status" class="field-label">
                                    Account Status<span class="required-mark">*</span>
                                </label>
                                <select name="account_status" id="account_status" class="access-select" required>
                                    <option value="">Select Status</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="access-card-footer">
                        <button type="button" class="btn-cancel" onclick="window.history.back();">
                            <i class="fa-solid fa-xmark"></i>
                            Cancel
                        </button>

                        <button type="submit" class="btn-save">
                            <i class="fa-solid fa-floppy-disk"></i>
                            Save Faculty
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
            const searchInput = document.getElementById('faculty_search');
            const toggleButton = document.getElementById('toggleFacultyDropdown');
            const resultsBox = document.getElementById('facultyResults');

            const facultyJson = document.getElementById('faculty_json');
            const facultyId = document.getElementById('faculty_id');
            const firstName = document.getElementById('first_name');
            const middleName = document.getElementById('middle_name');
            const lastName = document.getElementById('last_name');
            const suffixName = document.getElementById('suffix_name');
            const facultyCode = document.getElementById('faculty_code');
            const facultyType = document.getElementById('faculty_type');
            const department = document.getElementById('department');
            const email = document.getElementById('email');
            const birthday = document.getElementById('birthday');
            const gender = document.getElementById('gender');
            const houseNum = document.getElementById('house_num');
            const street = document.getElementById('street');
            const barangay = document.getElementById('barangay');
            const city = document.getElementById('city');
            const province = document.getElementById('province');
            const country = document.getElementById('country');
            const zipcode = document.getElementById('zipcode');

            let faculties = [];
            let dropdownOpen = false;

            function showResults() {
                resultsBox.style.display = 'block';
                dropdownOpen = true;
            }

            function hideResults() {
                resultsBox.style.display = 'none';
                dropdownOpen = false;
            }

            function clearFields() {
                facultyJson.value = '';
                facultyId.value = '';
                firstName.value = '';
                middleName.value = '';
                lastName.value = '';
                suffixName.value = '';
                facultyCode.value = '';
                facultyType.value = '';
                department.value = '';
                email.value = '';
                birthday.value = '';
                gender.value = '';
                houseNum.value = '';
                street.value = '';
                barangay.value = '';
                city.value = '';
                province.value = '';
                country.value = '';
                zipcode.value = '';
            }

            function fillFaculty(faculty) {
                const profile = faculty.profile ?? {};
                const address = profile.address ?? {};

                facultyJson.value = JSON.stringify(faculty);
                searchInput.value = `${faculty.first_name ?? ''} ${faculty.last_name ?? ''}`.trim();

                facultyId.value = faculty.faculty_id ?? '';
                firstName.value = faculty.first_name ?? '';
                middleName.value = faculty.middle_name ?? '';
                lastName.value = faculty.last_name ?? '';
                suffixName.value = faculty.suffix_name ?? '';
                facultyCode.value = faculty.faculty_code ?? '';
                facultyType.value = faculty.faculty_type ?? '';
                department.value = faculty.department ?? '';
                email.value = faculty.email ?? '';
                birthday.value = profile.birthday ?? '';
                gender.value = profile.gender ?? '';
                houseNum.value = address.house_num ?? '';
                street.value = address.street ?? '';
                barangay.value = address.barangay ?? '';
                city.value = address.city ?? '';
                province.value = address.province ?? '';
                country.value = address.country ?? '';
                zipcode.value = address.zipcode ?? '';

                hideResults();
            }

            function renderNoResults(message = 'No results found.') {
                resultsBox.innerHTML = `<div class="search-empty">${message}</div>`;
                showResults();
            }

            function renderResults(list) {
                resultsBox.innerHTML = '';

                if (!Array.isArray(list) || list.length === 0) {
                    renderNoResults();
                    return;
                }

                list.forEach(faculty => {
                    const item = document.createElement('button');
                    item.type = 'button';
                    item.className = 'search-item';

                    const fullName = `${faculty.first_name ?? ''} ${faculty.last_name ?? ''}`.trim();

                    item.innerHTML = `
                        <div class="search-name">${fullName || 'Unnamed Faculty'}</div>
                        <div class="search-email">${faculty.email ?? ''}</div>
                    `;

                    item.addEventListener('click', function(event) {
                        event.preventDefault();
                        fillFaculty(faculty);
                    });

                    resultsBox.appendChild(item);
                });

                showResults();
            }

            function filterFaculties(query) {
                const q = query.trim().toLowerCase();

                if (q === '') {
                    return faculties;
                }

                return faculties.filter(faculty => {
                    const fullName = `${faculty.first_name ?? ''} ${faculty.last_name ?? ''}`.toLowerCase();
                    const mail = (faculty.email ?? '').toLowerCase();
                    const code = (faculty.faculty_code ?? '').toLowerCase();
                    return fullName.includes(q) || mail.includes(q) || code.includes(q);
                });
            }

            fetch('/faculties', {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    faculties = Array.isArray(data) ? data : [];
                })
                .catch(error => {
                    console.error('Failed to load faculties:', error);
                    faculties = [];
                });

            searchInput.addEventListener('input', function() {
                const query = this.value;
                const filtered = filterFaculties(query);

                if (query.trim() === '' && facultyJson.value !== '') {
                    clearFields();
                }

                renderResults(filtered);
            });

            toggleButton.addEventListener('click', function(event) {
                event.preventDefault();
                event.stopPropagation();

                if (dropdownOpen) {
                    hideResults();
                    return;
                }

                renderResults(filterFaculties(searchInput.value));
            });

            searchInput.addEventListener('focus', function() {
                if (faculties.length > 0) {
                    renderResults(filterFaculties(searchInput.value));
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