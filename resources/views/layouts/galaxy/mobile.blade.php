<div x-show="sidebarOpen" class="md:hidden" x-description="Off-canvas menu for mobile, show/hide based on off-canvas menu state.">
    <div class="fixed inset-0 z-40 flex">
        <div @click="sidebarOpen = false" x-show="sidebarOpen" x-description="Off-canvas menu overlay, show/hide based on off-canvas menu state." x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0" aria-hidden="true" style="display: none;">
            <div class="absolute inset-0 bg-gray-600 opacity-75"></div>
        </div>
        <div x-show="sidebarOpen" x-description="Off-canvas menu, show/hide based on off-canvas menu state." x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="relative flex flex-col flex-1 w-full max-w-xs pt-5 pb-4 bg-white dark:bg-gray-900" style="display: none;">
            <div class="absolute top-0 right-0 pt-2 -mr-12">
                <button x-show="sidebarOpen" @click="sidebarOpen = false" class="flex items-center justify-center w-10 h-10 ml-1 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" style="display: none;">
                    <span class="sr-only">Close sidebar</span>
                    <x-heroicon-o-x class="w-6 h-6 text-white" x-description="Heroicon name: x"/>
                </button>
            </div>
            <div class="flex items-center flex-shrink-0 px-4">
                <img class="w-auto h-8" src="/img/galaxy.png" alt="Galaxy">
                <span class="ml-4 text-xl dark:text-white">Galaxy</span>
            </div>
            <div class="flex-1 h-0 mt-5 overflow-y-auto">
                <nav class="px-2 space-y-1">
                    @foreach (config('nav.galaxy') as $link)
                    @isset ($link['route'])
                    <x-galaxy.nav-link responsive :href="route($link['route'])" :icon="$link['icon']" :active="request()->routeIs($link['route'])">{{ $link['name'] }}</x-galaxy.nav-link>
                    @else
                    <span class="block pt-4 pb-2 pl-2 mt-4 text-sm tracking-wide text-gray-700 uppercase dark:text-gray-400">{{ $link['name'] }}</span>
                    @endif
                    @endforeach
                </nav>
            </div>
        </div>
        <div class="flex-shrink-0 w-14" aria-hidden="true">
            <!-- Dummy element to force sidebar to shrink to fit close icon -->
        </div>
    </div>
</div>
