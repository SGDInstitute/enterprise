<div wire:ignore
    class="flex mt-1 rounded-md shadow-sm">
    <span class="inline-flex items-center px-3 text-sm text-gray-500 border border-r-0 border-gray-300 rounded-l-md bg-gray-50 dark:bg-gray-900 dark:text-gray-400 dark:border-gray-600">
        <x-heroicon-o-calendar class="w-4 h-4 text-gray-400" />
    </span>
    <input x-data="{ value: @entangle($attributes->wire('model')), instance: undefined }"
        x-init="() => {
            instance = flatpickr($refs.input, {enableTime: true, dateFormat:'m/d/Y G:i K', allowInput: true, onChange: function(selectedDates, dateStr, instance) {
                value = dateStr;
            }});
        }"
        x-ref="input"
        x-bind:value="value"
        autocomplete="off"
        class="flex-1 block w-full border-gray-300 rounded-none dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 rounded-r-md sm:text-sm"
        {{ $attributes->whereDoesntStartWith('wire:model') }}
    />
</div>
