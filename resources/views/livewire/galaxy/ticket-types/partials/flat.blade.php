<x-bit.input.group for="cost'" label="Cost">
    <x-bit.input.currency id="cost'" class="mt-1 w-full" type="text" name="cost" wire:model.live="costInDollars" />
</x-bit.input.group>
<x-bit.input.group for="ticket-start" label="Availability Start">
    <x-bit.input.date-time id="ticket-start" class="mt-1 block w-full" name="start" wire:model.live="formattedStart" />
</x-bit.input.group>
<x-bit.input.group for="ticket-end" label="Availability End">
    <x-bit.input.date-time id="ticket-end" class="mt-1 block w-full" name="end" wire:model.live="formattedEnd" />
</x-bit.input.group>
