<div class="vo-card">
    <div class="vo-head">
        <div>
            <p class="vo-label">Odontogram</p>
            <p class="vo-sub">Click any tooth to view details</p>
        </div>
    </div>

    <div class="vo-board-wrap">
        <div id="viewOdontogramBoard" class="vo-board"></div>
    </div>
</div>

<div id="viewToothModal" class="vo-tooth-modal hidden">
    <div class="vo-tooth-backdrop" onclick="closeViewToothModal()"></div>

    <div class="vo-tooth-card">
        <div class="vo-tooth-hero">
            <button type="button" onclick="closeViewToothModal()" class="vo-tooth-close">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <h3 id="voToothTitle">Tooth #18</h3>
            <p id="voToothSubtitle">Upper Right · 3rd Molar</p>
        </div>

        <div class="vo-tooth-body">
            <div class="vo-tooth-main">
                <div id="voToothVisual" class="vo-tooth-visual"></div>
                <div>
                    <p class="vo-info-label">Condition</p>
                    <div id="voToothCondition" class="vo-condition-pill">Healthy</div>
                    <div id="voTreatedBadge" class="vo-treated-badge hidden">
                        <i class="fa-solid fa-star"></i>
                        Treated in this visit
                    </div>
                </div>
            </div>

            <p id="voToothName" class="vo-tooth-name">#18 — 3rd Molar</p>

            <div class="vo-info-grid">
                <div class="vo-info-box"><p>FDI Number</p><strong id="voFdi">#18</strong></div>
                <div class="vo-info-box"><p>Quadrant</p><strong id="voQuadrant">Upper Right</strong></div>
                <div class="vo-info-box"><p>Tooth Type</p><strong id="voToothType">3rd Molar</strong></div>
                <div class="vo-info-box"><p>Arch</p><strong id="voArch">Maxillary (Upper)</strong></div>
            </div>

            <div class="vo-history">
                <p class="vo-info-label">Treatment History</p>
                <div id="voTreatmentHistory"></div>
            </div>
        </div>
    </div>
</div>