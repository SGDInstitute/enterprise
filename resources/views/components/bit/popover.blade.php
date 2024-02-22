@props([
    'title',
    'width',
])

<div x-data="{ isOpen: false }" class="relative inline-block text-left">
    <x-bit.button.round.secondary size="sm" @click="isOpen = !isOpen">{{ $title }}</x-bit.button.round.secondary>

    <div
        x-cloak
        x-show="isOpen"
        @click.away="isOpen = false"
        x-transition:enter="transform transition duration-100 ease-out"
        x-transition:enter-start="scale-95 opacity-0"
        x-transition:enter-end="scale-100 opacity-100"
        x-transition:leave="transform transition duration-75 ease-in"
        x-transition:leave-start="scale-100 opacity-100"
        x-transition:leave-end="scale-95 opacity-0"
        class="{{ isset($width) ? $width : 'w-56' }} absolute right-0 z-50 mt-2 origin-top-right rounded-md shadow-lg"
    >
        <div class="shadow-xs dark:shadow-light-xs rounded-md bg-white dark:bg-gray-700">
            <div class="p-2" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
