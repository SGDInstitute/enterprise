@props([
    'label' => null
])

@if($label)
<div class="flex items-center">
    <input {{ $attributes }} type="radio" class="w-4 h-4 text-blue-600 transition duration-150 ease-in-out form-radio {{ $attributes->get('disabled') ? 'opacity-75 cursor-not-allowed' : '' }}">
    <label for="{{ $attributes['id'] }}" class="ml-3">
        <span class="block text-sm font-medium leading-5 text-gray-700 dark:text-gray-200 {{ $attributes->get('disabled') ? 'opacity-75 cursor-not-allowed' : '' }}">{{ $label }}</span>
    </label>
</div>
@else
<div class="flex">
    <input {{ $attributes }}
        type="radio"
        class="block transition duration-150 ease-in-out border-gray-300 form-checkbox sm:text-sm sm:leading-5 {{ $attributes->get('disabled') ? 'opacity-75 cursor-not-allowed' : '' }}"
    />
</div>
@endif
