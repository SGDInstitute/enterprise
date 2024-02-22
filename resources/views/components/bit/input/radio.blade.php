@props([
    'label' => null,
])

@if ($label)
    <div class="flex items-center">
        <input
            {{ $attributes }}
            type="radio"
            class="{{ $attributes->get('disabled') ? 'cursor-not-allowed opacity-75' : '' }} h-4 w-4 border-gray-300 bg-transparent text-green-600 focus:ring-green-600 dark:border-gray-700"
        />
        <label for="{{ $attributes['id'] }}" class="ml-3">
            <span
                class="{{ $attributes->get('disabled') ? 'cursor-not-allowed opacity-75' : '' }} block text-sm font-medium leading-5 text-gray-700 dark:text-gray-200"
            >
                {{ $label }}
            </span>
        </label>
    </div>
@else
    <div {{ $attributes->only('class') }}>
        <input
            {{ $attributes->except('class') }}
            type="radio"
            class="{{ $attributes->get('disabled') ? 'cursor-not-allowed opacity-75' : '' }} h-4 w-4 border-gray-300 bg-transparent text-green-600 focus:ring-green-600 dark:border-gray-700"
        />
    </div>
@endif
