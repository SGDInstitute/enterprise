<div>
    {{ $this->table }}

    <div
        class="mt-8 bg-gray-50 px-4 py-6 shadow dark:border dark:border-gray-700 dark:bg-gray-800 sm:p-6 lg:ml-auto lg:w-2/3 lg:p-8"
    >
        <dl class="space-y-4">
            <div class="flex items-center justify-between">
                <dt class="text-lg font-medium text-gray-900 dark:text-gray-200">Order total</dt>
                <dd class="text-lg font-medium text-gray-900 dark:text-gray-200">{{ $order->formattedAmount }}</dd>
                <div wire:loading class="ml-4">
                    <x-heroicon-o-cog class="h-8 w-8 animate-spin text-gray-400" />
                </div>
            </div>
        </dl>

        <div class="mt-6 space-y-3">
            @if ($order->isReservation())
                <x-bit.button.round.primary href="{{ route('app.orders.show', [$order, 'payment']) }}" block size="lg">
                    Pay now
                </x-bit.button.round.primary>
                <div>
                    <p class="text-gray-700 dark:text-gray-400">
                        Your order is not complete until payment is received.
                    </p>
                    <p class="text-gray-700 dark:text-gray-400">
                        By clicking "Pay now" you agree to the policies listed
                        <span class="hidden lg:inline">to the left</span>
                        <span class="lg:hidden">above</span>
                        .
                    </p>
                </div>
            @endif

            <div class="space-x-1">
                <x-filament::button
                    :href="route('app.orders.show', [$order, 'payment'])"
                    tag="a"
                    size="sm"
                    icon="heroicon-o-arrow-down-tray"
                    outlined
                >
                    Download Invoice
                </x-filament::button>
                <x-filament::button wire:click="downloadW9" size="sm" icon="heroicon-o-arrow-down-tray" outlined>
                    Download W9
                </x-filament::button>
            </div>
        </div>
    </div>
</div>
