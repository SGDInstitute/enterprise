@props([
    'leading' => false,
    'trailing' => false,
    'override' => false,
])

@php
    $inputClasses = 'dark:text-gray-200 dark:focus:bg-gray-800 bg-transparent focus:ring-green-500 focus:border-green-500 border-gray-300 dark:border-gray-700 disabled:cursor-not-allowed' . ($override ? '' : ' flex-1 block w-full min-w-0')
@endphp

@if ($leading && $trailing)
    <div class="mt-1 flex rounded-md shadow-sm">
        <span
            class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 bg-gray-50 px-3 text-gray-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400"
        >
            {{ $leading }}
        </span>
        <input {{ $attributes->merge(['type' => 'text', 'class' => $inputClasses]) }} />
        <span
            class="inline-flex items-center rounded-r-md border border-l-0 border-gray-300 bg-gray-50 px-3 text-gray-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400"
        >
            {{ $trailing }}
        </span>
    </div>
@elseif ($leading)
    <div class="mt-1 flex rounded-md shadow-sm">
        <span
            class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 bg-gray-50 px-3 text-gray-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400"
        >
            {{ $leading }}
        </span>
        <input {{ $attributes->merge(['type' => 'text', 'class' => $inputClasses . ' rounded-r-md']) }} />
    </div>
@elseif ($trailing)
    <div class="mt-1 flex rounded-md shadow-sm">
        <input {{ $attributes->merge(['type' => 'text', 'class' => $inputClasses . ' rounded-l-md']) }} />
        <span
            class="inline-flex items-center rounded-r-md border border-l-0 border-gray-300 bg-gray-50 px-3 text-gray-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400"
        >
            {{ $trailing }}
        </span>
    </div>
@else
    <input {{ $attributes->merge(['type' => 'text', 'class' => $inputClasses . ' rounded-md']) }} />
@endif
