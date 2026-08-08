@props([
    'target',
    'statusId' => null,
    'label' => 'Use voice input',
    'title' => 'Voice input',
    'lang' => 'en-US',
    'class' => '',
])

@php
    $resolvedStatusId = $statusId ?: 'voice-status-' . \Illuminate\Support\Str::slug(ltrim($target, '#'));
@endphp

<div {{ $attributes->class(['voice-input-toggle', $class]) }} data-voice-field>
    <span id="{{ $resolvedStatusId }}" class="voice-status hidden" data-voice-status aria-live="polite"></span>

    <button type="button" class="voice-search-mic external" data-global-voice-trigger
        data-voice-target="{{ $target }}" data-voice-status="#{{ $resolvedStatusId }}"
        data-voice-lang="{{ $lang }}" aria-label="{{ $label }}" title="{{ $title }}"
        aria-pressed="false">
        <i class="fa-solid fa-microphone" aria-hidden="true"></i>
    </button>
</div>
