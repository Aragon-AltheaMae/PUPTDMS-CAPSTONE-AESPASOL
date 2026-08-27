@extends('layouts.app')

@section('layout-role', 'admin')

@section('title', 'Faculty Integration')

@section('styles')
    @vite('resources/css/pages/admin/faculty-integration.css')
@endsection

@section('content')

<main id="mainContent" class="admin-page-shell faculty-page page-enter">
    <div class="w-full">
        <div class="page-banner faculty-banner" style="display:flex!important; align-items:center!important;
                    justify-content:flex-start!important; text-align:left!important;">
            <div class="page-banner-inner faculty-banner-inner" style="width:100%!important;max-width:none!important;
                        margin:0!important;display:flex!important;
                        align-items:center!important;justify-content:flex-start!important;
                        text-align:left!important;">
                <div class="faculty-banner-title-wrap" style="width:100%!important;margin:0!important;
                            display:flex!important;align-items:center!important;
                            justify-content:flex-start!important;text-align:left!important;">
                    <h1 class="page-title faculty-banner-title" style="display:block!important;width:auto!important;
                                margin:0!important;margin-left:0!important;
                                margin-right:auto!important;text-align:left!important;
                                justify-self:start!important;align-self:center!important;">
                        Faculty Integration
                    </h1>
                </div>
            </div>
        </div>

        <div class="admin-page-body">

            <div class="faculty-layout">
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-header-icon">
                                <i class="fa-solid fa-user-graduate"></i>
                            </div>
                            <div>
                                <h2 class="card-title">Faculty Integration Form</h2>
                            </div>
                        </div>
                        <span class="entry-badge">Faculty Setup</span>
                    </div>

                    <form id="facultyIntegrationForm" method="POST" action="{{ route('admin.faculty.store') }}"
                        novalidate>
                        @csrf

                        <div class="card-body">
                            <div class="section-block">
                                <div class="section-head">
                                    <div class="section-head-left">
                                        <div class="section-icon">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                        </div>
                                        <div>
                                            <h3 class="section-title">Faculty Selection</h3>
                                        </div>
                                    </div>
                                </div>

                                <div class="faculty-grid">
                                    <div class="field-group full search-combo">
                                        <label for="faculty_search" class="field-label">
                                            Select Faculty<span class="required-mark">*</span>
                                        </label>

                                        <div class="faculty-search-row voice-search-row">
                                            <div class="search-input-wrap" data-search-wrapper>
                                                <i class="fa-solid fa-magnifying-glass faculty-search-leading-icon"></i>

                                                <input type="text" id="faculty_search"
                                                    class="access-input faculty-search-input"
                                                    placeholder="Search faculty by name, email, or faculty code"
                                                    autocomplete="off" data-search-input>

                                                <button type="button" id="facultySearchClearBtn"
                                                    class="faculty-search-clear-btn" data-search-clear
                                                    aria-label="Clear search">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </button>
                                            </div>

                                            <div class="voice-input-toggle">
                                                <button type="button" id="facultyMicBtn"
                                                    class="voice-search-mic external" data-voice-trigger
                                                    data-voice-target="#faculty_search"
                                                    data-voice-status="#facultyVoiceStatus"
                                                    aria-label="Toggle voice input" aria-pressed="false">
                                                    <i class="fa-solid fa-microphone"></i>
                                                </button>

                                                <span id="facultyVoiceStatus" class="voice-status hidden"
                                                    aria-live="polite"></span>
                                            </div>
                                        </div>

                                        <div id="facultyResults" class="search-results"></div>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" id="faculty_json" name="faculty_json">

                            <div class="section-block">
                                <div class="section-head">
                                    <div class="section-head-left">
                                        <div class="section-icon">
                                            <i class="fa-solid fa-id-card"></i>
                                        </div>
                                        <div>
                                            <h3 class="section-title">Synced Faculty Information</h3>
                                        </div>
                                    </div>
                                </div>

                                <div class="faculty-grid">
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

                                <div class="faculty-grid-3 admin-mt-4">
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

                                <div class="faculty-grid-3 admin-mt-4">
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
                            </div>

                            <div class="section-block">
                                <div class="section-head">
                                    <div class="section-head-left">
                                        <div class="section-icon">
                                            <i class="fa-solid fa-shield-halved"></i>
                                        </div>
                                        <div>
                                            <h3 class="section-title">Access Configuration</h3>
                                        </div>
                                    </div>
                                </div>

                                <div class="faculty-grid">
                                    <div class="field-group">
                                        <label for="cms_role" class="field-label">
                                            CMS Role<span class="required-mark">*</span>
                                        </label>
                                        <select name="cms_role" id="cms_role" class="access-select js-custom-select"
                                            data-select-type="role">
                                            <option value="" disabled selected hidden>Select CMS Role</option>
                                            <option value="patient">Patient</option>
                                            <option value="admin">Admin</option>
                                            <option value="dentist">Dentist</option>
                                        </select>
                                    </div>

                                    <div class="field-group">
                                        <label for="account_status" class="field-label">
                                            Account Status<span class="required-mark">*</span>
                                        </label>
                                        <select name="account_status" id="account_status"
                                            class="access-select js-custom-select" data-select-type="status">
                                            <option value="" disabled selected hidden>Select Status</option>
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="access-card-footer">
                            <button type="button" class="btn-reset" id="resetFacultyBtn">
                                <i class="fa-solid fa-rotate-left"></i>
                                Reset
                            </button>

                            <button type="submit" class="ui-btn ui-btn-primary">
                                <i class="fa-solid fa-floppy-disk"></i>
                                Save Faculty
                            </button>
                        </div>
                    </form>
                </div>

                <div class="sidebar-stack">
                    <div class="info-card">
                        <div class="preview-inner">
                            <div class="preview-avatar">
                                <i class="fa-solid fa-user-graduate"></i>
                            </div>

                            <div class="preview-name" id="preview_name">No faculty selected</div>
                            <div class="preview-email" id="preview_email">Select a faculty record to preview the
                                synced
                                information.</div>

                            <div class="preview-meta">
                                <div class="preview-meta-item">
                                    <div class="preview-meta-label">Faculty Code</div>
                                    <div class="preview-meta-value" id="preview_code">—</div>
                                </div>

                                <div class="preview-meta-item">
                                    <div class="preview-meta-label">Department</div>
                                    <div class="preview-meta-value" id="preview_department">—</div>
                                </div>

                                <div class="preview-meta-item">
                                    <div class="preview-meta-label">Faculty Type</div>
                                    <div class="preview-meta-value" id="preview_type">—</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="info-card quick-notes-card">
                        <div class="section-head quick-notes-head admin-mb-xs">
                            <div class="section-head-left">
                                <div class="section-icon">
                                    <i class="fa-solid fa-circle-info"></i>
                                </div>
                                <div>
                                    <h3 class="section-title quick-notes-title">Quick Notes</h3>
                                    <div class="section-note">Small guidance for cleaner admin workflow.</div>
                                </div>
                            </div>
                        </div>

                        <div class="tip-list">
                            <div class="tip-item">
                                <i class="fa-solid fa-check"></i>
                                <span>Select from the dropdown or filtered search results to keep faculty information
                                    accurately synced.</span>
                            </div>
                            <div class="tip-item">
                                <i class="fa-solid fa-user-gear"></i>
                                <span>Review the faculty type, department, and email before assigning the CMS
                                    role.</span>
                            </div>
                            <div class="tip-item">
                                <i class="fa-solid fa-shield"></i>
                                <span>Use <strong>Inactive</strong> status when the record should remain stored but
                                    account
                                    access must be disabled.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</main>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const searchInput = document.getElementById('faculty_search');
        const clearSearchButton = document.getElementById('facultySearchClearBtn');
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

        const previewName = document.getElementById('preview_name');
        const previewEmail = document.getElementById('preview_email');
        const previewCode = document.getElementById('preview_code');
        const previewDepartment = document.getElementById('preview_department');
        const previewType = document.getElementById('preview_type');
        const resetFacultyBtn = document.getElementById('resetFacultyBtn');

        let faculties = [];
        let dropdownOpen = false;
        let isDropdownMode = false;
        let facultyLoadError = '';
        let facultiesLoading = true;

        function openFacultyDropdown() {
            isDropdownMode = true;

            if (facultiesLoading) {
                renderNoResults('Loading faculty records...');
                return;
            }

            if (facultyLoadError) {
                renderNoResults(facultyLoadError);
                return;
            }

            const query = searchInput.value.trim();

            if (query) {
                const filtered = filterFaculties(query);

                filtered.length ?
                    renderResults(filtered) :
                    renderNoResults('No results found.');

                return;
            }

            faculties.length ?
                renderResults(faculties) :
                renderNoResults('No faculty records available.');
        }

        searchInput.addEventListener('focus', openFacultyDropdown);

        searchInput.addEventListener('click', function () {
            if (!dropdownOpen) {
                openFacultyDropdown();
            }
        });

        function toggleFacultySearchClear(input) {
            if (!clearSearchButton) return;

            clearSearchButton.classList.toggle('show', (input.value || '').trim().length > 0);
        }

        window.clearFacultySearch = function () {
            if (!searchInput) return;

            if (window.clearSearchInput) {
                window.clearSearchInput(searchInput);
            } else {
                searchInput.value = '';
                searchInput.dispatchEvent(new Event('input', {
                    bubbles: true
                }));
                searchInput.dispatchEvent(new Event('change', {
                    bubbles: true
                }));
                searchInput.focus();
            }

            clearFields();
            hideResults();
            toggleFacultySearchClear(searchInput);
        };

        function showResults() {
            if (!resultsBox.innerHTML.trim()) {
                hideResults();
                return;
            }

            resultsBox.classList.add('is-open');
            dropdownOpen = true;
        }

        function hideResults() {
            resultsBox.classList.remove('is-open');
            resultsBox.innerHTML = '';
            dropdownOpen = false;
            isDropdownMode = false;
        }

        function resetPreview() {
            previewName.textContent = 'No faculty selected';
            previewEmail.textContent = 'Select a faculty record to preview the synced information.';
            previewCode.textContent = '—';
            previewDepartment.textContent = '—';
            previewType.textContent = '—';
        }

        function clearFields() {
            facultyJson.value = '';
            facultyId.value = firstName.value = middleName.value = lastName.value =
                suffixName.value = facultyCode.value = facultyType.value =
                department.value = email.value = birthday.value = gender.value =
                houseNum.value = street.value = barangay.value = city.value =
                province.value = country.value = zipcode.value = '';
            resetPreview();
        }

        function resetFacultyForm() {
            facultyForm?.reset();

            searchInput.value = '';

            clearFields();
            hideResults();

            cmsRole.value = '';
            accountStatus.value = '';

            setFacultyFieldError(searchInput, '');
            setFacultyFieldError(cmsRole, '');
            setFacultyFieldError(accountStatus, '');

            document.querySelectorAll(
                '#facultyIntegrationForm .custom-select'
            ).forEach(wrapper => {
                window.syncCustomSelect?.(wrapper);
            });

            toggleFacultySearchClear(searchInput);
        }

        function fillFaculty(faculty) {
            const profile = faculty.profile ?? {};
            const addr = profile.address ?? {};

            facultyJson.value = JSON.stringify(faculty);
            setFacultyFieldError(searchInput, '');
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
            houseNum.value = addr.house_num ?? '';
            street.value = addr.street ?? '';
            barangay.value = addr.barangay ?? '';
            city.value = addr.city ?? '';
            province.value = addr.province ?? '';
            country.value = addr.country ?? '';
            zipcode.value = addr.zipcode ?? '';

            previewName.textContent = `${faculty.first_name ?? ''} ${faculty.last_name ?? ''}`.trim() ||
                'Selected faculty';
            previewEmail.textContent = faculty.email ?? 'No email available';
            previewCode.textContent = faculty.faculty_code ?? '—';
            previewDepartment.textContent = faculty.department ?? '—';
            previewType.textContent = faculty.faculty_type ?? '—';

            toggleFacultySearchClear(searchInput);
            hideResults();
        }

        function renderNoResults(message = 'No results found.') {
            resultsBox.innerHTML = '';
            const empty = document.createElement('div');
            empty.className = 'search-empty';
            empty.textContent = message;
            resultsBox.appendChild(empty);
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

                const fullName =
                    `${faculty.first_name ?? ''} ${faculty.middle_name ?? ''} ${faculty.last_name ?? ''}`
                        .replace(/\s+/g, ' ').trim();

                const name = document.createElement('div');
                name.className = 'search-name';
                name.textContent = fullName || 'Unnamed Faculty';

                const email = document.createElement('div');
                email.className = 'search-email';
                email.textContent = faculty.email ?? faculty.faculty_code ?? '';

                item.append(name, email);

                item.addEventListener('click', function (e) {
                    e.preventDefault();
                    fillFaculty(faculty);
                });

                resultsBox.appendChild(item);
            });

            showResults();
        }

        function filterFaculties(query) {
            const normalizedQuery = normalizeFacultySearchText(query);
            if (!normalizedQuery) return [];

            return faculties
                .map(faculty => ({
                    faculty,
                    score: scoreFacultyMatch(faculty, normalizedQuery),
                }))
                .filter(entry => entry.score >= 0)
                .sort((a, b) => b.score - a.score)
                .map(entry => entry.faculty);
        }

        function normalizeFacultySearchText(value) {
            return String(value ?? '')
                .toLowerCase()
                .replace(/[^a-z0-9@\s._-]/g, ' ')
                .replace(/\s+/g, ' ')
                .trim();
        }

        function buildFacultySearchTokens(value) {
            return normalizeFacultySearchText(value).split(' ').filter(Boolean);
        }

        function scoreFacultyValue(haystack, query, tokens) {
            const normalizedHaystack = normalizeFacultySearchText(haystack);
            if (!normalizedHaystack) return -1;
            if (normalizedHaystack === query) return 1000;
            if (normalizedHaystack.startsWith(query)) return 800;
            if (tokens.length && tokens.every(token => normalizedHaystack.includes(token))) {
                return 500 - normalizedHaystack.indexOf(tokens[0]);
            }
            if (normalizedHaystack.includes(query)) return 250 - normalizedHaystack.indexOf(query);
            return -1;
        }

        function scoreFacultyMatch(faculty, query) {
            const tokens = buildFacultySearchTokens(query);
            if (!tokens.length) return 0;

            const values = [
                `${faculty.first_name ?? ''} ${faculty.middle_name ?? ''} ${faculty.last_name ?? ''}`,
                faculty.email,
                faculty.faculty_code,
                faculty.department,
                faculty.faculty_id,
            ];

            let best = -1;

            values.forEach((value, index) => {
                const score = scoreFacultyValue(value, query, tokens);
                if (score >= 0) {
                    best = Math.max(best, score - index * 10);
                }
            });

            return best;
        }

        const facultyForm = document.getElementById('facultyIntegrationForm');
        const cmsRole = document.getElementById('cms_role');
        const accountStatus = document.getElementById('account_status');

        function getFacultyFieldErrorHost(field) {
            if (!field) return null;

            if (field.classList.contains('access-select')) {
                return field.closest('.custom-select') || field.closest('.field-group');
            }

            return field.closest('.field-group') || field.parentElement;
        }

        function setFacultyFieldError(field, message = '') {
            if (!field) return;

            const host = getFacultyFieldErrorHost(field);
            const fieldGroup = field.closest('.field-group');
            const customSelect = field.closest('.custom-select');

            field.classList.toggle('is-invalid', Boolean(message));
            host?.classList.toggle('is-invalid', Boolean(message));
            customSelect?.classList.toggle('is-invalid', Boolean(message));

            let errorEl = fieldGroup?.querySelector(`[data-error-for="${field.id}"]`);

            if (!errorEl && fieldGroup) {
                errorEl = document.createElement('div');
                errorEl.className = 'st-field-error faculty-field-error';
                errorEl.dataset.errorFor = field.id;
                fieldGroup.appendChild(errorEl);
            }

            if (errorEl) {
                errorEl.innerHTML = message ?
                    `<i class="fa-solid fa-circle-exclamation"></i><span>${message}</span>` :
                    '';
                errorEl.classList.toggle('hidden', !message);
            }
        }

        function validateFacultyIntegrationForm({
            showToastMessage = false
        } = {}) {
            let valid = true;

            if (!facultyJson.value.trim()) {
                setFacultyFieldError(searchInput, 'Please select a faculty record from the dropdown list.');
                valid = false;
            } else {
                setFacultyFieldError(searchInput, '');
            }

            if (!cmsRole.value) {
                setFacultyFieldError(cmsRole, 'Please select a CMS role.');
                valid = false;
            } else {
                setFacultyFieldError(cmsRole, '');
            }

            if (!accountStatus.value) {
                setFacultyFieldError(accountStatus, 'Please select an account status.');
                valid = false;
            } else {
                setFacultyFieldError(accountStatus, '');
            }

            if (!valid && showToastMessage) {
                window.showToast?.({
                    type: 'error',
                    title: 'Complete required fields',
                    message: 'Select a faculty record, CMS role, and account status before saving.',
                    duration: 6000,
                });

                const firstError = facultyForm.querySelector('.is-invalid');
                firstError?.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }

            return valid;
        }

        facultyForm?.addEventListener('submit', function (event) {
            if (!validateFacultyIntegrationForm({
                showToastMessage: true
            })) {
                event.preventDefault();
                event.stopPropagation();
            }
        });

        cmsRole?.addEventListener('change', () => {
            setFacultyFieldError(cmsRole, cmsRole.value ? '' : 'Please select a CMS role.');
        });

        accountStatus?.addEventListener('change', () => {
            setFacultyFieldError(accountStatus, accountStatus.value ? '' :
                'Please select an account status.');
        });

        fetch('/faculties', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(res => {
                if (!res.ok) throw new Error(`HTTP ${res.status}`);
                return res.json();
            })
            .then(data => {
                faculties = Array.isArray(data) ? data : [];
                facultyLoadError = '';
            })
            .catch(err => {
                console.error('Failed to load faculties:', err);
                faculties = [];
                facultyLoadError = 'Unable to load faculty records. Please check the FLSS API connection.';
            })
            .finally(() => {
                facultiesLoading = false;
            });

        searchInput.addEventListener('input', function () {
            const query = this.value.trim();

            toggleFacultySearchClear(this);
            clearFields();
            isDropdownMode = false;

            if (facultiesLoading) {
                renderNoResults('Loading faculty records...');
                return;
            }

            if (!query) {
                faculties.length
                    ? renderResults(faculties)
                    : renderNoResults('No faculty records available.');

                return;
            }

            const filtered = filterFaculties(query);

            filtered.length
                ? renderResults(filtered)
                : renderNoResults('No results found.');
        });

        searchInput.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') hideResults();
        });

        document.addEventListener('click', function (event) {
            const searchWrapper =
                searchInput.closest('[data-search-wrapper]');

            const clickedInside =
                searchWrapper?.contains(event.target) ||
                resultsBox.contains(event.target);

            if (!clickedInside) {
                hideResults();
            }
        });

        resetFacultyBtn?.addEventListener('click', function () {
            resetFacultyForm();

            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });

            window.setTimeout(() => {
                searchInput.focus({
                    preventScroll: true
                });
            }, 450);
        });

        toggleFacultySearchClear(searchInput);
        resetPreview();

        if (window.initSearchClearButtons) {
            window.initSearchClearButtons();
        }

        if (clearSearchButton) {
            clearSearchButton.addEventListener('click', function () {
                clearFields();
                hideResults();
                toggleFacultySearchClear(searchInput);
            });
        }

        if (window.initGlobalVoiceInputs) {
            window.initGlobalVoiceInputs(document);
        }
    });
</script>
@endsection
