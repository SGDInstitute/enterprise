@props([
    'label' => null
])

@if ($label)
<div class="flex items-center">
    <input {{ $attributes }} type="radio" class="h-4 w-4 border-gray-300 bg-transparent dark:border-gray-700 text-green-600 focus:ring-green-600 {{ $attributes->get('disabled') ? 'opacity-75 cursor-not-allowed' : '' }}">
    <label for="{{ $attributes['id'] }}" class="ml-3">
        <span class="block text-sm font-medium leading-5 text-gray-700 dark:text-gray-200 {{ $attributes->get('disabled') ? 'opacity-75 cursor-not-allowed' : '' }}">{{ $label }}</span>
    </label>
</div>
@else
<div {{ $attributes->only('class') }}>
    <input {{ $attributes->except('class') }}
        type="radio"
        class="h-4 w-4 border-gray-300 bg-transparent dark:border-gray-700 text-green-600 focus:ring-green-600 {{ $attributes->get('disabled') ? 'opacity-75 cursor-not-allowed' : '' }}"
    />
</div>
@endif
