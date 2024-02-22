<div
    class="relative z-10 flex h-16 flex-shrink-0 border-b border-gray-200 bg-white shadow dark:border-gray-700 dark:bg-gray-850"
>
    <button
        @click.stop="sidebarOpen = true"
        class="border-r border-gray-200 px-4 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-green-500 dark:border-gray-700 md:hidden"
    >
        <span class="sr-only">Open sidebar</span>
        <svg
            class="h-6 w-6"
            x-description="Heroicon name: menu-alt-2"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            aria-hidden="true"
        >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
        </svg>
    </button>
    <div class="flex flex-1 justify-between px-4">
        <div class="flex flex-1">
            <form class="flex w-full md:ml-0" action="#" method="GET">
                <label for="search_field" class="sr-only">Search</label>
                <div class="relative w-full text-gray-400 focus-within:text-gray-600 dark:focus-within:text-gray-300">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center">
                        <x-heroicon-s-magnifying-glass class="h-5 w-5" x-description="Heroicon name: search" />
                    </div>
                    <input
                        id="search_field"
                        class="block h-full w-full border-transparent bg-transparent py-2 pl-8 pr-3 text-gray-900 placeholder-gray-500 focus:border-transparent focus:placeholder-gray-400 focus:outline-none focus:ring-0 dark:text-gray-200 dark:placeholder-gray-400 sm:text-sm"
                        placeholder="Search"
                        type="search"
                        name="search"
                    />
                </div>
            </form>
        </div>
        <div class="ml-4 flex items-center md:ml-6">
            <!-- Profile dropdown -->
            <x-auth.user-settings />
        </div>
    </div>
</div>
