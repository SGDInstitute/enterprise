<div x-data="{ isOpen: false, isSearchOpen: false }">
    <div id="navbar" class="fixed z-40 w-full bg-white shadow-md dark:bg-gray-850">
        <div class="flex items-center justify-between px-4 py-6 sm:px-6 md:justify-start md:space-x-10">
            <div class="lg:w-0 lg:flex-1">
                <a href="/" class="flex">
                    <img
                        class="h-8 w-auto dark:hidden sm:h-10"
                        src="https://sgdinstitute.org/assets/logos/institute-logo_horiz-color.svg"
                        alt="Midwest Institute for Sexuality and Gender Diversity"
                    />
                    <img
                        class="hidden h-8 w-auto dark:block sm:h-10"
                        src="https://sgdinstitute.org/assets/logos/institute-logo_horiz-white.svg"
                        alt="Midwest Institute for Sexuality and Gender Diversity"
                    />
                </a>
            </div>
            <div class="-my-2 -mr-2 md:hidden">
                <button
                    type="button"
                    @click="isOpen = !isOpen"
                    class="inline-flex items-center justify-center rounded-md p-2 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 focus:outline-none dark:text-gray-400"
                >
                    <svg
                        class="h-6 w-6"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"
                        ></path>
                    </svg>
                    <span class="sr-only" x-show="isOpen">Close mobile menu</span>
                    <span class="sr-only" x-show="! isOpen">Open mobile menu</span>
                </button>
            </div>
            <nav class="hidden space-x-8 md:flex">
                @isset($links)
                    @foreach ($links as $link)
                        <a
                            href="{{ $link['url'] }}"
                            class="text-base font-medium leading-6 text-gray-700 transition duration-150 ease-in-out hover:text-gray-900 focus:text-gray-900 focus:outline-none dark:text-gray-200 dark:hover:text-gray-100 dark:focus:text-gray-100"
                        >
                            {{ $link['text'] }}
                        </a>
                    @endforeach
                @endisset

                @guest
                    <a
                        href="/"
                        class="text-base font-medium leading-6 text-gray-700 transition duration-150 ease-in-out hover:text-gray-900 focus:text-gray-900 focus:outline-none dark:text-gray-200 dark:hover:text-gray-100 dark:focus:text-gray-100"
                    >
                        Home
                    </a>
                @else
                    <a
                        href="/dashboard"
                        class="text-base font-medium leading-6 text-gray-700 transition duration-150 ease-in-out hover:text-gray-900 focus:text-gray-900 focus:outline-none dark:text-gray-200 dark:hover:text-gray-100 dark:focus:text-gray-100"
                    >
                        Home
                    </a>
                @endguest
                <a
                    href="/events"
                    class="text-base font-medium leading-6 text-gray-700 transition duration-150 ease-in-out hover:text-gray-900 focus:text-gray-900 focus:outline-none dark:text-gray-200 dark:hover:text-gray-100 dark:focus:text-gray-100"
                >
                    Events
                </a>
                <a
                    href="/donations/create"
                    class="text-base font-medium leading-6 text-gray-700 transition duration-150 ease-in-out hover:text-gray-900 focus:text-gray-900 focus:outline-none dark:text-gray-200 dark:hover:text-gray-100 dark:focus:text-gray-100"
                >
                    Donate
                </a>
            </nav>
            <div class="hidden items-center justify-end space-x-8 md:flex md:flex-1 lg:w-0">
                @guest
                    <a
                        href="/login"
                        class="text-base font-medium leading-6 text-gray-700 transition duration-150 ease-in-out hover:text-gray-900 focus:text-gray-900 focus:outline-none dark:text-gray-200 dark:hover:text-gray-100 dark:focus:text-gray-100"
                    >
                        Login
                    </a>
                    <a
                        href="/register"
                        class="text-base font-medium leading-6 text-gray-700 transition duration-150 ease-in-out hover:text-gray-900 focus:text-gray-900 focus:outline-none dark:text-gray-200 dark:hover:text-gray-100 dark:focus:text-gray-100"
                    >
                        Create an Account
                    </a>
                @else
                    <x-auth.user-settings />
                @endif
            </div>
        </div>
        <div
            x-show="isOpen"
            x-transition:enter="transform transition duration-100 ease-out"
            x-transition:enter-start="scale-95 opacity-0"
            x-transition:enter-end="scale-100 opacity-100"
            x-transition:leave="transform transition duration-75 ease-in"
            x-transition:leave-start="scale-100 opacity-100"
            x-transition:leave-end="scale-95 opacity-0"
            class="absolute inset-x-0 top-0 origin-top-right transform p-2 transition md:hidden"
        >
            <div class="max-h-screen overflow-scroll rounded-lg shadow-lg">
                <div
                    class="shadow-xs divide-y-2 divide-gray-50 rounded-lg bg-white dark:divide-gray-700 dark:bg-gray-800"
                >
                    <div class="space-y-6 px-5 pb-6 pt-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <img
                                    class="h-8 w-auto dark:hidden"
                                    src="https://sgdinstitute.org/assets/logos/institute-logo_horiz-color.svg"
                                    alt="Midwest Institute for Sexuality and Gender Diversity"
                                />
                                <img
                                    class="hidden h-8 w-auto dark:block"
                                    src="https://sgdinstitute.org/assets/logos/institute-logo_horiz-white.svg"
                                    alt="Midwest Institute for Sexuality and Gender Diversity"
                                />
                            </div>
                            <div class="-mr-2">
                                <button
                                    type="button"
                                    @click="isOpen = !isOpen"
                                    class="inline-flex items-center justify-center rounded-md p-2 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-500 focus:outline-none dark:text-gray-400"
                                >
                                    <svg
                                        class="h-6 w-6"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"
                                        ></path>
                                    </svg>
                                    <span class="sr-only" x-show="isOpen">Close mobile menu</span>
                                    <span class="sr-only" x-show="! isOpen">Open mobile menu</span>
                                </button>
                            </div>
                        </div>
                        <div>
                            <nav class="grid grid-cols-1 gap-7">
                                @isset($links)
                                    @foreach ($links as $link)
                                        <a
                                            href="{{ $link['url'] }}"
                                            class="-m-3 space-x-4 rounded-lg p-3 font-medium leading-6 text-gray-900 transition duration-150 ease-in-out hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-gray-700"
                                        >
                                            {{ $link['text'] }}
                                        </a>
                                    @endforeach
                                @endisset

                                @guest
                                    <a
                                        href="/"
                                        class="-m-3 space-x-4 rounded-lg p-3 font-medium leading-6 text-gray-900 transition duration-150 ease-in-out hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-gray-700"
                                    >
                                        Home
                                    </a>
                                @else
                                    <a
                                        href="/dashboard"
                                        class="-m-3 space-x-4 rounded-lg p-3 font-medium leading-6 text-gray-900 transition duration-150 ease-in-out hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-gray-700"
                                    >
                                        Home
                                    </a>
                                @endguest
                                <a
                                    href="/events"
                                    class="-m-3 space-x-4 rounded-lg p-3 font-medium leading-6 text-gray-900 transition duration-150 ease-in-out hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-gray-700"
                                >
                                    Events
                                </a>
                                <a
                                    href="/donations/create"
                                    class="-m-3 space-x-4 rounded-lg p-3 font-medium leading-6 text-gray-900 transition duration-150 ease-in-out hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-gray-700"
                                >
                                    Donate
                                </a>
                                @guest
                                    <a
                                        href="/login"
                                        class="-m-3 space-x-4 rounded-lg p-3 font-medium leading-6 text-gray-900 transition duration-150 ease-in-out hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-gray-700"
                                    >
                                        Login
                                    </a>
                                    <a
                                        href="/register"
                                        class="-m-3 space-x-4 rounded-lg p-3 font-medium leading-6 text-gray-900 transition duration-150 ease-in-out hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-gray-700"
                                    >
                                        Create an Account
                                    </a>
                                @else
                                    @can('galaxy.view')
                                        <a
                                            class="-m-3 space-x-4 rounded-lg p-3 font-medium leading-6 text-gray-900 transition duration-150 ease-in-out hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-gray-700"
                                            href="{{ route('app.dashboard') }}"
                                        >
                                            Frontend
                                        </a>
                                        <a
                                            class="-m-3 space-x-4 rounded-lg p-3 font-medium leading-6 text-gray-900 transition duration-150 ease-in-out hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-gray-700"
                                            href="/admin"
                                        >
                                            Galaxy
                                        </a>
                                    @endcan

                                    @impersonating
                                    <a
                                        class="-m-3 space-x-4 rounded-lg p-3 font-medium leading-6 text-gray-900 transition duration-150 ease-in-out hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-gray-700"
                                        href="{{ route('impersonation.leave') }}"
                                    >
                                        Leave Impersonation
                                    </a>
                                    @endImpersonating

                                    <a
                                        class="-m-3 space-x-4 rounded-lg p-3 font-medium leading-6 text-gray-900 transition duration-150 ease-in-out hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-gray-700"
                                        href="{{ route('app.dashboard', 'settings') }}"
                                    >
                                        Settings
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf

                                        <a
                                            class="-m-3 block space-x-4 rounded-lg p-3 font-medium leading-6 text-gray-900 transition duration-150 ease-in-out hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-gray-700"
                                            href="route('logout')"
                                            onclick="event.preventDefault();
                                                                        this.closest('form').submit();"
                                        >
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
