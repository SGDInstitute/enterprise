@props([
    'placeholder' => null,
    'trailingAddOn' => null,
    'clearable' => false,
])

<div x-data
    x-init="new Choices($refs.input)"
    wire:ignore
    class="form-choicejs">
    <select x-ref="input"
        {{ $attributes->merge(['class' => 'form-select dark:bg-gray-500 dark:border-gray-400 dark:text-gray-200 block w-full pl-3 pr-10 py-2 text-base leading-6 border-gray-300 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5' . ($trailingAddOn ? ' rounded-r-none' : '')]) }}
    >
        @if ($placeholder)
            <option {{ $clearable ? '' : 'disabled' }} value="">{{ $placeholder }}</option>
        @endif

        {{ $slot }}
    </select>

    @if ($trailingAddOn)
        {{ $trailingAddOn }}
    @endif
</div>
