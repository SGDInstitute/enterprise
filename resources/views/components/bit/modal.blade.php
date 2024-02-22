@props([
    'id',
    'maxWidth',
])

@php
    $id = $id ?? md5($attributes->wire('model'));

    switch ($maxWidth ?? '2xl') {
        case 'sm':
            $maxWidth = 'sm:max-w-sm';
            break;
        case 'md':
            $maxWidth = 'sm:max-w-md';
            break;
        case 'lg':
            $maxWidth = 'sm:max-w-lg';
            break;
        case 'xl':
            $maxWidth = 'sm:max-w-xl';
            break;
        case '3xl':
            $maxWidth = 'sm:max-w-3xl';
            break;
        case '4xl':
            $maxWidth = 'sm:max-w-4xl';
            break;
        case '5xl':
            $maxWidth = 'sm:max-w-5xl';
            break;
        case '6xl':
            $maxWidth = 'sm:max-w-6xl';
            break;
        case '7xl':
            $maxWidth = 'sm:max-w-7xl';
            break;
        case '2xl':
        default:
            $maxWidth = 'sm:max-w-2xl';
            break;
    }
@endphp

<div
    x-data="{
        show: @entangle($attributes->wire('model')).live,
        focusables() {
            // All focusable element types...
            let selector = 'a, button, input, textarea, select, details, [tabindex]:not([tabindex=\'-1\'])'

            return [...$el.querySelectorAll(selector)]
                // All non-disabled elements...
                .filter(el => ! el.hasAttribute('disabled'))
        },
        firstFocusable() { return this.focusables()[0] },
        lastFocusable() { return this.focusables().slice(-1)[0] },
        nextFocusable() { return this.focusables()[this.nextFocusableIndex()] || this.firstFocusable() },
        prevFocusable() { return this.focusables()[this.prevFocusableIndex()] || this.lastFocusable() },
        nextFocusableIndex() { return (this.focusables().indexOf(document.activeElement) + 1) % (this.focusables().length + 1) },
        prevFocusableIndex() { return Math.max(0, this.focusables().indexOf(document.activeElement)) -1 },
        autofocus() { let focusable = $el.querySelector('[autofocus]'); if (focusable) focusable.focus() },
    }"
    x-init="$watch('show', (value) => value && setTimeout(autofocus, 50))"
    x-on:close.stop="show = false"
    x-on:keydown.escape.window="show = false"
    x-on:keydown.tab.prevent="$event.shiftKey || nextFocusable().focus()"
    x-on:keydown.shift.tab.prevent="prevFocusable().focus()"
    x-show="show"
    id="{{ $id }}"
    class="sm:items-top fixed inset-x-0 top-0 z-50 max-h-screen overflow-auto px-4 pb-6 pt-6 sm:flex sm:justify-center sm:px-0"
    style="display: none"
>
    <div
        x-show="show"
        class="fixed inset-0 transform transition-all"
        x-on:click="show = false"
        x-transition:enter="duration-300 ease-out"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="duration-200 ease-in"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>

    <div
        x-show="show"
        class="{{ $maxWidth }} max-h-screen transform overflow-scroll rounded-lg bg-white shadow-xl transition-all dark:bg-gray-800 sm:w-full"
        x-transition:enter="duration-300 ease-out"
        x-transition:enter-start="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="translate-y-0 opacity-100 sm:scale-100"
        x-transition:leave="duration-200 ease-in"
        x-transition:leave-start="translate-y-0 opacity-100 sm:scale-100"
        x-transition:leave-end="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
    >
        {{ $slot }}
    </div>
</div>
