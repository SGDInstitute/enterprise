<div class="hidden md:flex md:flex-shrink-0">
    <div class="flex flex-col w-64">
        <div class="flex flex-col flex-grow pt-5 pb-4 overflow-y-auto bg-white border-r border-gray-200 dark:bg-gray-850 dark:border-gray-700">
            <div class="flex items-center flex-shrink-0 px-4">
                <img class="w-auto h-8" src="/img/galaxy.png" alt="Galaxy">
                <span class="ml-4 text-xl dark:text-white">Galaxy</span>
            </div>
            <div class="flex flex-col flex-grow mt-5">
                <nav class="flex-1 px-2 space-y-1 bg-white dark:bg-gray-850">
                    @foreach (config('nav.galaxy') as $link)
                    @isset ($link['route'])
                    <x-galaxy.nav-link :href="route($link['route'])" :icon="$link['icon']" :active="request()->routeIs($link['route'])">{{ $link['name'] }}</x-galaxy.nav-link>
                    @else
                    <span class="block pt-8 pb-2 pl-2 text-sm tracking-wide text-gray-700 uppercase dark:text-gray-400">{{ $link['name'] }}</span>
                    @endif
                    @endforeach
                </nav>
            </div>
        </div>
    </div>
</div>
