@isset ($link['route'])
<x-galaxy.nav-link :href="route($link['route'])" :icon="$link['icon']" :active="request()->routeIs($link['route'])">{{ $link['name'] }}</x-galaxy.nav-link>
@else
<span class="block pt-8 pb-2 pl-2 text-sm tracking-wide text-gray-700 uppercase dark:text-gray-400">{{ $link['name'] }}</span>
@endif
