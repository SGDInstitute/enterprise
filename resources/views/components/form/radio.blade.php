@props([
    'label',
    'id',
    'name',
])

@php
    $uniqueId = strtolower(str_replace(['.', ' '], '-', $id . '-' . $attributes->get('value')));
@endphp

@isset($label)
    <div class="flex items-center">
        <input
            id="{{ $uniqueId }}"
            name="{{ $name }}"
            {{ $attributes }}
            type="radio"
            class="h-4 w-4 border-gray-300 text-green-600 focus:ring-green-500 dark:border-gray-700 dark:bg-gray-800"
        />
        <label for="{{ $uniqueId }}" class="ml-3 font-medium text-gray-700 dark:text-gray-200">{{ $label }}</label>
    </div>
@else
    <input
        id="{{ $uniqueId }}"
        {{ $attributes->except('id') }}
        type="radio"
        class="h-4 w-4 border-gray-300 text-green-600 focus:ring-green-500 dark:border-gray-700 dark:bg-gray-800"
    />
@endif
