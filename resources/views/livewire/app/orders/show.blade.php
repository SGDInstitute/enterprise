<div class="mt-12 space-y-12">
    <div
        class="{{ $order->user_id === auth()->id() ? '' : 'pt-12' }} mx-auto grid max-w-7xl grid-cols-1 gap-8 px-4 sm:px-6 md:grid-cols-3 lg:px-8"
    >
        <div class="space-y-4">
            <livewire:app.events.modals :event="$order->event" />

            @if (auth()->user()->can('delete', $order) && $order->isReservation())
                <x-bit.button.flat.primary block wire:click="delete" class="space-x-2">
                    <x-heroicon-o-trash class="h-4 w-4" />
                    <span>Delete Order</span>
                </x-bit.button.flat.primary>
            @endif
        </div>

        <div class="col-span-2">
            @if ($order->user_id === auth()->id())
                <nav class="mb-6 flex divide-x divide-gray-200 overflow-hidden shadow dark:divide-gray-700">
                    <a
                        href="{{ route('app.orders.show', [$this->order, 'payment']) }}"
                        class="group relative min-w-0 flex-1 overflow-hidden bg-white px-4 py-4 text-center font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-700 focus:z-10 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200"
                    >
                        <span>Payment</span>
                        <span
                            aria-hidden="true"
                            class="{{ $page === 'payment' ? 'bg-green-500' : 'bg-transparent' }} absolute inset-x-0 bottom-0 h-0.5"
                        ></span>
                    </a>
                    <a
                        href="{{ route('app.orders.show', [$this->order, 'tickets']) }}"
                        class="group relative min-w-0 flex-1 overflow-hidden bg-white px-4 py-4 text-center font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-700 focus:z-10 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200"
                    >
                        <span>Tickets</span>
                        <span
                            aria-hidden="true"
                            class="{{ $page === 'tickets' ? 'bg-green-500' : 'bg-transparent' }} absolute inset-x-0 bottom-0 h-0.5"
                        ></span>
                    </a>
                    @if ($order->tickets->pluck('user_id')->contains(auth()->id()))
                        <a
                            href="{{ route('app.orders.show', [$this->order, 'attendee']) }}"
                            class="group relative min-w-0 flex-1 overflow-hidden bg-white px-4 py-4 text-center font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-700 focus:z-10 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200"
                        >
                            <span>Attendee</span>
                            <span
                                aria-hidden="true"
                                class="{{ $page === 'attendee' ? 'bg-green-500' : 'bg-transparent' }} absolute inset-x-0 bottom-0 h-0.5"
                            ></span>
                        </a>
                    @endif

                    <a
                        href="{{ route('app.orders.show', [$this->order, 'checklist']) }}"
                        class="group relative min-w-0 flex-1 overflow-hidden bg-white px-4 py-4 text-center font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-700 focus:z-10 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200"
                    >
                        <span>Checklist</span>
                        <span
                            aria-hidden="true"
                            class="{{ $page === 'checklist' ? 'bg-green-500' : 'bg-transparent' }} absolute inset-x-0 bottom-0 h-0.5"
                        ></span>
                    </a>
                </nav>
            @endif

            @if ($page === 'checklist')
                <livewire:app.orders.checklist :order="$order" />
            @elseif ($page === 'payment')
                <livewire:app.orders.payment :order="$order" />
            @elseif ($page === 'tickets')
                <livewire:app.orders.tickets-table :order="$order" />
            @elseif ($page === 'attendee')
                <livewire:app.orders.attendee :order="$order" />
            @endif
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://js.stripe.com/v3/"></script>
@endpush
