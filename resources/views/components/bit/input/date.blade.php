<div wire:ignore class="mt-1 flex rounded-md shadow-sm">
    <span
        class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 bg-gray-50 px-3 text-sm text-gray-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-400"
    >
        <x-heroicon-o-calendar class="h-4 w-4 text-gray-400" />
    </span>
    <input
        x-data="{ value: @entangle($attributes->wire('model')).live, instance: undefined }"
        x-init="
            () => {
                instance = flatpickr($refs.input, {
                    dateFormat: 'm/d/Y',
                    allowInput: true,
                    onChange: function (selectedDates, dateStr, instance) {
                        value = dateStr
                    },
                })
            }
        "
        x-ref="input"
        x-bind:value="value"
        autocomplete="off"
        class="block w-full flex-1 rounded-none rounded-r-md border-gray-300 focus:border-green-500 focus:ring-green-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 sm:text-sm"
        {{ $attributes->whereDoesntStartWith('wire:model.live') }}
    />
</div>
