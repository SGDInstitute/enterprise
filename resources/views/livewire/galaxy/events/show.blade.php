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
        <livewire:galaxy.responses :event="$event" />
        @break
        @case('schedule')
        <livewire:galaxy.events.show.schedule :event="$event" />
        @break
    @endswitch
</div>
