<div
    class="mt-2 rounded-md shadow-sm"
    x-data="{
        value: @entangle($attributes->wire('model')).live,
        isFocused() {
            return document.activeElement !== this.$refs.trix
        },
        setValue() {
            this.$refs.trix.editor.loadHTML(this.value)
        },
    }"
    x-init="
        setValue()
        $watch('value', () => isFocused() && setValue())
    "
    x-on:trix-change="value = $event.target.value"
    {{ $attributes->whereDoesntStartWith('wire:model.live') }}
    wire:ignore
>
    <style>
        .trix-button-group--file-tools,
        .trix-button--icon-code {
            display: none !important;
        }
    </style>
    <input id="x" type="hidden" />

    <trix-editor
        x-ref="trix"
        input="x"
        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200"
    ></trix-editor>
</div>
