<div class="relative z-10 flex flex-shrink-0 h-16 bg-white border-b border-gray-200 shadow dark:bg-gray-850 dark:border-gray-700">
    <button @click.stop="sidebarOpen = true" class="px-4 text-gray-500 border-r border-gray-200 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-green-500 md:hidden">
        <span class="sr-only">Open sidebar</span>
        <svg class="w-6 h-6" x-description="Heroicon name: menu-alt-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
        </svg>
    </button>
    <div class="flex justify-between flex-1 px-4">
        <div class="flex flex-1">
            <form class="flex w-full md:ml-0" action="#" method="GET">
                <label for="search_field" class="sr-only">Search</label>
                <div class="relative w-full text-gray-400 focus-within:text-gray-600 dark:focus-within:text-gray-300">
                    <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none">
                        <x-heroicon-o-magnifying-glass class="w-5 h-5" x-description="Heroicon name: search" />
                    </div>
                    <input id="search_field" class="block w-full h-full py-2 pl-8 pr-3 text-gray-900 placeholder-gray-500 bg-transparent border-transparent dark:text-gray-200 dark:placeholder-gray-400 focus:outline-none focus:placeholder-gray-400 focus:ring-0 focus:border-transparent sm:text-sm" placeholder="Search" type="search" name="search">
                </div>
            </form>
        </div>
        <div class="flex items-center ml-4 md:ml-6">
            <!-- Profile dropdown -->
            <x-auth.user-settings />
        </div>
    </div>
</div>
