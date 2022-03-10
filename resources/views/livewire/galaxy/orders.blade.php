<div>
    <div class="flex-col mt-5 space-y-4">
        <div class="md:flex md:justify-between">
            <div class="flex flex-col space-y-4 md:items-end md:space-x-4 md:flex-row">
                <x-bit.input.text type="text" wire:model="filters.search" placeholder="Search orders..." />
            </div>
            <div class="flex items-end mt-4 space-x-2 md:mt-0">
                <x-bit.data-table.per-page />
                <x-bit.button.round.secondary wire:click="openPartialModal">Partial</x-bit.button.round.secondary>
            </div>
        </div>

        <x-bit.table>
            <x-slot name="head">
                <x-bit.table.heading class="w-8 pr-0">
                    <x-bit.input.checkbox wire:model="selectPage" />
                </x-bit.table.heading>
                <x-bit.table.heading sortable wire:click="sortBy('id')" :direction="$sortField === 'id' ? $sortDirection : null">ID</x-bit.table.heading>
                @if($this->user === null)
                <x-bit.table.heading sortable wire:click="sortBy('users.name')" :direction="$sortField === 'users.name' ? $sortDirection : null">Creator</x-bit.table.heading>
                @endif
                @if($this->event === null)
                <x-bit.table.heading sortable wire:click="sortBy('events.name')" :direction="$sortField === 'events.name' ? $sortDirection : null">Event</x-bit.table.heading>
                @endif
                <x-bit.table.heading>
                    <div class="flex items-center space-x-2" title="Number of Tickets">
                        <span>#</span>
                        <x-heroicon-o-ticket class="w-4 h-4"/>
                    </div>
                </x-bit.table.heading>
                <x-bit.table.heading sortable title="Has Invoice" wire:click="sortBy('invoice')" :direction="$sortField === 'invoice' ? $sortDirection : null">
                    <x-heroicon-o-document-text class="w-4 h-4"/>
                </x-bit.table.heading>
                <x-bit.table.heading sortable wire:click="sortBy('amount')" :direction="$sortField === 'amount' ? $sortDirection : null">Amount</x-bit.table.heading>
                <x-bit.table.heading sortable wire:click="sortBy('created_at')" :direction="$sortField === 'created_at' ? $sortDirection : null">Created At</x-bit.table.heading>
                <x-bit.table.heading sortable wire:click="sortBy('paid_at')" :direction="$sortField === 'reservation_ends' ? $sortDirection : null">Paid At</x-bit.table.heading>
                <x-bit.table.heading />
            </x-slot>

            <x-slot name="body">
                @if ($selectPage)
                <x-bit.table.row class="bg-gray-200" wire:key="row-message">
                    <x-bit.table.cell colspan="11">
                        @unless ($selectAll)
                        <div>
                            <span>You have selected <strong>{{ $orders->count() }}</strong> orders, do you want to select all <strong>{{ number_format($orders->total()) }}</strong>?</span>
                            <x-bit.button.link wire:click="selectAll" class="ml-1 text-blue-600">Select All</x-bit.button.link>
                        </div>
                        @else
                        <span>You have selected all <strong>{{ number_format($orders->total()) }}</strong> orders.</span>
                        @endif
                    </x-bit.table.cell>
                </x-bit.table.row>
                @endif

                @forelse($orders as $order)
                <x-bit.table.row wire:key="row-{{ $order->id }}">
                    <x-bit.table.cell class="pr-0">
                        <x-bit.input.checkbox wire:model="selected" value="{{ $order->id }}" />
                    </x-bit.table.cell>
                    <x-bit.table.cell>{{ $order->formattedId }}</x-bit.table.cell>
                    @if($this->user === null)
                    <x-bit.table.cell><a href="{{ route('galaxy.users.show', $order->user) }}" class="hover:underline">{{ $order->user->name }}</a></x-bit.table.cell>
                    @endif
                    @if($this->event === null)
                    <x-bit.table.cell><a href="{{ route('galaxy.events.show', $order->event) }}" class="hover:underline">{{ $order->event->name }}</a></x-bit.table.cell>
                    @endif
                    <x-bit.table.cell>{{ $order->tickets->count()  }}</x-bit.table.cell>
                    <x-bit.table.cell class="text-center">
                        @if($order->invoice !== null)
                        <x-heroicon-o-check class="w-4 h-4" />
                        @endif
                    </x-bit.table.cell>
                    <x-bit.table.cell>{{ $order->formattedAmount }}</x-bit.table.cell>
                    <x-bit.table.cell>{{ $order->created_at->format('M, d Y') }}</x-bit.table.cell>
                    <x-bit.table.cell>{{ optional($order->paid_at)->format('M, d Y') }}</x-bit.table.cell>

                    <x-bit.table.cell>
                        <x-bit.button.link size="py-1 px-2" href="{{ route('galaxy.orders.show', $order) }}">
                            <x-heroicon-o-eye class="w-4 h-4 text-green-500 dark:text-green-400" />
                        </x-bit.button.link>
                    </x-bit.table.cell>

                </x-bit.table.row>
                @empty
                <x-bit.table.row>
                    <x-bit.table.cell colspan="11">
                        <div class="flex items-center justify-center space-x-2">
                            <x-heroicon-o-users class="w-8 h-8 text-gray-400" />
                            <span class="py-8 text-xl font-medium text-gray-500 dark:text-gray-400 ">No orders found...</span>
                        </div>
                    </x-bit.table.cell>
                </x-bit.table.row>
                @endforelse
            </x-slot>
        </x-bit.table>

        <div>
            {{ $orders->links() }}
        </div>
    </div>

    @if($editingOrder)
    <form wire:submit.prevent="partialRefund">
        <x-bit.modal.dialog wire:model.defer="showPartialModal">
            <x-slot name="title">Partial Refund</x-slot>

            <x-slot name="content">
                <div class="space-y-2">
                    @foreach($editingOrder->tickets as $ticket)
                    <div class="flex items-center px-3 py-2 space-x-2 border border-gray-900 rounded">
                        <x-bit.input.checkbox wire:model="editingTickets" value="{{ $ticket->id }}" />
                        <span class="dark:text-gray-200">{{ $ticket->user_id ? $ticket->user->name : 'Not filled' }}</span>
                    </div>
                    @endforeach

                    @if(count($editingTickets) > 0)
                    <div class="flex items-center justify-between p-4">
                        <span class="text-lg dark:text-gray-200">{{ count($editingTickets) }} Tickets to Refund</span>
                        <span class="text-lg dark:text-gray-200">Amount to Refund: ${{ $editingTicketsAmount/100 }}</span>
                    </div>
                    @endif
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-bit.button.round.secondary wire:click="resetPartialModal">Cancel</x-bit.button.round.secondary>
                <x-bit.button.round.primary type="submit">Submit</x-bit.button.round.primary>
            </x-slot>
        </x-bit.modal.dialog>
    </form>
    @endif
</div>
