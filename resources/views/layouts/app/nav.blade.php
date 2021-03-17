<div id="navbar" class="fixed z-50 w-full bg-white shadow-md dark:bg-gray-900" x-data="{ isOpen: false, isSearchOpen: false }">
    <div class="flex items-center justify-between px-4 py-6 sm:px-6 md:justify-start md:space-x-10">
        <div class="lg:w-0 lg:flex-1">
            <a href="/" class="flex">
                <img class="w-auto h-8 sm:h-10 dark:hidden" src="https://sgdinstitute.org/assets/logos/institute-logo_horiz-color.svg" alt="Midwest Institute for Sexuality and Gender Diversity">
                <img class="hidden w-auto h-8 sm:h-10 dark:block" src="https://sgdinstitute.org/assets/logos/institute-logo_horiz-white.svg" alt="Midwest Institute for Sexuality and Gender Diversity">
            </a>
        </div>
        <div class="-my-2 -mr-2 md:hidden">
            <button type="button" @click="isOpen = !isOpen" class="inline-flex items-center justify-center p-2 text-gray-700 transition duration-150 ease-in-out rounded-md dark:text-gray-400 hover:text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-700">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
        <nav class="hidden space-x-10 md:flex">
            <a href="/" class="text-base font-medium leading-6 text-gray-700 transition duration-150 ease-in-out dark:text-gray-200 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:text-gray-900 dark:focus:text-gray-100">
                Home
            </a>
            <a href="/events" class="text-base font-medium leading-6 text-gray-700 transition duration-150 ease-in-out dark:text-gray-200 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:text-gray-900 dark:focus:text-gray-100">
                Events
            </a>
            <a href="/donate" class="text-base font-medium leading-6 text-gray-700 transition duration-150 ease-in-out dark:text-gray-200 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:text-gray-900 dark:focus:text-gray-100">
                Donate
            </a>
        </nav>
        <div class="items-center justify-end hidden space-x-8 md:flex md:flex-1 lg:w-0">
            @guest
            <a href="/login" class="text-base font-medium leading-6 text-gray-700 transition duration-150 ease-in-out dark:text-gray-200 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:text-gray-900 dark:focus:text-gray-100">
                Login
            </a>
            <a href="/register" class="text-base font-medium leading-6 text-gray-700 transition duration-150 ease-in-out dark:text-gray-200 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:text-gray-900 dark:focus:text-gray-100">
                Create an Account
            </a>
            @else
                <x-auth.user-settings />
            @endif
        </div>
    </div>
    <div
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-100 transform"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75 transform"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95" x-cloak
        class="absolute inset-x-0 top-0 p-2 transition origin-top-right transform md:hidden">
        <div class="max-h-screen overflow-scroll rounded-lg shadow-lg">
            <div class="bg-white divide-y-2 rounded-lg shadow-xs dark:bg-gray-800 divide-gray-50 dark:divide-gray-700">
                <div class="px-5 pt-5 pb-6 space-y-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <img class="w-auto h-8 dark:hidden" src="https://sgdinstitute.org/assets/logos/institute-logo_horiz-color.svg" alt="Midwest Institute for Sexuality and Gender Diversity">
                            <img class="hidden w-auto h-8 dark:block" src="https://sgdinstitute.org/assets/logos/institute-logo_horiz-white.svg" alt="Midwest Institute for Sexuality and Gender Diversity">
                        </div>
                        <div class="-mr-2">
                            <button type="button" @click="isOpen = !isOpen" class="inline-flex items-center justify-center p-2 text-gray-700 transition duration-150 ease-in-out rounded-md dark:text-gray-400 hover:text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500">
                                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div>
                        <nav class="grid grid-cols-1 gap-7">
                            <a href="/" class="p-3 -m-3 space-x-4 font-medium leading-6 text-gray-900 transition duration-150 ease-in-out rounded-lg dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">
                                Home
                            </a>
                            <a href="/events" class="p-3 -m-3 space-x-4 font-medium leading-6 text-gray-900 transition duration-150 ease-in-out rounded-lg dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">
                                Events
                            </a>
                            <a href="/donate" class="p-3 -m-3 space-x-4 font-medium leading-6 text-gray-900 transition duration-150 ease-in-out rounded-lg dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">
                                Donate
                            </a>
                        </nav>
                    </div>
                </div>
                <div class="px-5 py-6 space-y-6">
                    <a href="/login" class="p-3 -m-3 space-x-4 font-medium leading-6 text-gray-900 transition duration-150 ease-in-out rounded-lg dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">
                        Login
                    </a>
                    <a href="/register" class="p-3 -m-3 space-x-4 font-medium leading-6 text-gray-900 transition duration-150 ease-in-out rounded-lg dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">
                        Create an Account
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div
        x-show="isSearchOpen"
        x-transition:enter="transition ease-out duration-100 transform"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75 transform"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95" x-cloak
        @click.away="isSearchOpen = false"
        class="absolute inset-x-0 top-0 p-2 transition origin-top-right transform z-100">
        <div class="rounded-lg shadow-lg">
            <div class="flex p-3 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="flex-1">
                    <label for="search" class="sr-only">Search</label>
                    <form class="relative" action="/search">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input id="q" name="q" class="block w-full py-2 pl-10 pr-3 text-2xl leading-5 text-gray-900 placeholder-gray-400 transition duration-150 ease-in-out bg-transparent border border-transparent rounded-md dark:text-gray-300 focus:outline-none focus:text-gray-900 dark:focus:text-white" placeholder="Search" type="search">
                    </form>
                </div>
                <button type="button" @click="isSearchOpen = !isSearchOpen" class="inline-flex items-center justify-center p-2 text-gray-700 transition duration-150 ease-in-out rounded-md dark:text-gray-400 hover:text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
<div x-data="{navHeight: 0 }" x-init="navHeight = document.getElementById('navbar').offsetHeight">
    <div :style="'height: ' + navHeight + 'px'" style="height: 80px"></div>
</div>
