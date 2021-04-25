<div class="container px-12 py-12 mx-auto space-y-8">
    <div class="space-y-4">
        <h1 class="text-2xl font-bold leading-7 text-gray-900 dark:text-gray-100 sm:text-3xl sm:truncate">{{ $order->event->name }} {{ $order->isPaid() ? 'Order Details' : 'Reservation Details'}}</h1>
        <x-bit.progress :steps="$progressSteps" :current="$progressCurrent" />
    </div>

    <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
        <div class="space-y-4">
            <div class="block h-64 transition duration-150 ease-in-out bg-green-500 shadow">
                <div class="bg-center bg-cover h-1/2" style="background-image: url({{ $order->event->backgroundUrl }});">
                    <img src="{{ $order->event->backgroundUrl }}" alt="{{ $order->event->name }}" class="sr-only">
                </div>
                <div class="px-4 py-2 mx-4 -mt-8 transition duration-150 ease-in-out bg-green-500">
                    <p class="text-2xl text-gray-200">{{ $order->event->name }}</p>
                    <p class="text-sm text-gray-300 text-italic">{{ $order->event->formattedDuration }}</p>
                    <p class="text-sm text-gray-300 text-italic">{{ $order->event->formattedLocation }}</p>
                    <p class="flex items-center mt-2 space-x-2 text-lg text-gray-200">
                        <x-heroicon-o-ticket class="w-6 h-6" />
                        <span>{{ $order->tickets->count() }} Tickets</span>
                    </p>
                </div>
            </div>

            <div class="p-4 space-y-2 bg-gray-100 shadow dark:bg-gray-700">
                <p class="text-xl font-bold text-gray-700 dark:text-gray-400">{{ $subtotal }}</p>
                <p class="text-gray-700 dark:text-gray-400">Tickets filled: {{ $filledCount }} of {{ $order->tickets->count() }}</p>
            </div>

            <div class="grid grid-cols-1 overflow-hidden bg-gray-100 divide-y divide-gray-200 shadow dark:divide-gray-800 dark:bg-gray-700">
                @if($order->isPaid() && auth()->id() === $order->user_id)
                <button class="flex items-center w-full px-6 py-4 space-x-4 text-gray-900 hover:bg-gray-200 dark:hover:bg-gray-900 dark:text-gray-200">
                    <x-heroicon-o-receipt-tax class="w-6 h-6" />
                    <span>View Receipt</span>
                </button>
                @else
                <div>
                    {!! $checkout->button('Pay with Card', ['class' => 'flex items-center w-full px-6 py-4 space-x-4 text-gray-900 hover:bg-gray-200 dark:hover:bg-gray-900 dark:text-gray-200' ]) !!}
                </div>
                <button wire:click="$set('showCheckModal', true)" class="flex items-center w-full px-6 py-4 space-x-4 text-gray-900 hover:bg-gray-200 dark:hover:bg-gray-900 dark:text-gray-200">
                    <x-heroicon-o-mail class="w-6 h-6" />
                    <span>Pay with Check</span>
                </button>
                @endif
                @if($order->invoice !== null)
                <button wire:click="$set('showInvoiceModal', true)" class="flex items-center w-full px-6 py-4 space-x-4 text-gray-900 hover:bg-gray-200 dark:hover:bg-gray-900 dark:text-gray-200">
                    <x-heroicon-o-document-text class="w-6 h-6" />
                    <span>Edit Invoice</span>
                </button>
                @else
                <button wire:click="createInvoice" class="flex items-center w-full px-6 py-4 space-x-4 text-gray-900 hover:bg-gray-200 dark:hover:bg-gray-900 dark:text-gray-200">
                    <x-heroicon-o-document-text class="w-6 h-6" />
                    <span>Create Invoice</span>
                </button>
                @endif
                <button wire:click="downloadW9" class="flex items-center w-full px-6 py-4 space-x-4 text-gray-900 hover:bg-gray-200 dark:hover:bg-gray-900 dark:text-gray-200">
                    <x-heroicon-o-document-download class="w-6 h-6" />
                    <span>Download W-9</span>
                </button>
                @if(!$order->isPaid() && auth()->id() === $order->user_id)
                <button wire:click="delete" onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" class="flex items-center w-full px-6 py-4 space-x-4 text-gray-900 hover:bg-gray-200 dark:hover:bg-gray-900 dark:text-gray-200">
                    <x-heroicon-o-trash class="w-6 h-6" />
                    <span>Delete Order</span>
                </button>
                @endif
            </div>
        </div>
        <div class="space-y-4 md:col-span-2">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold leading-7 text-gray-900 dark:text-gray-100 sm:text-2xl sm:truncate">Tickets</h2>

                <span class="relative z-0 inline-flex rounded-md shadow-sm">
                    <button wire:click="$set('ticketsView', 'table')" type="button" class="{{ $ticketsView === 'table' ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-200' : 'text-gray-500 bg-white dark:text-gray-400 dark:bg-gray-900' }} relative inline-flex items-center px-2 py-2 text-sm font-medium border border-gray-300 dark:border-gray-700 rounded-l-md hover:bg-gray-50 dark:hover:bg-gray-700 focus:z-10 focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500">
                        <span class="sr-only">Table View</span>
                        <x-heroicon-o-table class="w-5 h-5" />
                    </button>
                    <button wire:click="$set('ticketsView', 'grid')" type="button" class="{{ $ticketsView === 'grid' ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-200' : 'text-gray-500 bg-white dark:text-gray-400 dark:bg-gray-900' }} relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium border border-gray-300 dark:border-gray-700 rounded-r-md hover:bg-gray-50 dark:hover:bg-gray-700 focus:z-10 focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500">
                        <span class="sr-only">Grid View</span>
                        <x-heroicon-o-view-grid class="w-5 h-5" />
                    </button>
                </span>
            </div>

            @if($ticketsView === 'table')
            <div class="flex-col mt-5 space-y-4">
                <div class="md:flex md:justify-between">
                    <x-bit.input.text type="text" wire:model="filters.search" placeholder="Search tickets..." />
                    <div class="flex space-x-4">
                        <x-bit.data-table.per-page />
                        @if(!$editMode)
                        <x-bit.button.round.secondary wire:click="enableEditMode">Enable In-line Editing</x-bit.button.round.secondary>
                        @else
                        <x-bit.button.round.secondary wire:click="$set('editMode', false)">Disable Editing</x-bit.button.round.secondary>
                        <x-bit.button.round.primary wire:click="save">Save Changes</x-bit.button.round.primary>
                        @endif
                    </div>
                </div>

                @if(!$editMode)
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
            @endif
        </div>
    </div>

    @include('livewire.app.orders.partials.check-modal')
    @include('livewire.app.orders.partials.invoice-modal')
    @include('livewire.app.orders.partials.ticket-modal')
</div>
