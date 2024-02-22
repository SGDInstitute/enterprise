<div
    x-show="sidebarOpen"
    class="md:hidden"
    x-description="Off-canvas menu for mobile, show/hide based on off-canvas menu state."
>
    <div class="fixed inset-0 z-40 flex">
        <div
            @click="sidebarOpen = false"
            x-show="sidebarOpen"
            x-description="Off-canvas menu overlay, show/hide based on off-canvas menu state."
            x-transition:enter="transition-opacity duration-300 ease-linear"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-300 ease-linear"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0"
            aria-hidden="true"
            style="display: none"
        >
            <div class="absolute inset-0 bg-gray-600 opacity-75"></div>
        </div>
        <div
            x-show="sidebarOpen"
            x-description="Off-canvas menu, show/hide based on off-canvas menu state."
            x-transition:enter="transform transition duration-300 ease-in-out"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition duration-300 ease-in-out"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="relative flex w-full max-w-xs flex-1 flex-col bg-white pb-4 pt-5 dark:bg-gray-900"
            style="display: none"
        >
            <div class="absolute right-0 top-0 -mr-12 pt-2">
                <button
                    x-show="sidebarOpen"
                    @click="sidebarOpen = false"
                    class="ml-1 flex h-10 w-10 items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                    style="display: none"
                >
                    <span class="sr-only">Close sidebar</span>
                    <x-heroicon-o-x-markclass ="w-6 h-6 text-white" x-description="Heroicon name: x" />
                </button>
            </div>
            <div class="flex flex-shrink-0 items-center px-4">
                <img class="h-8 w-auto" src="/img/galaxy.png" alt="Galaxy" />
                <span class="ml-4 text-xl dark:text-white">Galaxy</span>
            </div>
            <div class="mt-5 h-0 flex-1 overflow-y-auto">
                <nav class="space-y-1 px-2">
                    @foreach (config('nav.galaxy') as $link)
                        @if (isset($link['roles']) &&auth()->user()->hasRole($link['roles']))
                            @include('layouts.galaxy.item')
                        @endif
                    @endforeach
                </nav>
            </div>
        </div>
        <div class="w-14 flex-shrink-0" aria-hidden="true">
            <!-- Dummy element to force sidebar to shrink to fit close icon -->
        </div>
    </div>
</div>
