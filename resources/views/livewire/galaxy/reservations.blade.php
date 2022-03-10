<div>
    <div class="flex-col mt-5 space-y-4">
        <div class="md:flex md:justify-between">
            <div class="flex flex-col space-y-4 md:items-end md:space-x-4 md:flex-row md:w-1/2">
                <x-bit.input.text type="text" wire:model="filters.search" placeholder="Search reservations..." />
            </div>
            <div class="flex items-end mt-4 space-x-2 md:mt-0">
                <x-bit.data-table.per-page />
                <x-bit.button.round.secondary wire:click="comp">Comp</x-bit.button.round.secondary>
                <x-bit.button.round.secondary wire:click="$toggle('showInvoiceModal')">Mark as Paid</x-bit.button.round.secondary>
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
                <x-bit.table.heading>Amount</x-bit.table.heading>
                <x-bit.table.heading sortable wire:click="sortBy('created_at')" :direction="$sortField === 'created_at' ? $sortDirection : null">Created At</x-bit.table.heading>
                <x-bit.table.heading sortable wire:click="sortBy('reservation_ends')" :direction="$sortField === 'reservation_ends' ? $sortDirection : null">Due Date</x-bit.table.heading>
                <x-bit.table.heading />
            </x-slot>

            <x-slot name="body">
                @if ($selectPage)
                <x-bit.table.row class="bg-gray-200" wire:key="row-message">
                    <x-bit.table.cell colspan="11">
                        @unless ($selectAll)
                        <div>
                            <span>You have selected <strong>{{ $reservation->count() }}</strong> orders, do you want to select all <strong>{{ number_format($reservation->total()) }}</strong>?</span>
                            <x-bit.button.link wire:click="selectAll" class="ml-1 text-blue-600">Select All</x-bit.button.link>
                        </div>
                        @else
                        <span>You have selected all <strong>{{ number_format($reservation->total()) }}</strong> orders.</span>
                        @endif
                    </x-bit.table.cell>
                </x-bit.table.row>
                @endif

                @forelse($reservations as $reservation)
                <x-bit.table.row wire:key="row-{{ $reservation->id }}">
                    <x-bit.table.cell class="pr-0">
                        <x-bit.input.checkbox wire:model="selected" value="{{ $reservation->id }}" />
                    </x-bit.table.cell>
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
                    <x-bit.table.cell>{{ optional($reservation->reservation_ends)->format('M, d Y') }}</x-bit.table.cell>

                    <x-bit.table.cell>
                        <x-bit.button.link size="py-1 px-2" href="{{ route('galaxy.reservations.show', $reservation) }}">
                            <x-heroicon-o-eye class="w-4 h-4 text-green-500 dark:text-green-400" />
                        </x-bit.button.link>
                    </x-bit.table.cell>

                </x-bit.table.row>
                @empty
                <x-bit.table.row>
                    <x-bit.table.cell colspan="11">
                        <div class="flex items-center justify-center space-x-2">
                            <x-heroicon-o-users class="w-8 h-8 text-gray-400" />
                            <span class="py-8 text-xl font-medium text-gray-500 dark:text-gray-400 ">No resrvations found...</span>
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

    <form wire:submit.prevent="markAsPaid">
        <x-bit.modal.dialog wire:model.defer="showInvoiceModal">
            <x-slot name="title">Orders</x-slot>

            <x-slot name="content">
                <div class="space-y-2">
                    @foreach($selected as $id)
                    <div wire:key="{{ $id }}">
                        <span class="dark:text-gray-200">Order {{ $id }}</span>
                        <div class="grid grid-cols-2 gap-8">
                            <x-bit.input.group :for="'check-number-' . $id" label="Check Number">
                                <x-bit.input.text class="w-full mt-1" wire:model="invoices.{{ $id }}.check" :id="'check-number-' . $id" />
                            </x-bit.input.group>
                            <x-bit.input.group :for="'amount-' . $id" label="Amount">
                                <x-bit.input.text leading-add-on="$" wire:model="invoices.{{ $id }}.amount" :id="'amount-' . $id" />
                            </x-bit.input.group>
                        </div>
                    </div>
                    @endforeach
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-bit.button.round.secondary wire:click="$set('showInvoiceModal', false)">Cancel</x-bit.button.round.secondary>
                <x-bit.button.round.primary type="submit">Mark as Paid</x-bit.button.round.primary>
            </x-slot>
        </x-bit.modal.dialog>
    </form>
</div>
