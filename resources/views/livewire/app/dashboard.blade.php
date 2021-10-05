<div class="container px-4 pt-4 pb-12 mx-auto md:py-12 md:px-12">
    <div class="grid grid-cols-1 gap-8 md:grid-cols-4">
        <nav class="space-y-1" aria-label="Sidebar">
            @foreach(config('nav.app.dashboard') as $link)
                <x-galaxy.nav-link :href="route($link['route'], $link['route-param'])" :icon="$link['icon']" :active="$link['route-param'] === $page" >{{ $link['name'] }}</x-galaxy.nav-link>
            @endforeach
        </nav>

        <div class="col-span-3 text-gray-200">
            @if($page === 'orders-reservations')
            <livewire:app.dashboard.orders-reservations />
            @elseif($page === 'workshops')
            <livewire:app.dashboard.workshops />
            @elseif($page === 'donations')
            <livewire:app.dashboard.donations />
            @elseif($page === 'settings')
            <livewire:app.dashboard.settings />
            @endif
        </div>
    </div>
</div>
