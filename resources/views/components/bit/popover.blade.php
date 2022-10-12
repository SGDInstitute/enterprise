@props(['title', 'width'])

<div x-data="{ isOpen: false }" class="relative inline-block text-left">
    <x-bit.button.round.secondary size="sm" @click="isOpen = !isOpen">{{ $title }}</x-bit.button.round.secondary>

    <div
        x-cloak
        x-show="isOpen"
        @click.away="isOpen = false"
        x-transition:enter="transition ease-out duration-100 transform"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75 transform"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 z-50 {{ isset($width) ? $width : 'w-56' }} mt-2 origin-top-right rounded-md shadow-lg"
    >
        <div class="bg-white rounded-md shadow-xs dark:shadow-light-xs dark:bg-gray-700">
            <div class="p-2" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
