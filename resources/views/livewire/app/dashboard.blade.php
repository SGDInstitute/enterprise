<div class="container px-12 py-12 mx-auto">
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
            @endif
        </div>
    </div>

</div>
