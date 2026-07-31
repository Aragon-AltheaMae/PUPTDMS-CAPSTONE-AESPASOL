<div class="page-banner dt-hero">
    <div class="page-banner-inner">
        <div class="dt-hero-copy">
            @if (!empty($kicker))
            <p class="dt-kicker">{{ $kicker }}</p>
            @endif
            <h1 class="page-title">{{ $title }}</h1>
            @if (!empty($subtitle))
            <p class="dt-subtitle">{{ $subtitle }}</p>
            @endif
        </div>

        @if (!empty($actions))
        <div class="dt-btn-row">
            {!! $actions !!}
        </div>
        @endif
    </div>
</div>
