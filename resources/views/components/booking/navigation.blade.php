@props([
    'showSubmit' => false,
    'submitLabel' => 'Submit',
    'submitIcon' => 'fa-solid fa-arrow-right',
])

<div id="navBtns" class="booking-navigation">

    <button type="button" id="prevBtn" class="ui-btn ui-btn-secondary">
        <i class="fa-solid fa-chevron-left"></i>
        Previous
    </button>

    <button type="button" id="nextBtn" class="ui-btn ui-btn-primary">
        Next
        <i class="fa-solid fa-chevron-right"></i>
    </button>

    @if ($showSubmit)
        <button type="submit" id="submitBtn" class="ui-btn ui-btn-primary hidden">
            {{ $submitLabel }}
            <i class="{{ $submitIcon }}"></i>
        </button>
    @endif

</div>
