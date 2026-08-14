@props([
    'id',
    'infoId',
    'paginationId',
    'position' => 'bottom',
    'showEntries' => false,
    'pageSizeId' => null,
    'pageSizeCallback' => null,
    'pageSizeValue' => 10,
    'pageSizeLabel' => 'entries',
    'label' => 'entries',
])

<div id="{{ $id }}"
    {{ $attributes->class([
        'global-pagebar',
        'global-pagebar-top' => $position === 'top',
        'global-pagebar-bottom' => $position === 'bottom',
    ]) }}>
    <div class="global-pagebar-left">

        <span id="{{ $infoId }}" class="global-pagebar-info">
            Showing 0 {{ $label }}
        </span>

        @if ($showEntries && $pageSizeId && $pageSizeCallback)
            <div class="global-page-size-control">
                <label for="{{ $pageSizeId }}">
                    Show
                </label>

                <div class="global-page-size-select" data-global-page-size data-page-size-input="#{{ $pageSizeId }}"
                    data-page-size-callback="{{ $pageSizeCallback }}">
                    <select id="{{ $pageSizeId }}" class="global-page-size-native" tabindex="-1" aria-hidden="true">
                        @foreach ([10, 20, 50, 100] as $size)
                            <option value="{{ $size }}" @selected((int) $pageSizeValue === $size)>
                                {{ $size }}
                            </option>
                        @endforeach
                    </select>

                    <button type="button" class=" global-page-size-trigger" data-page-size-trigger
                        aria-haspopup="listbox" aria-expanded="false">
                        <span data-page-size-value>
                            {{ (int) $pageSizeValue }}
                        </span>
                        <i class=" fa-solid fa-chevron-down "></i>
                    </button>

                    <div class=" global-page-size-menu " role="listbox">
                        @foreach ([10, 20, 50, 100] as $size)
                            <button type="button"
                                class="global-page-size-option {{ (int) $pageSizeValue === $size ? 'is-selected' : '' }}"
                                data-page-size-option data-value="{{ $size }}" role="option"
                                aria-selected="{{ (int) $pageSizeValue === $size ? 'true' : 'false' }}">
                                <span>
                                    {{ $size }}
                                </span>

                                <i class="fa-solid fa-check"></i>
                            </button>
                        @endforeach
                    </div>
                </div>
                <span>entries</span>
            </div>
        @endif

    </div>

    <div class="global-pagination-wrap">
        <div id="{{ $paginationId }}" class="global-pagination" aria-label="Pagination"></div>
    </div>
</div>
