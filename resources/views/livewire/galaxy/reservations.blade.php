<div>
    <div class="flex-col mt-5 space-y-4">
        <div class="md:flex md:justify-between">
            <div class="flex flex-col space-y-4 md:items-end md:space-x-4 md:flex-row md:w-1/2">
                <x-bit.input.text type="text" wire:model="filters.search" placeholder="Search reservations..." />
            </div>
            <div class="flex items-end mt-4 md:mt-0">
                <x-bit.data-table.per-page />
            </div>
        </div>

        <x-bit.table>
            <x-slot name="head">
                <x-bit.table.heading sortable wire:click="sortBy('id')" :direction="$sortField === 'id' ? $sortDirection : null">ID</x-bit.table.heading>
                @if($this->user === null)
                <x-bit.table.heading sortable wire:click="sortBy('users.name')" :direction="$sortField === 'users.name' ? $sortDirection : null">Creator</x-bit.table.heading>
                @endif
                @if($this->event === null)
                <x-bit.table.heading sortable wire:click="sortBy('events.name')" :direction="$sortField === 'events.name' ? $sortDirection : null">Event</x-bit.table.heading>
                @endif
                <x-bit.table.heading># Tickets</x-bit.table.heading>
                <x-bit.table.heading sortable wire:click="sortBy('invoice')" :direction="$sortField === 'invoice' ? $sortDirection : null">Has Invoice</x-bit.table.heading>
                <x-bit.table.heading>Amount</x-bit.table.heading>
                <x-bit.table.heading sortable wire:click="sortBy('created_at')" :direction="$sortField === 'created_at' ? $sortDirection : null">Created At</x-bit.table.heading>
                <x-bit.table.heading sortable wire:click="sortBy('reservation_ends')" :direction="$sortField === 'reservation_ends' ? $sortDirection : null">Due Date</x-bit.table.heading>
                <x-bit.table.heading />
            </x-slot>

            <x-slot name="body">
                @forelse($reservations as $reservation)
                <x-bit.table.row wire:key="row-{{ $reservation->id }}">
                    <x-bit.table.cell>{{ $reservation->formattedId }}</x-bit.table.cell>
                    @if($this->user === null)
                    <x-bit.table.cell><a href="{{ route('galaxy.users.show', $reservation->user) }}" class="hover:underline">{{ $reservation->user->name }}</a></x-bit.table.cell>
                    @endif
                    @if($this->event === null)
                    <x-bit.table.cell><a href="{{ route('galaxy.events.show', $reservation->event) }}" class="hover:underline">{{ $reservation->event->name }}</a></x-bit.table.cell>
                    @endif
                    <x-bit.table.cell>{{ $reservation->tickets->count()  }}</x-bit.table.cell>
                    <x-bit.table.cell class="text-center">
                        @if($reservation->invoice !== null)
                        <x-heroicon-o-check class="w-4 h-4" />
                        @endif
                    </x-bit.table.cell>
                    <x-bit.table.cell>{{ $reservation->formattedAmount }}</x-bit.table.cell>
                    <x-bit.table.cell>{{ $reservation->created_at->format('M, d Y') }}</x-bit.table.cell>
                    <x-bit.table.cell>{{ $reservation->reservation_ends->format('M, d Y') }}</x-bit.table.cell>

                    <x-bit.table.cell>
                        <x-bit.button.link size="py-1 px-2" href="{{ route('galaxy.reservations.show', $reservation) }}">
                            <x-heroicon-o-eye class="w-4 h-4 text-green-500 dark:text-green-400" />
                        </x-bit.button.link>
                    </x-bit.table.cell>

                </x-bit.table.row>
                @empty
                <x-bit.table.row>
                    <x-bit.table.cell colspan="9">
                        <div class="flex items-center justify-center space-x-2">
                            <x-heroicon-o-users class="w-8 h-8 text-gray-400" />
                            <span class="py-8 text-xl font-medium text-gray-500 dark:text-gray-400 glacial">No resrvations found...</span>
                        </div>
                    </x-bit.table.cell>
                </x-bit.table.row>
                @endforelse
            </x-slot>
        </x-bit.table>

        <div>
            {{ $reservations->links() }}
        </div>
    </div>
</div>
