@isset($link['route'])
    <x-galaxy.nav-link
        :href="route($link['route'])"
        :icon="$link['icon']"
        :active="request()->routeIs($link['route'])"
    >
        {{ $link['name'] }}
    </x-galaxy.nav-link>
@else
    <span class="block pb-2 pl-2 pt-8 text-sm uppercase tracking-wide text-gray-700 dark:text-gray-400">
        {{ $link['name'] }}
    </span>
@endif
