@props([
    'label' => null,
    'help' => null,
])

@if($label)
<div class="flex items-center">
    <input {{ $attributes }} type="checkbox" class="w-4 h-4 transition duration-150 ease-in-out text-blue-gray-400 form-checkbox {{ $attributes->get('disabled') ? 'opacity-75 cursor-not-allowed' : '' }}">
    <label for="{{ $attributes['id'] }}" class="block ml-3">
        <span class="text-sm font-medium leading-5 text-gray-700 dark:text-gray-200 {{ $attributes->get('disabled') ? 'opacity-75 cursor-not-allowed' : '' }}">{{ $label }}</span>
        @if($help)
        <span class="text-xs text-gray-500">{{ $help }}</span>
        @endif
    </label>
</div>
@else
<div class="flex">
    <input {{ $attributes }}
        type="checkbox"
        class="block transition duration-150 ease-in-out border-gray-300 form-checkbox sm:text-sm sm:leading-5 {{ $attributes->get('disabled') ? 'opacity-75 cursor-not-allowed' : '' }}"
    />
</div>
@endif
