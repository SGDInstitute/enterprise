<div class="space-y-12">
    <x-ui.steps :steps="$steps" />

    @guest
    <x-ui.alert>You must <a href="/login" class="font-bold text-white underline">Login</a> or <a href="/register" class="font-bold text-white underline">Create an Account</a> before starting a reservation.</x-ui.alert>
    @elseif(! auth()->user()->hasVerifiedEmail())
    <x-ui.alert>You must <a href="{{ route('verification.notice') }}" class="font-bold text-white underline">verify your email</a> before filling out this form.</x-ui.alert>
    @endauth

    <div class="grid grid-cols-1 gap-8 px-4 mx-auto max-w-7xl sm:px-6 lg:px-8 md:grid-cols-3">
        <livewire:app.events.modals :event="$event" />

        <div class="col-span-2">
            <livewire:app.events.tickets :event="$event" />
        </div>
    </div>

    <x-bit.modal.dialog wire:model="showPreviousOrders" max-width="6xl">
        <x-slot name="title">Previous Reservations & Orders for {{ $event->name }}</x-slot>

        <x-slot name="content">
            <x-bit.table>
                <x-slot name="head">
                    <x-bit.table.heading>Date Created</x-bit.table.heading>
                    <x-bit.table.heading>Status</x-bit.table.heading>
                    <x-bit.table.heading>Amount</x-bit.table.heading>
                    <x-bit.table.heading>Number of Tickets</x-bit.table.heading>
                    <x-bit.table.heading></x-bit.table.heading>
                </x-slot>

                <x-slot name="body">
                    @forelse ($previousOrders as $order)
                    <x-bit.table.row wire:key="row-{{ $order->id }}">
                        <x-bit.table.cell>{{ $order->created_at->timezone($event->timezone)->format('M, d Y') }}</x-bit.table.cell>
                        <x-bit.table.cell>{{ $order->isPaid() ? 'Paid' : 'Reservation' }}</x-bit.table.cell>
                        <x-bit.table.cell>{{ $order->formattedAmount }}</x-bit.table.cell>
                        <x-bit.table.cell>{{ $order->tickets_count }}</x-bit.table.cell>
                        <x-bit.table.cell>
                            <x-bit.button.link size="py-1 px-2" href="{{ route('app.orders.show', $order) }}">
                                View
                            </x-bit.button.link>
                        </x-bit.table.cell>
                    </x-bit.table.row>
                    @empty
                    <x-bit.table.row>
                        <x-bit.table.cell colspan="9">
                            <div class="flex items-center justify-center space-x-2">
                                <x-heroicon-o-ticket class="w-8 h-8 text-gray-400" />
                                <span class="py-8 text-xl font-medium text-gray-500 dark:text-gray-400 ">No existing reservations or orders found...</span>
                            </div>
                        </x-bit.table.cell>
                    </x-bit.table.row>
                    @endforelse
                </x-slot>
            </x-bit.table>
        </x-slot>

        <x-slot name="footer">
            <x-bit.button.flat.secondary wire:click="$set('showPreviousOrders', false)">Start a new order</x-bit.button.flat.secondary>
        </x-slot>
    </x-bit.modal.dialog>
</div>
