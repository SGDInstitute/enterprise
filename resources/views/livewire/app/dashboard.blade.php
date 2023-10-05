<div class="container px-4 pt-4 pb-12 mx-auto md:py-12 md:px-12">
    <div class="grid grid-cols-1 gap-8 md:grid-cols-4">
        <nav class="space-y-1" aria-label="Sidebar">
            @foreach (config('nav.app.dashboard') as $link)
                <x-galaxy.nav-link :href="route($link['route'], $link['route-param'])" :icon="$link['icon']" :active="$link['route-param'] === $page" >{{ $link['name'] }}</x-galaxy.nav-link>
            @endforeach
            <x-galaxy.nav-link :href="route('app.dashboard', 'orders-reservations')" icon="heroicon-o-calendar" :active="'orders-reservations' === $page" >Event Tickets</x-galaxy.nav-link>
            <x-galaxy.nav-link :href="route('app.dashboard', 'workshops')" icon="heroicon-o-light-bulb" :active="'workshops' === $page" >Workshop Submissions</x-galaxy.nav-link>
            <x-galaxy.nav-link :href="route('app.dashboard', 'donations')" icon="heroicon-o-gift" :active="'donations' === $page" >Donations</x-galaxy.nav-link>
            <x-galaxy.nav-link :href="route('app.dashboard', 'settings')" icon="heroicon-o-cog" :active="'settings' === $page" >Settings</x-galaxy.nav-link>
        </nav>

        <div class="col-span-3 text-gray-200">
            @if ($page === 'orders-reservations')
            <livewire:app.dashboard.orders-reservations />
            @elseif ($page === 'workshops')
            <livewire:app.dashboard.workshops />
            @elseif ($page === 'donations')
            <livewire:app.dashboard.donations />
            @elseif ($page === 'settings')
            <livewire:app.dashboard.settings />
            @endif
        </div>
    </div>
</div>
