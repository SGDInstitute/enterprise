<div class="w-full">
    <label for="search" class="sr-only">Search</label>
    <div class="relative" x-data="search" @keydown.window="handleKeydown">
        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
            </svg>
        </div>
        <x-bit.input.text x-ref="searchInput" class="pl-10 w-full" id="search" wire:model="search" placeholder="Search" type="search" />
        <div class="hidden absolute inset-y-0 right-0 py-1.5 pr-1.5 lg:flex">
            <kbd class="inline-flex items-center rounded border border-gray-200 dark:border-gray-800 px-2 font-sans text-sm font-medium text-gray-400">⌘K</kbd>
        </div>
    </div>
</div>
