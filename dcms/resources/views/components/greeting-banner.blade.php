<div class="greeting-row">
    <div class="greeting-banner w-full">
        <div class="greeting-banner-inner">
            <div class="greeting-banner-copy min-w-0">
                <h1 class="greeting-heading">
                    <span class="greeting-line">
                        <span id="greetingText"></span>
                    </span>
                    <span class="greeting-line greeting-name-line">
                        <span class="greeting-name-prefix">{{ $prefix ?? '' }}</span>
                        <span id="userName">{{ $name }}</span>
                        <i class="fa-solid fa-hand text-yellow-300 wave-hand"></i>
                    </span>
                </h1>
                <p>{{ $subtitle ?? 'Wishing you a healthy and happy day!' }}</p>
            </div>

            @if($showStatus ?? false)
            <div class="greeting-banner-actions">
                <div class="greeting-status-meta">
                    <div class="greeting-status-eyebrow">
                        <i class="fa-solid fa-circle-plus"></i>
                        Clinic Status
                    </div>
                    <div class="greeting-status-text">The Dentist is currently</div>
                </div>

                <div class="status-btn-wrap">
                    <div class="status-icon-badge">
                        <i class="fa-solid fa-stethoscope"></i>
                    </div>

                    <button id="statusBtn"
                        class="banner-status-btn font-bold text-white flex items-center gap-2"
                        style="background:#00A96E;">
                        <span id="statusLabel">
                            <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span> IN
                        </span>
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>