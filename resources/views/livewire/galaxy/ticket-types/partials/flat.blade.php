<x-bit.input.group for="cost'" label="Cost">
    <x-bit.input.currency id="cost'" class="w-full mt-1" type="text" name="cost" wire:model="costInDollars" />
</x-bit.input.group>
<x-bit.input.group for="ticket-start" label="Availability Start">
    <x-bit.input.date-time id="ticket-start" class="block w-full mt-1" name="start" wire:model="formattedStart" />
</x-bit.input.group>
<x-bit.input.group for="ticket-end" label="Availability End">
    <x-bit.input.date-time id="ticket-end" class="block w-full mt-1" name="end" wire:model="formattedEnd" />
</x-bit.input.group>
