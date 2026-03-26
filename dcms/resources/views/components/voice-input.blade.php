@props(['id', 'name' => '', 'placeholder' => '', 'value' => '', 'class' => '', 'type' => 'text', 'isTextarea' => false, 'rows' => 4, 'maxlength' => ''])

<div class="relative w-full">
    @if($isTextarea)
        <textarea id="{{ $id }}" name="{{ $name }}" placeholder="{{ $placeholder }}" rows="{{ $rows }}" maxlength="{{ $maxlength }}" class="{{ $class }} pr-10">{{ $value }}</textarea>
        <button type="button" onclick="startGlobalVoiceInput('{{ $id }}', this)" class="absolute right-3 top-3 text-gray-400 hover:text-[#8B0000] transition-colors">
            <i class="fas fa-microphone"></i>
        </button>
    @else
        <input type="{{ $type }}" id="{{ $id }}" name="{{ $name }}" placeholder="{{ $placeholder }}" value="{{ $value }}" maxlength="{{ $maxlength }}" class="{{ $class }} pr-10">
        <button type="button" onclick="startGlobalVoiceInput('{{ $id }}', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#8B0000] transition-colors">
            <i class="fas fa-microphone"></i>
        </button>
    @endif
    <span id="status-{{ $id }}" class="hidden absolute right-0 -top-6 text-xs font-semibold px-2 py-0.5 rounded pointer-events-none z-20"></span>
</div>