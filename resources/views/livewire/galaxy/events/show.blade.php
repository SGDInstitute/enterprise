<div>
    <x-bit.nav.tabs :options="$pages" :action="$action" class="mb-8" />

    @switch($page)
        @case('dashboard')
        <livewire:galaxy.events.show.dashboard :event="$event" />
        @break
        @case('reservations')
        <livewire:galaxy.reservations :event="$event" />
        @break
        @case('orders')
        <livewire:galaxy.orders :event="$event" />
        @break
        @case('workshops')
        <livewire:galaxy.events.show.workshops :event="$event" />
        @break
    @endswitch
</div>
