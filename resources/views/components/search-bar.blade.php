@props([
    'id',
    'name' => null,
    'placeholder' => 'Search…',
    'type' => 'search',
    'value' => '',
    'clearLabel' => 'Clear search',
    'callback' => null,
    'debounce' => 300,
])

<div {{ $attributes->class(['search-wrap', 'global-search']) }} data-search-wrapper
    data-global-search-bar @if ($callback) data-search-callback="{{ $callback }}" @endif
    data-search-debounce="{{ (int) $debounce }}">
    <i class="
            fa-solid
            fa-magnifying-glass
            search-icon
        "
        aria-hidden="true"></i>

    <input id="{{ $id }}" @if ($name) name="{{ $name }}" @endif
        type="{{ $type }}" class="search-input" placeholder="{{ $placeholder }}" value="{{ $value }}"
        autocomplete="off" data-search-input>

    <button type="button" class="search-clear" data-search-clear aria-label="{{ $clearLabel }}"
        title="{{ $clearLabel }}">
        <i class="fa-solid fa-xmark" aria-hidden="true"></i>
    </button>
</div>
