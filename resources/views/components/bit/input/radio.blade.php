@props([
    'label' => null
])

@if($label)
<div class="flex items-center">
    <input {{ $attributes }} type="radio" class="w-4 h-4 text-green-600 transition duration-150 ease-in-out form-radio focus:ring-green-500 {{ $attributes->get('disabled') ? 'opacity-75 cursor-not-allowed' : '' }}">
    <label for="{{ $attributes['id'] }}" class="ml-3">
        <span class="block text-sm font-medium leading-5 text-gray-700 dark:text-gray-200 {{ $attributes->get('disabled') ? 'opacity-75 cursor-not-allowed' : '' }}">{{ $label }}</span>
    </label>
</div>
@else
<div {{ $attributes->only('class') }}>
    <input {{ $attributes->except('class') }}
        type="radio"
        class="block transition duration-150 ease-in-out text-green-600 border-gray-300 form-radio focus:ring-green-500 {{ $attributes->get('disabled') ? 'opacity-75 cursor-not-allowed' : '' }}"
    />
</div>
@endif
