@props([
    'label' => null,
    'help' => null,
])

@if ($label)
    <div class="relative flex items-start">
        <div class="flex h-5 items-center">
            <input
                {{ $attributes }}
                type="checkbox"
                class="{{ $attributes->get('disabled') ? 'cursor-not-allowed opacity-75' : '' }} h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-500 dark:border-gray-500 dark:bg-gray-800"
            />
        </div>
        <div class="ml-3 text-sm">
            <label
                for="{{ $attributes->get('id') }}"
                class="{{ $attributes->get('disabled') ? 'cursor-not-allowed opacity-75' : '' }} font-medium text-gray-700 dark:text-gray-200"
            >
                {{ $label }}
            </label>
            @if ($help)
                <p class="text-gray-500 dark:text-gray-400">{{ $help }}</p>
            @endif
        </div>
    </div>
@else
    <div class="flex">
        <input
            {{ $attributes }}
            type="checkbox"
            class="{{ $attributes->get('disabled') ? 'cursor-not-allowed opacity-75' : '' }} form-checkbox block rounded border-gray-300 transition duration-150 ease-in-out dark:border-gray-500 dark:bg-gray-800 sm:text-sm sm:leading-5"
        />
    </div>
@endif
