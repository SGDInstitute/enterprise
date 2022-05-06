<div></div>
<x-bit.input.group for="ticket-start" label="Availability Start">
    <x-bit.input.date-time id="ticket-start" class="block w-full mt-1" name="start" wire:model="formattedStart" />
</x-bit.input.group>
<x-bit.input.group for="ticket-end" label="Availability End">
    <x-bit.input.date-time id="ticket-end" class="block w-full mt-1" name="end" wire:model="formattedEnd" />
</x-bit.input.group>

@if ($ticketType->prices->count() === 0)
    <div class="col-span-2">
        <h2 class="mb-2 text-lg dark:text-gray-200">Generate Prices</h2>
        <p class="mb-4 text-sm dark:text-gray-300">We need to create a price for each step in the range. Instead of making you add each price individually, Enterprise will do it for you when saving the ticket type.</p>
        <div class="flex items-end space-x-4">
            <x-bit.input.group for="generate-prices-name" label="Name">
                <x-bit.input.text id="generate-prices-name" class="w-full mt-1" type="text" name="cost" wire:model="prices.0.name" />
            </x-bit.input.group>
            <x-bit.input.group for="generate-prices-min" label="Min">
                <x-bit.input.currency id="generate-prices-min" class="w-full mt-1" type="text" name="min" wire:model="prices.0.minInDollars" />
            </x-bit.input.group>
            <x-bit.input.group for="generate-prices-max" label="Max">
                <x-bit.input.currency id="generate-prices-max" class="w-full mt-1" type="text" name="max" wire:model="prices.0.maxInDollars" />
            </x-bit.input.group>
            <x-bit.input.group for="generate-prices-step" label="Step">
                <x-bit.input.text id="generate-prices-step" class="w-full mt-1" type="number" name="step" wire:model="prices.0.step" />
            </x-bit.input.group>
        </div>
    </div>
@endif

@if (count($prices) > 0))
    <div class="pt-4 space-y-6 border-t border-gray-200 dark:border-gray-900">
        <h2 class="text-xl dark:text-gray-200">Pricing</h2>

        <div class="space-y-4">
            @foreach ($prices as $index => $price)
            <div wire:key="$index" class="flex items-end space-x-4">
                <x-bit.input.group :for="$index.'-prices-name'" label="Name">
                    <x-bit.input.text :id="$index.'-prices-name'" class="w-full mt-1" type="text" name="cost" wire:model="prices.{{ $index }}.name" />
                </x-bit.input.group>
                @if ($ticketType->structure === 'scaled-defined')
                <x-bit.input.group :for="$index.'-prices-description'" label="Description">
                    <x-bit.input.text :id="$index.'-prices-description'" class="w-full mt-1" type="text" name="cost" wire:model="prices.{{ $index }}.description" />
                </x-bit.input.group>
                @endif
                <x-bit.input.group :for="$index.'-prices-cost'" label="Cost">
                    <x-bit.input.currency :id="$index.'-prices-cost'" class="w-full mt-1" type="text" name="cost" wire:model="prices.{{ $index }}.costInDollars" />
                </x-bit.input.group>
                @if ($ticketType->structure === 'flat')
                <x-bit.input.group :for="$index.'-prices-start'" label="Availability Start">
                    <x-bit.input.date-time :id="$index.'-prices-start'" class="block w-full mt-1" name="start" wire:model="prices.{{ $index }}.formattedStart" />
                </x-bit.input.group>
                <x-bit.input.group :for="$index.'-prices-end'" label="Availability End">
                    <x-bit.input.date-time :id="$index.'-prices-end'" class="block w-full mt-1" name="end" wire:model="prices.{{ $index }}.formattedEnd" />
                </x-bit.input.group>
                @endif

                <x-bit.button.round.secondary wire:click="removePrice({{ $index }})"><x-heroicon-o-trash class="w-5 h-5" /></x-bit.button.round.secondary>
            </div>
            @endforeach
        </div>

        <x-bit.button.round.secondary wire:click="addPrice">Add Price</x-bit.button.round.secondary>
    </div>
@endif
