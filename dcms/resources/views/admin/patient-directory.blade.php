<style>
    .patient-search-wrap {
        position: relative;
        display: flex;
        align-items: center;
        gap: 10px;
        width: 100%;
        max-width: 420px;
        margin-bottom: 18px;
        background: #fff;
        border: 1.5px solid #ede8e2;
        border-radius: 10px;
        padding: 0 12px;
        min-height: 42px;
        overflow: visible;
    }

    .patient-search-wrap:focus-within {
        border-color: #8B0000;
        box-shadow: 0 0 0 3px rgba(139, 0, 0, .1);
    }

    .patient-search-wrap .search-icon {
        color: #b5a99a;
        font-size: 13px;
        flex-shrink: 0;
    }

    .patient-search-wrap input {
        width: 100%;
        border: none;
        background: none;
        outline: none;
        color: #2d2420;
        font-size: 14px;
        padding: 0;
    }

    .patient-search-wrap input.has-voice-padding {
        padding-right: 1.8rem;
    }

    .patient-search-wrap [data-voice-trigger],
    .patient-search-wrap .voice-search-mic {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        width: 18px;
        height: 18px;
        border: none;
        background: transparent;
        padding: 0;
        margin: 0;
        line-height: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #8B0000;
        cursor: pointer;
        z-index: 4;
    }

    .patient-search-wrap [data-voice-status] {
        position: absolute;
        right: 0;
        top: calc(100% + 6px);
        display: inline-flex;
        align-items: center;
        white-space: nowrap;
        font-size: .74rem;
        font-weight: 700;
        line-height: 1;
        padding: .18rem .48rem;
        border-radius: 999px;
        pointer-events: none;
        z-index: 6;
        background: rgba(255, 255, 255, .92);
        border: 1px solid #e5e7eb;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .06);
    }

    .patient-search-wrap [data-voice-status].hidden {
        display: none;
    }

    .patient-search-wrap [data-voice-status].is-listening {
        color: #1d4ed8;
        border-color: #bfdbfe;
        background: #eff6ff;
    }

    .patient-search-wrap [data-voice-status].is-error {
        color: #b91c1c;
        border-color: #fecaca;
        background: #fef2f2;
    }

    .patient-search-wrap [data-voice-status].is-success {
        color: #166534;
        border-color: #bbf7d0;
        background: #f0fdf4;
    }
</style>

<div class="max-w-7xl mt-4 mx-auto fade-in">

    <!-- PAGE HEADER -->
    <div style="display:flex; align-items:flex-end; justify-content:space-between; margin-bottom:28px; gap:12px; flex-wrap:wrap;">
        <div>
            <div style="
                font-size:11px;
                color:#B5A99A;
                letter-spacing:2px;
                text-transform:uppercase;
                margin-bottom:6px;
                font-weight:600;
            ">
                Clinic Management
            </div>

            <h1 style="
                margin:0;
                font-size:30px;
                font-weight:800;
                color:#7B0D0D;
                line-height:1;
            ">
                Patient Directory
            </h1>

            <p style="
                margin:8px 0 0;
                font-size:14px;
                color:#8A7A6F;
            ">
                View patient dashboards and records as Super Admin.
            </p>
        </div>
    </div>

    <!-- SEARCH BAR -->
    <div class="search-wrap patient-search-wrap">
        <i class="fa-solid fa-magnifying-glass search-icon"></i>
        <input
            type="text"
            id="patientSearch"
            placeholder="Search patient name..."
            oninput="filterPatients()"
            style="font-family:'Inter', sans-serif;"
        >
    </div>

    <!-- DIRECTORY CARD -->
    <div style="
        background:#fff;
        border:1.5px solid #EDE8E2;
        border-radius:14px;
        overflow:hidden;
        box-shadow:0 1px 4px rgba(0,0,0,0.04);
    ">

        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr style="
                        background:#FDFCFB;
                        color:#7B0D0D;
                        font-weight:700;
                    ">
                        <th>ID</th>
                        <th>Patient Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody id="patientTableBody">
                    @foreach($patients as $patient)
                    <tr
                        class="hover patient-row"
                        style="border-bottom:1px solid #F5F0EB;"
                        data-name="{{ strtolower($patient->name) }}"
                        data-email="{{ strtolower($patient->email) }}"
                    >
                        <td style="font-weight:600;">
                            {{ $patient->id }}
                        </td>

                        <td style="font-weight:600; color:#2D2420;">
                            {{ $patient->name }}
                        </td>

                        <td style="color:#8A7A6F;">
                            {{ $patient->email }}
                        </td>

                        <td style="color:#8A7A6F;">
                            {{ $patient->phone ?? '—' }}
                        </td>

                        <td class="text-center">
                            <div style="display:flex; justify-content:center; gap:8px;">

                                <button
                                    onclick="window.location.href='/patient/dashboard'"
                                    style="
                                        background:linear-gradient(135deg,#1D4ED8,#3B82F6);
                                        color:#fff;
                                        border:none;
                                        border-radius:10px;
                                        padding:8px 16px;
                                        font-size:13px;
                                        font-weight:700;
                                        cursor:pointer;
                                        display:flex;
                                        align-items:center;
                                        gap:6px;
                                        box-shadow:0 3px 10px rgba(29,78,216,.25);
                                    "
                                >
                                    <i class="fa-solid fa-eye"></i>
                                    View Dashboard
                                </button>

                                <button
                                    onclick="window.location.href='/patient/record'"
                                    style="
                                        background:linear-gradient(135deg,#7B0D0D,#9B1515);
                                        color:#fff;
                                        border:none;
                                        border-radius:10px;
                                        padding:8px 16px;
                                        font-size:13px;
                                        font-weight:700;
                                        cursor:pointer;
                                        display:flex;
                                        align-items:center;
                                        gap:6px;
                                        box-shadow:0 3px 10px rgba(123,13,13,.25);
                                    "
                                >
                                    <i class="fa-solid fa-file-medical"></i>
                                    View Record
                                </button>

                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- NO RESULTS MESSAGE -->
            <div
                id="noPatientResults"
                style="
                    display:none;
                    text-align:center;
                    padding:32px 20px;
                    color:#8A7A6F;
                    border-top:1px solid #F5F0EB;
                "
            >
                <div style="font-size:16px; font-weight:700; color:#7B0D0D; margin-bottom:6px;">
                    No results for "<span id="searchQueryText"></span>"
                </div>
                <div style="font-size:14px;">
                    Try a different patient name.
                </div>
            </div>

        </div>
    </div>
</div>

<script>
function filterPatients() {
    const input = document.getElementById('patientSearch');
    const query = input.value.trim().toLowerCase();
    const rows = document.querySelectorAll('.patient-row');
    const noResults = document.getElementById('noPatientResults');
    const searchQueryText = document.getElementById('searchQueryText');

    let visibleCount = 0;

    rows.forEach(row => {
        const name = row.dataset.name || '';
        const email = row.dataset.email || '';
        const match = name.includes(query) || email.includes(query);

        row.style.display = match ? '' : 'none';

        if (match) {
            visibleCount++;
        }
    });

    if (query !== '' && visibleCount === 0) {
        noResults.style.display = 'block';
        searchQueryText.textContent = input.value;
    } else {
        noResults.style.display = 'none';
        searchQueryText.textContent = '';
    }
}
</script>