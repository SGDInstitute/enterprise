{{--
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
<script src="https://unpkg.com/moment"></script>
<script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
--}}

<div x-data="{ value: @entangle($attributes->wire('model')), picker: undefined }"
    x-init="new Pikaday({ field: $refs.input, format: 'MM/DD/YYYY', onOpen() { this.setDate($refs.input.value) } })"
    x-on:change="value = $event.target.value"
    class="flex mt-1 rounded-md shadow-sm">
    <span class="inline-flex items-center px-3 text-sm text-gray-500 border border-r-0 border-gray-300 rounded-l-md bg-gray-50 dark:bg-gray-900 dark:text-gray-400 dark:border-gray-600">
        <x-heroicon-o-calendar class="w-4 h-4 text-gray-400" />
    </span>
    <input x-ref="input" x-bind:value="value" autocomplete="off" class="flex-1 block w-full border-gray-300 rounded-none dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 rounded-r-md sm:text-sm" {{ $attributes->whereDoesntStartWith('wire:model') }}>
</div>
