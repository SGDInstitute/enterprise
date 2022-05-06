<div></div>
<x-bit.input.group for="ticket-start" label="Availability Start">
    <x-bit.input.date-time id="ticket-start" class="block w-full mt-1" name="start" wire:model="formattedStart" />
</x-bit.input.group>
<x-bit.input.group for="ticket-end" label="Availability End">
    <x-bit.input.date-time id="ticket-end" class="block w-full mt-1" name="end" wire:model="formattedEnd" />
</x-bit.input.group>

@if (count($prices) > 0))
    <div class="pt-4 space-y-6 border-t border-gray-200 dark:border-gray-900">
        <h2 class="text-xl dark:text-gray-200">Pricing</h2>

        <div class="space-y-4">
            @foreach ($prices as $index => $price)
            <div wire:key="$index" class="flex items-end space-x-4">
                <x-bit.input.group :for="$index.'-prices-name'" label="Name">
                    <x-bit.input.text :id="$index.'-prices-name'" class="w-full mt-1" type="text" name="cost" wire:model="prices.{{ $index }}.name" />
                </x-bit.input.group>
                <x-bit.input.group :for="$index.'-prices-description'" label="Description">
                    <x-bit.input.text :id="$index.'-prices-description'" class="w-full mt-1" type="text" name="cost" wire:model="prices.{{ $index }}.description" />
                </x-bit.input.group>
                <x-bit.input.group :for="$index.'-prices-cost'" label="Cost">
                    <x-bit.input.currency :id="$index.'-prices-cost'" class="w-full mt-1" type="text" name="cost" wire:model="prices.{{ $index }}.costInDollars" />
                </x-bit.input.group>

                <x-bit.button.round.secondary wire:click="removePrice({{ $index }})"><x-heroicon-o-trash class="w-5 h-5" /></x-bit.button.round.secondary>
            </div>
            @endforeach
        </div>

        <x-bit.button.round.secondary wire:click="addPrice">Add Price</x-bit.button.round.secondary>
    </div>
@endif
