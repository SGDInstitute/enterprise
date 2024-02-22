<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
    <x-bit.stat icon="heroicon-o-calendar" title="Days until Event" :value="$daysLeft" color="green" />
    <x-bit.stat icon="heroicon-o-cursor-arrow-ripple" title="Reservations" :value="$reservations" color="green" />
    <x-bit.stat icon="heroicon-o-currency-dollar" title="Orders" :value="$orders" color="green" />

    @foreach ($tickets as $ticket)
        <x-bit.stat icon="heroicon-o-ticket" :title="$ticket['ticketType']['name']" color="green">
            <x-slot name="value">
                Reservations: {{ $ticket['reservations_count'] }} Orders: {{ $ticket['orders_count'] }}
            </x-slot>
        </x-bit.stat>
    @endforeach
</div>
