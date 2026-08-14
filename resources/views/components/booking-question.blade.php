@props([
    'name',
    'label',
    'checkedValue' => '',
    'required' => true,
    'requiredMessage' => null,
    'yesValue' => 'YES',
    'noValue' => 'NO',
])

<div {{ $attributes->class(['global-question-row']) }} data-global-field>

    <span class="global-question-text">
        {{ $label }}
    </span>

    <div class="global-question-options global-choice-group" role="radiogroup" aria-label="{{ $label }}">

        <label class="global-radio-option">

            <input type="radio" name="{{ $name }}" value="{{ $yesValue }}" class="global-radio-input"
                @checked((string) $checkedValue === (string) $yesValue) @if ($required) required @endif
                @if ($requiredMessage) data-required-message="{{ $requiredMessage }}" @endif>

            <span>Yes</span>

        </label>

        <label class="global-radio-option">

            <input type="radio" name="{{ $name }}" value="{{ $noValue }}" class="global-radio-input"
                @checked((string) $checkedValue === (string) $noValue)>

            <span>No</span>

        </label>

    </div>

</div>
