@props(['group' => false, 'grow' => false])

<div
    x-data="{ value: @entangle($attributes->wire('model')), picker: undefined }"
    x-init="new Pikaday({ field: $refs.input, format: 'MM/DD/YYYY', onOpen() { this.setDate($refs.input.value) } })"
    x-on:change="value = $event.target.value"
    class="flex rounded-md shadow-sm {{ $group ? 'rounded-r-none' : '' }} {{ $grow ? 'flex-grow' : '' }}"
>
    <span class="inline-flex items-center px-3 text-gray-500 bg-gray-100 border border-r-0 border-gray-300 dark:bg-gray-600 dark:border-gray-400 rounded-l-md sm:text-sm">
        <svg class="w-5 h-5 text-gray-400 dark:text-gray-300" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M6 2C5.44772 2 5 2.44772 5 3V4H4C2.89543 4 2 4.89543 2 6V16C2 17.1046 2.89543 18 4 18H16C17.1046 18 18 17.1046 18 16V6C18 4.89543 17.1046 4 16 4H15V3C15 2.44772 14.5523 2 14 2C13.4477 2 13 2.44772 13 3V4H7V3C7 2.44772 6.55228 2 6 2ZM6 7C5.44772 7 5 7.44772 5 8C5 8.55228 5.44772 9 6 9H14C14.5523 9 15 8.55228 15 8C15 7.44772 14.5523 7 14 7H6Z"/>
        </svg>
    </span>

    <input
        {{ $attributes->whereDoesntStartWith('wire:model') }}
        x-ref="input"
        x-bind:value="value"
        autocomplete="off"
        class="flex-1 block w-full transition duration-150 ease-in-out rounded-none {{ $group ? '' : 'rounded-r-md' }} form-input dark:bg-gray-500 dark:border-gray-400 dark:text-gray-200 sm:text-sm sm:leading-5"
    />
</div>

@push('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
@endpush

@push('scripts')
<script src="https://unpkg.com/moment"></script>
<script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
@endpush
