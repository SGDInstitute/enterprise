<div x-data="{ isOpen: false, isSearchOpen: false}">
    <div id="navbar" class="fixed z-50 w-full bg-white shadow-md dark:bg-gray-850">
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
            <nav class="hidden space-x-8 md:flex">
                @isset ($links)
                @foreach ($links as $link)
                <a href="{{ $link['url'] }}" class="text-base font-medium leading-6 text-gray-700 transition duration-150 ease-in-out dark:text-gray-200 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:text-gray-900 dark:focus:text-gray-100">
                    {{ $link['text'] }}
                </a>
                @endforeach
                @endisset
                @guest
                <a href="/" class="text-base font-medium leading-6 text-gray-700 transition duration-150 ease-in-out dark:text-gray-200 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:text-gray-900 dark:focus:text-gray-100">
                    Home
                </a>
                @else
                <a href="/dashboard" class="text-base font-medium leading-6 text-gray-700 transition duration-150 ease-in-out dark:text-gray-200 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:text-gray-900 dark:focus:text-gray-100">
                    Home
                </a>
                @endguest
                <a href="/events" class="text-base font-medium leading-6 text-gray-700 transition duration-150 ease-in-out dark:text-gray-200 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:text-gray-900 dark:focus:text-gray-100">
                    Events
                </a>
                <a href="/donations/create" class="text-base font-medium leading-6 text-gray-700 transition duration-150 ease-in-out dark:text-gray-200 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:text-gray-900 dark:focus:text-gray-100">
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
        <div x-show="isOpen" x-transition:enter="transition ease-out duration-100 transform" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75 transform" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute inset-x-0 top-0 p-2 transition origin-top-right transform md:hidden">
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div>
                            <nav class="grid grid-cols-1 gap-7">
                                @isset ($links)
                                @foreach ($links as $link)
                                <a href="{{ $link['url'] }}" class="p-3 -m-3 space-x-4 font-medium leading-6 text-gray-900 transition duration-150 ease-in-out rounded-lg dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    {{ $link['text'] }}
                                </a>
                                @endforeach
                                @endisset
                                @guest
                                <a href="/" class="p-3 -m-3 space-x-4 font-medium leading-6 text-gray-900 transition duration-150 ease-in-out rounded-lg dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    Home
                                </a>
                                @else
                                <a href="/dashboard" class="p-3 -m-3 space-x-4 font-medium leading-6 text-gray-900 transition duration-150 ease-in-out rounded-lg dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    Home
                                </a>
                                @endguest
                                <a href="/events" class="p-3 -m-3 space-x-4 font-medium leading-6 text-gray-900 transition duration-150 ease-in-out rounded-lg dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    Events
                                </a>
                                <a href="/donations/create" class="p-3 -m-3 space-x-4 font-medium leading-6 text-gray-900 transition duration-150 ease-in-out rounded-lg dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    Donate
                                </a>
                                @guest
                                    <a href="/login" class="p-3 -m-3 space-x-4 font-medium leading-6 text-gray-900 transition duration-150 ease-in-out rounded-lg dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        Login
                                    </a>
                                    <a href="/register" class="p-3 -m-3 space-x-4 font-medium leading-6 text-gray-900 transition duration-150 ease-in-out rounded-lg dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        Create an Account
                                    </a>
                                @else
                                    @can ('galaxy.view')
                                    <a class="p-3 -m-3 space-x-4 font-medium leading-6 text-gray-900 transition duration-150 ease-in-out rounded-lg dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700" href="{{ route('app.dashboard') }}">Frontend</a>
                                    <a class="p-3 -m-3 space-x-4 font-medium leading-6 text-gray-900 transition duration-150 ease-in-out rounded-lg dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700" href="{{ route('galaxy.dashboard') }}">Galaxy</a>
                                    @endcan

                                    @impersonating
                                    <a class="p-3 -m-3 space-x-4 font-medium leading-6 text-gray-900 transition duration-150 ease-in-out rounded-lg dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700" href="{{ route('impersonation.leave') }}">Leave Impersonation</a>
                                    @endImpersonating

                                    <a class="p-3 -m-3 space-x-4 font-medium leading-6 text-gray-900 transition duration-150 ease-in-out rounded-lg dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700" href="{{ route('app.dashboard', 'settings') }}">Settings</a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf

                                        <a class="block p-3 -m-3 space-x-4 font-medium leading-6 text-gray-900 transition duration-150 ease-in-out rounded-lg dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700"
                                            href="route('logout')" onclick="event.preventDefault();
                                                                        this.closest('form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                    </form>
                                @endguest
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="height: 88px"></div>
</div>
