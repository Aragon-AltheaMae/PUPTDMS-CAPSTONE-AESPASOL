@if ($paginator->hasPages())
    @php
        $currentPage = $paginator->currentPage();
        $lastPage = $paginator->lastPage();
        $window = 5; // how many page buttons to show at once
        $half = (int) floor($window / 2);

        $start = max(1, $currentPage - $half);
        $end = min($lastPage, $start + $window - 1);

        // Clamp start if near the end
        if ($end - $start + 1 < $window) {
            $start = max(1, $end - $window + 1);
        }
    @endphp

    <nav style="display:flex;align-items:center;gap:.35rem;flex-wrap:nowrap;" aria-label="Pagination">

        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <button disabled
                style="height:32px;min-width:32px;padding:0 10px;border-radius:8px;border:1.5px solid #e5e7eb;background:#f9fafb;color:#d1d5db;font-size:.75rem;font-weight:600;cursor:not-allowed;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="fa-solid fa-chevron-left" style="font-size:.65rem;"></i>
            </button>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
                style="height:32px;min-width:32px;padding:0 10px;border-radius:8px;border:1.5px solid #e5e7eb;background:#fff;color:#374151;font-size:.75rem;font-weight:600;cursor:pointer;display:flex;align-items:center;justify-content:center;text-decoration:none;transition:all .15s;flex-shrink:0;"
                onmouseover="this.style.borderColor='#8B0000';this.style.color='#8B0000';this.style.background='#fef2f2';"
                onmouseout="this.style.borderColor='#e5e7eb';this.style.color='#374151';this.style.background='#fff';">
                <i class="fa-solid fa-chevron-left" style="font-size:.65rem;"></i>
            </a>
        @endif

        {{-- First page + ellipsis if window doesn't start at 1 --}}
        @if ($start > 1)
            <a href="{{ $paginator->url(1) }}"
                style="height:32px;min-width:32px;padding:0 10px;border-radius:8px;border:1.5px solid #e5e7eb;background:#fff;color:#374151;font-size:.75rem;font-weight:600;display:flex;align-items:center;justify-content:center;text-decoration:none;transition:all .15s;flex-shrink:0;"
                onmouseover="this.style.borderColor='#8B0000';this.style.color='#8B0000';this.style.background='#fef2f2';"
                onmouseout="this.style.borderColor='#e5e7eb';this.style.color='#374151';this.style.background='#fff';">
                1
            </a>
            @if ($start > 2)
                <span
                    style="height:32px;min-width:32px;display:flex;align-items:center;justify-content:center;color:#9ca3af;font-size:.75rem;font-weight:600;flex-shrink:0;">…</span>
            @endif
        @endif

        {{-- Windowed page numbers --}}
        @for ($page = $start; $page <= $end; $page++)
            @if ($page == $currentPage)
                <span
                    style="height:32px;min-width:32px;padding:0 10px;border-radius:8px;border:1.5px solid #8B0000;background:linear-gradient(135deg,#8B0000,#6b0000);color:#fff;font-size:.75rem;font-weight:700;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 8px rgba(139,0,0,.25);flex-shrink:0;">
                    {{ $page }}
                </span>
            @else
                <a href="{{ $paginator->url($page) }}"
                    style="height:32px;min-width:32px;padding:0 10px;border-radius:8px;border:1.5px solid #e5e7eb;background:#fff;color:#374151;font-size:.75rem;font-weight:600;display:flex;align-items:center;justify-content:center;text-decoration:none;transition:all .15s;flex-shrink:0;"
                    onmouseover="this.style.borderColor='#8B0000';this.style.color='#8B0000';this.style.background='#fef2f2';"
                    onmouseout="this.style.borderColor='#e5e7eb';this.style.color='#374151';this.style.background='#fff';">
                    {{ $page }}
                </a>
            @endif
        @endfor

        {{-- Ellipsis + last page if window doesn't reach the end --}}
        @if ($end < $lastPage)
            @if ($end < $lastPage - 1)
                <span
                    style="height:32px;min-width:32px;display:flex;align-items:center;justify-content:center;color:#9ca3af;font-size:.75rem;font-weight:600;flex-shrink:0;">…</span>
            @endif
            <a href="{{ $paginator->url($lastPage) }}"
                style="height:32px;min-width:32px;padding:0 10px;border-radius:8px;border:1.5px solid #e5e7eb;background:#fff;color:#374151;font-size:.75rem;font-weight:600;display:flex;align-items:center;justify-content:center;text-decoration:none;transition:all .15s;flex-shrink:0;"
                onmouseover="this.style.borderColor='#8B0000';this.style.color='#8B0000';this.style.background='#fef2f2';"
                onmouseout="this.style.borderColor='#e5e7eb';this.style.color='#374151';this.style.background='#fff';">
                {{ $lastPage }}
            </a>
        @endif

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
                style="height:32px;min-width:32px;padding:0 10px;border-radius:8px;border:1.5px solid #e5e7eb;background:#fff;color:#374151;font-size:.75rem;font-weight:600;cursor:pointer;display:flex;align-items:center;justify-content:center;text-decoration:none;transition:all .15s;flex-shrink:0;"
                onmouseover="this.style.borderColor='#8B0000';this.style.color='#8B0000';this.style.background='#fef2f2';"
                onmouseout="this.style.borderColor='#e5e7eb';this.style.color='#374151';this.style.background='#fff';">
                <i class="fa-solid fa-chevron-right" style="font-size:.65rem;"></i>
            </a>
        @else
            <button disabled
                style="height:32px;min-width:32px;padding:0 10px;border-radius:8px;border:1.5px solid #e5e7eb;background:#f9fafb;color:#d1d5db;font-size:.75rem;font-weight:600;cursor:not-allowed;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="fa-solid fa-chevron-right" style="font-size:.65rem;"></i>
            </button>
        @endif

    </nav>
@endif
