<div class="container px-4 py-12 mx-auto space-y-8 md:px-12">
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
                    <p class="text-gray-900 dark:text-gray-200">Tickets filled: {{ $filledCount }} of {{ $order->tickets->count() }}</p>
                </div>
            </div>

            <div class="p-4 space-y-2 bg-gray-100 shadow dark:bg-gray-700">
                @if(!$userIsOwner)
                <p class="text-xl font-bold text-gray-900 dark:text-gray-200"><span class="block text-sm text-gray-700 dark:text-gray-400">Confirmation Number</span> {{ $order->formattedConfirmationNumber }}</p>
                @elseif($order->isPaid())
                <p class="text-xl font-bold text-gray-900 dark:text-gray-200"><span class="block text-sm text-gray-700 dark:text-gray-400">Paid</span> {{ $order->formattedAmount }}</p>
                <p class="text-xl font-bold text-gray-900 dark:text-gray-200"><span class="block text-sm text-gray-700 dark:text-gray-400">Confirmation Number</span> {{ $order->formattedConfirmationNumber }}</p>
                @else
                <p class="text-xl font-bold text-gray-900 dark:text-gray-200"><span class="block text-sm text-gray-700 dark:text-gray-400">Payment</span> {{ $order->subtotal }}</p>
                @endif
            </div>

            @if($userIsOwner)
            <div class="grid grid-cols-1 overflow-hidden bg-gray-100 divide-y divide-gray-200 shadow dark:divide-gray-800 dark:bg-gray-700">
                @if($order->isPaid() && auth()->id() === $order->user_id)
                <a href="{{ route('app.orders.show.receipt', $order) }}" target="_blank" class="flex items-center w-full px-6 py-4 space-x-4 text-gray-900 hover:bg-gray-200 dark:hover:bg-gray-900 dark:text-gray-200">
                    <x-heroicon-o-receipt-tax class="w-6 h-6" />
                    <span>View Receipt</span>
                </a>
                @else
                <livewire:app.orders.checkout :order="$order" />
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
            @endif
        </div>
        <div class="md:col-span-2">
            <livewire:app.orders.tickets :order="$order" />
        </div>
    </div>

    @if($userIsOwner)
        @include('livewire.app.orders.partials.check-modal')
        @include('livewire.app.orders.partials.invoice-modal')
    @endif
</div>
