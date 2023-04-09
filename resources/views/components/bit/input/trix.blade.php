<div
    class="mt-2 rounded-md shadow-sm"
    x-data="{
        value: @entangle($attributes->wire('model')),
        isFocused() { return document.activeElement !== this.$refs.trix },
        setValue() { this.$refs.trix.editor.loadHTML(this.value) },
    }"
    x-init="setValue(); $watch('value', () => isFocused() && setValue())"
    x-on:trix-change="value = $event.target.value"
    {{ $attributes->whereDoesntStartWith('wire:model') }}
    wire:ignore
>
    <style>
        .trix-button-group--file-tools, .trix-button--icon-code { display: none !important; }
    </style>
    <input id="x" type="hidden">

    <trix-editor x-ref="trix" input="x" class="block w-full border-gray-300 rounded-md shadow-sm dark:text-gray-200 dark:bg-gray-800 dark:border-gray-600 focus:ring-green-500 focus:border-green-500"></trix-editor>

</div>