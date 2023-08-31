<div class="space-y-4">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-bold leading-7 text-gray-900 dark:text-gray-100 sm:text-2xl sm:truncate">{{ $tickets->total() }} Tickets</h2>

        <span class="relative z-0 inline-flex rounded-md shadow-sm">
            <button wire:click="$set('ticketsView', 'table')" type="button" class="{{ $ticketsView === 'table' ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-200' : 'text-gray-500 bg-white dark:text-gray-400 dark:bg-gray-900' }} relative inline-flex items-center px-2 py-2 text-sm font-medium border border-gray-300 dark:border-gray-700 rounded-l-md hover:bg-gray-50 dark:hover:bg-gray-700 focus:z-10 focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500">
                <span class="sr-only">Table View</span>
                <x-heroicon-o-table-cells class="w-5 h-5" />
            </button>
            <button wire:click="$set('ticketsView', 'grid')" type="button" class="{{ $ticketsView === 'grid' ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-200' : 'text-gray-500 bg-white dark:text-gray-400 dark:bg-gray-900' }} relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium border border-gray-300 dark:border-gray-700 rounded-r-md hover:bg-gray-50 dark:hover:bg-gray-700 focus:z-10 focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500">
                <span class="sr-only">Grid View</span>
                <x-heroicon-o-squares-2x2 class="w-5 h-5" />
            </button>
        </span>
    </div>

    @if ($ticketsView === 'table')
    <div class="flex-col mt-5 space-y-4">
        <div class="md:flex md:justify-between">
            <x-bit.input.text type="text" wire:model.live="filters.search" placeholder="Search tickets..." />
            <div class="flex space-x-4">
                <x-bit.data-table.per-page />
                @if (auth()->id() === $order->user_id)
                @if (!$editMode)
                <x-bit.button.round.secondary wire:click="enableEditMode">Enable In-line Editing</x-bit.button.round.secondary>
                @else
                <x-bit.button.round.secondary wire:click="$set('editMode', false)">Disable Editing</x-bit.button.round.secondary>
                <x-bit.button.round.primary wire:click="saveTickets">Save Changes</x-bit.button.round.primary>
                @endif
                @endif
            </div>
        </div>

        @if (!$editMode)
        @include('livewire.app.orders.partials.table-tickets')
        @else
        @include('livewire.app.orders.partials.table-tickets-editable')
        @endif

        <div>
            {{ $tickets->links() }}
        </div>
    </div>
    @else
    @include('livewire.app.orders.partials.grid-tickets')
    <div>
        {{ $tickets->links() }}
    </div>
    @endif

    @if (auth()->user()->can('update', $order) && $order->isReservation())
    <x-bit.button.flat.primary wire:click="add">Add another ticket</x-bit.button.flat.primary>
    @endif

    @can('update', $order)
    <div class="px-4 py-6 mt-16 lg:w-2/3 lg:ml-auto bg-gray-50 dark:bg-gray-800 shadow dark:border dark:border-gray-700 sm:p-6 lg:p-8 lg:mt-0">
        <dl class="space-y-4">
            <div class="flex items-center justify-between">
                <dt class="text-lg font-medium text-gray-900 dark:text-gray-200">Order total</dt>
                <dd class="text-lg font-medium text-gray-900 dark:text-gray-200">{{ $order->formattedAmount }}</dd>
                <div wire:loading.delay class="ml-4">
                    <x-heroicon-o-cog class="w-8 h-8 text-gray-400 animate-spin" />
                </div>
            </div>
        </dl>

        <div class="mt-6 space-y-3">
            @if ($order->isReservation())
            <x-bit.button.round.primary href="{{ route('app.orders.show', [$order, 'payment']) }}" block size="lg">Pay now</x-bit.button.round.primary>
            <div>
                <p class="text-gray-700 dark:text-gray-400">Your order is not complete until payment is received.</p>
                <p class="text-gray-700 dark:text-gray-400">By clicking "Pay now" you agree to the policies listed <span class="hidden lg:inline">to the left</span><span class="lg:hidden">above</span>.</p>
            </div>
            @endif
            <div class="space-x-1">
                <x-bit.button.flat.primary href="{{ route('app.orders.show', [$order, 'payment']) }}" size="xs" class="space-x-2">
                    <x-heroicon-o-arrow-down-tray class="w-4 h-4" /> <span>Download Invoice</span>
                </x-bit.button.flat.primary>
                <x-bit.button.flat.primary wire:click="downloadW9" size="xs" class="space-x-2">
                    <x-heroicon-o-arrow-down-tray class="w-4 h-4" /> <span>Download W9</span>
                </x-bit.button.flat.primary>
            </div>
        </div>
    </div>
    @endcan

    @if ($editingTicket)
    @include('livewire.app.orders.partials.invite-modal')
    @include('livewire.app.orders.partials.ticket-modal')
    @endif
</div>