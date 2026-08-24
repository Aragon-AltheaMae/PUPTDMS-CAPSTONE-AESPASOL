@props([
    'label' => 'items',
])

<div class="global-show-more-controls" data-show-more-controls>
    <button type="button" class="ui-btn ui-btn-secondary global-show-more-btn hidden" data-show-more-button
        data-show-more-label="{{ $label }}" data-mode="more">
        <span data-show-more-text>
            Show more
        </span>

        <i class="fa-solid fa-chevron-down"></i>
    </button>
</div>
