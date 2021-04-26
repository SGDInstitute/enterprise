@props(['title', 'width'])

<div x-data="{ isOpen: false }" class="relative inline-block text-left">
    <div>
        <button type="button" @click="isOpen = !isOpen" class="inline-flex justify-center w-full font-medium leading-5 text-gray-700 transition duration-150 ease-in-out dark:text-gray-200 hover:text-blue-500 focus:outline-none dark:focus:text-blue-500 focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 dark:active:text-gray-100" id="options-menu" aria-haspopup="true" aria-expanded="true">
            {{ $title }}
        </button>
    </div>

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
