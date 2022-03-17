<div>
    <div class="mb-4 border-b border-gray-200 dark:border-gray-600">
        <p class="px-1 py-4 text-sm font-medium text-gray-500 border-b-2 border-transparent dark:text-gray-400 whitespace-nowrap">
            Ticket Types
        </p>
    </div>
    <div class="space-y-4">
        @foreach ($ticketTypes as $index => $ticket)
            @if ($ticket->structure === 'flat')
            <div class="p-4 space-y-2 bg-gray-100 dark:bg-gray-700">
                <div class="flex justify-between">
                    <p class="text-2xl dark:text-gray-200">$<span class="pl-1">{{ $form[$index]['cost'] }}</span></p>
                    <x-bit.input.group :for="'ticket-amount'.$index" label="Number of Tickets" sr-only>
                        <x-bit.input.text class="w-20" min="0" type="number" :disabled="$order !== null" wire:model.lazy="form.{{ $index }}.amount" />
                    </x-bit.input.group>
                </div>
                <div>
                    <h2 class="dark:text-gray-200">{{ $ticket->name }} - {{ $form[$index]['name'] }}</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $ticket->description }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $ticket->availablity }}</p>
                </div>
            </div>
            @elseif ($ticket->structure === 'scaled-range')
            <div class="p-4 space-y-2 bg-gray-100 dark:bg-gray-700">
                <div class="flex justify-between">
                    <x-bit.input.group :for="'ticket-cost'.$index" label="Number of Tickets" sr-only>
                        <span class="text-2xl dark:text-gray-200">$</span>
                        <select class="w-20 p-0 pl-1 text-2xl bg-transparent border-none rounded dark:text-gray-200 focus:ring-green-500 focus:border-green-500 {{ $order !== null ? 'opacity-75 cursor-not-allowed' : '' }}" {{ $order !== null ? 'disabled' : '' }} wire:model.lazy="form.{{ $index }}.price_id">
                            @foreach ($form[$index]['options'] as $priceId => $option)
                                <option value="{{ $priceId }}">{{ $option }}</option>
                            @endforeach
                        </select>
                    </x-bit.input.group>
                    <x-bit.input.group :for="'ticket-amount'.$index" label="Number of Tickets" sr-only>
                        <x-bit.input.text class="w-20" min="0" type="number" wire:model.lazy="form.{{ $index }}.amount" :disabled="$order !== null" />
                    </x-bit.input.group>
                </div>
                <h2 class="dark:text-gray-200">{{ $ticket->name }} - {{ $form[$index]['name'] }}</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $ticket->description }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $ticket->availablity }}</p>
            </div>
            @endif
        @endforeach

        @if ($errors->any())
            <div class="px-4 py-2 text-gray-200 bg-red-500 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex items-center justify-between">
        <p class="text-xl dark:text-gray-200">Subtotal <span class="ml-4 text-3xl">{{ $checkoutAmount }}</span></p>
            <div wire:loading.delay class="ml-4">
                <x-heroicon-o-cog class="w-8 h-8 text-gray-400 animate-spin" />
            </div>
        </div>

        <p class="text-sm text-gray-600 dark:text-gray-400">By clicking Next you accept the refund policy and photo policy.</p>

        @guest
        <div class="px-4 py-2 text-gray-200 bg-red-500 rounded">
            <p>Please create an account or log in before starting an order.</p>
        </div>
        @endguest

        @if ($event->settings->reservations)
        <div class="flex">
            <x-bit.button.flat.secondary class="justify-center flex-1 border-r-0" size="large" wire:click="reserve" :disabled="auth()->guest()">Reserve & Pay Later</x-bit.button.flat.secondary>
            <x-bit.button.flat.secondary-filled size="large" class="-ml-px">
                <x-heroicon-o-information-circle class="w-7 h-7" />
                <span class="sr-only">Information about Reserving tickets</span>
            </x-bit.button.flat.secondary>
        </div>
        @endif

        <div class="flex">
            @if ($order !== null && $checkoutButton !== null)
                {!! $checkoutButton->button('Go to Checkout', ['class' => 'space-x-2 justify-center flex-1 inline-flex items-center uppercase font-bold px-4 py-2 text-lg border-4 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 text-green-500 dark:text-green-400 border-green-500 dark:border-green-400 hover:bg-green-500 dark:hover:bg-green-400 hover:text-white' ]) !!}
            @else
            <x-bit.button.flat.primary wire:click="pay" class="justify-center flex-1 border-r-0" size="large" :disabled="auth()->guest()">Pay with Card</x-bit.button.flat.primary>
            <x-bit.button.flat.primary-filled size="large" class="-ml-px">
                <x-heroicon-o-information-circle class="w-7 h-7" />
                <span class="sr-only">Information about Paying with a credit card</span>
            </x-bit.button.flat.primary-filled>
            @endif
        </div>
    </div>
</div>
