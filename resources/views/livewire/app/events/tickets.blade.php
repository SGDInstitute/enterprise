<div>
    <div class="mb-4 border-b border-gray-200 dark:border-gray-600">
        <p class="px-1 py-4 text-sm font-medium text-gray-500 border-b-2 border-transparent dark:text-gray-400 whitespace-nowrap">
            Ticket Types
        </p>
    </div>
    <div class="space-y-4">
        @foreach($tickets as $index => $ticket)
        <div class="p-4 space-y-2 bg-gray-100 dark:bg-gray-700">
            <div class="flex justify-between">
                <p class="text-2xl dark:text-gray-200">{{ $ticket->formattedCost }}</p>
                <x-bit.input.text class="w-20" min="0" type="number" wire:model.lazy="tickets.{{ $index }}.amount" />
            </div>
            <h2 class="dark:text-gray-200">{{ $ticket->name }}</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $ticket->description }}</p>
        </div>
        @endforeach

        <p class="text-xl dark:text-gray-200">Subtotal <span class="text-3xl">{{ $formattedAmount }}</span></p>

        <p class="text-sm text-gray-600 dark:text-gray-400">By clicking Next you accept the refund policy and photo policy.</p>

        @guest
        <p class="text-sm text-gray-600 dark:text-gray-400">Please create an account or log in before starting an order.</p>
        @endguest

        @if($event->settings->reservations)
        <div class="flex">
            <x-bit.button.secondary class="justify-center flex-1 border-r-0" size="large">Reserve & Pay Later</x-bit.button.secondary>
            <x-bit.button.secondary-filled size="large" class="-ml-px">
                <x-heroicon-o-information-circle class="w-7 h-7" />
                <span class="sr-only">Information about Reserving tickets</span>
            </x-bit.button.secondary>
        </div>
        @endif

        <div class="flex">
            <x-bit.button.primary class="justify-center flex-1 border-r-0" size="large">Pay with Card</x-bit.button.primary>
            <x-bit.button.primary-filled size="large" class="-ml-px">
                <x-heroicon-o-information-circle class="w-7 h-7" />
                <span class="sr-only">Information about Paying with a credit card</span>
            </x-bit.button.primary-filled>
        </div>
    </div>
</div>
