<div class="space-y-12">
    <x-ui.steps :steps="$steps" />

    @guest
    <x-ui.alert>You must <a href="/login" class="font-bold text-white underline">Login</a> or <a href="/register" class="font-bold text-white underline">Create an Account</a> before starting a reservation.</x-ui.alert>
    @elseif (! auth()->user()->hasVerifiedEmail())
    <x-ui.alert>You must <a href="{{ route('verification.notice') }}" class="font-bold text-white underline">verify your email</a> before filling out this form.</x-ui.alert>
    @endauth

    <div class="grid grid-cols-1 gap-8 px-4 mx-auto max-w-7xl sm:px-6 lg:px-8 md:grid-cols-3">
        <div>
            <livewire:app.events.modals :event="$event" />
            @if (!$showGuide)
            <x-bit.button.flat.primary wire:click="$set('showGuide', true)" class="mt-4" block>
                <x-heroicon-o-support class="w-6 h-6 text-gray-600 dark:text-gray-400 mr-2" />
                <span>Show Guided Order Creation</span>
            </x-bit.button.flat.primary>
            @endif
        </div>

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
            <x-bit.button.flat.secondary wire:click="showGuideModal">Start a new guided order</x-bit.button.flat.secondary>
            <x-bit.button.flat.secondary wire:click="$set('showPreviousOrders', false)">Start a new order</x-bit.button.flat.secondary>
        </x-slot>
    </x-bit.modal.dialog>

    <x-bit.modal.dialog wire:model="showGuide" max-width="xl">
        <x-slot name="title">Guided Registration</x-slot>
        <x-slot name="subtitle">Let us help you get a head start and set up your order</x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                <div>
                    <x-form.label for="num_tickets" class="mb-1">How many tickets are you ordering?</x-form.label>
                    <x-form.input type="number" wire:model="guide.num_tickets" id="num_tickets" override/>
                    <x-form.error :error="$errors->first('guide.num_tickets')" />
                </div>
                <div>
                    <x-form.label class="mb-1">Is one of these tickets for yourself, personally?</x-form.label>
                    <x-form.radio wire:model="guide.is_attending" value="1" name="is_attending" id="is_attending" label="Yes" />
                    <x-form.radio wire:model="guide.is_attending" value="0" name="is_attending" id="is_attending" label="No" />
                    <x-form.error :error="$errors->first('guide.is_attending')" />
                </div>
                <div>
                    <x-form.label class="mb-1">How will you pay?</x-form.label>
                    <x-form.radio wire:model="guide.payment" value="1" name="payment" id="payment" label="Generate invoice and pay later" />
                    <x-form.radio wire:model="guide.payment" value="0" name="payment" id="payment" label="Pay now with card" />
                    <x-form.error :error="$errors->first('guide.payment')" />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-bit.button.flat.secondary wire:click="$set('showGuide', false)">Close</x-bit.button.flat.secondary>
            <x-bit.button.flat.primary wire:click="generate">Generate Order</x-bit.button.flat.primary>
        </x-slot>
    </x-bit.modal.dialog>
</div>
