@if ($paginator->hasPages())
    @php
        $currentPage = $paginator->currentPage();
        $lastPage = $paginator->lastPage();

        $window = 5;
        $half = (int) floor($window / 2);

        $start = max(1, $currentPage - $half);
        $end = min($lastPage, $start + $window - 1);

        if ($end - $start + 1 < $window) {
            $start = max(1, $end - $window + 1);
        }
    @endphp

    <nav class="global-pagination" aria-label="Pagination">

        @if ($paginator->onFirstPage())
            <button
                type="button"
                class="global-page-disabled"
                aria-label="Previous page"
                disabled>
                <i class="fa-solid fa-chevron-left global-page-icon"></i>
            </button>
        @else
            <a
                href="{{ $paginator->previousPageUrl() }}"
                class="global-page-btn"
                aria-label="Previous page">
                <i class="fa-solid fa-chevron-left global-page-icon"></i>
            </a>
        @endif

        @if ($start > 1)
            <a
                href="{{ $paginator->url(1) }}"
                class="global-page-btn">
                1
            </a>

            @if ($start > 2)
                <span
                    class="global-page-ellipsis"
                    aria-hidden="true">
                    &hellip;
                </span>
            @endif
        @endif

        @for ($page = $start; $page <= $end; $page++)
            @if ($page === $currentPage)
                <span
                    class="global-page-current"
                    aria-current="page">
                    {{ $page }}
                </span>
            @else
                <a
                    href="{{ $paginator->url($page) }}"
                    class="global-page-btn">
                    {{ $page }}
                </a>
            @endif
        @endfor

        @if ($end < $lastPage)
            @if ($end < $lastPage - 1)
                <span
                    class="global-page-ellipsis"
                    aria-hidden="true">
                    &hellip;
                </span>
            @endif

            <a
                href="{{ $paginator->url($lastPage) }}"
                class="global-page-btn">
                {{ $lastPage }}
            </a>
        @endif

        @if ($paginator->hasMorePages())
            <a
                href="{{ $paginator->nextPageUrl() }}"
                class="global-page-btn"
                aria-label="Next page">
                <i class="fa-solid fa-chevron-right global-page-icon"></i>
            </a>
        @else
            <button
                type="button"
                class="global-page-disabled"
                aria-label="Next page"
                disabled>
                <i class="fa-solid fa-chevron-right global-page-icon"></i>
            </button>
        @endif

    </nav>
@endif