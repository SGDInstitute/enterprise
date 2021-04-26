@props([
    'label' => null,
    'help' => null,
])

@if($label)
<div class="relative flex items-start">
    <div class="flex items-center h-5">
        <input {{ $attributes }} type="checkbox" class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500 {{ $attributes->get('disabled') ? 'opacity-75 cursor-not-allowed' : '' }}">
    </div>
    <div class="ml-3 text-sm">
        <label for="{{ $attributes->get('id') }}" class="font-medium text-gray-700 dark:text-gray-200 {{ $attributes->get('disabled') ? 'opacity-75 cursor-not-allowed' : '' }}">{{ $label }}</label>
        @if($help)
        <p class="text-gray-500 dark:text-gray-400">{{ $help }}</p>
        @endif
    </div>
</div>
@else
<div class="flex">
    <input {{ $attributes }}
        type="checkbox"
        class="block transition duration-150 ease-in-out border-gray-300 form-checkbox sm:text-sm sm:leading-5 {{ $attributes->get('disabled') ? 'opacity-75 cursor-not-allowed' : '' }}"
    />
</div>
@endif
