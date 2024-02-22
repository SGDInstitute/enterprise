@props([
    'label',
    'id',
    'name',
])

@isset($label)
    <div class="relative flex items-start">
        <div class="flex h-6 items-center">
            <input
                id="{{ $id }}"
                name="{{ $name ?? $id }}"
                {{ $attributes }}
                type="checkbox"
                class="h-5 w-5 rounded border-gray-300 text-green-600 focus:ring-green-500 dark:border-gray-700 dark:bg-gray-800"
            />
        </div>
        <div class="ml-2">
            <label for="{{ $id }}" class="font-medium text-gray-700 dark:text-gray-200">{{ $label }}</label>
        </div>
    </div>
@else
    <input
        id="{{ $id }}"
        {{ $attributes }}
        type="checkbox"
        class="h-5 w-5 rounded border-gray-300 text-green-600 focus:ring-green-500 dark:border-gray-700 dark:bg-gray-800"
    />
@endif
