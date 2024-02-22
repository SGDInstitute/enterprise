<nav x-data="{ open: false }" class="fixed z-50 w-full bg-gray-100 dark:bg-gray-900">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
        <div class="relative flex h-16 items-center justify-between">
            <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                <!-- Mobile menu button-->
                <button
                    type="button"
                    @click="open = !open"
                    class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                    aria-controls="mobile-menu"
                    aria-expanded="false"
                >
                    <span class="sr-only">Open main menu</span>
                    <x-heroicon-o-bars-3 x-show="!open" class="h-6 w-6" />
                    <x-heroicon-o-x-mark x-show="open" x-cloak class="h-6 w-6" />
                </button>
            </div>
            <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                <div class="flex flex-shrink-0 items-center">
                    <span class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ $title }}</span>
                </div>
                <div class="hidden sm:ml-6 sm:block">
                    <div class="flex space-x-4">
                        <a
                            href="{{ route('app.program', [$event, 'bulletin-board']) }}"
                            class="rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-700 hover:text-white dark:text-gray-200"
                        >
                            Bulletin Board
                        </a>

                        <a
                            href="{{ route('app.program', [$event, 'schedule']) }}"
                            class="rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-700 hover:text-white dark:text-gray-200"
                        >
                            In-person Schedule
                        </a>

                        <a
                            href="{{ route('app.program', [$event, 'my-schedule']) }}"
                            class="rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-700 hover:text-white dark:text-gray-200"
                        >
                            My Schedule
                        </a>

                        <a
                            href="{{ route('app.program', [$event, 'badge']) }}"
                            class="rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-700 hover:text-white dark:text-gray-200"
                        >
                            Virtual Badge
                        </a>

                        <a
                            href="{{ route('app.program', [$event, 'contact']) }}"
                            class="rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-700 hover:text-white dark:text-gray-200"
                        >
                            Contact
                        </a>
                    </div>
                </div>
            </div>
            <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                <x-auth.user-settings />
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div class="sm:hidden" x-show="open" x-cloak id="mobile-menu">
        <div class="space-y-1 px-2 pb-3 pt-2">
            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
            <!-- <a href="{{ route('app.program', [$event, 'bulletin-board']) }}" class="block px-3 py-2 text-base font-medium text-white bg-gray-800 rounded-md" aria-current="page">Bulletin Board</a> -->
            <a
                href="{{ route('app.program', [$event, 'bulletin-board']) }}"
                class="block rounded-md px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-700 hover:text-white dark:text-gray-300"
            >
                Bulletin Board
            </a>

            <a
                href="{{ route('app.program', [$event, 'schedule']) }}"
                class="block rounded-md px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-700 hover:text-white dark:text-gray-300"
            >
                Schedule
            </a>

            <a
                href="{{ route('app.program', [$event, 'my-schedule']) }}"
                class="block rounded-md px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-700 hover:text-white dark:text-gray-300"
            >
                My Schedule
            </a>

            <a
                href="{{ route('app.program', [$event, 'badge']) }}"
                class="block rounded-md px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-700 hover:text-white dark:text-gray-300"
            >
                Virtual Badge
            </a>

            <a
                href="{{ route('app.program', [$event, 'contact']) }}"
                class="block rounded-md px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-700 hover:text-white dark:text-gray-300"
            >
                Contact
            </a>
        </div>
    </div>
</nav>
<div style="height: 64px"></div>
