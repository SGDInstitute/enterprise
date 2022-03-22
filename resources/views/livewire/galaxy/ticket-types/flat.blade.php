<div>
    <x-bit.panel class="md:w-1/2">
        <form wire:submit.prevent="save">
            <x-bit.panel.body>
                <div class="grid grid-cols-1 gap-4 mb-4">
                    <x-bit.input.group for="ticket-name" label="Ticket Name">
                        <x-bit.input.text id="ticket-name" class="w-full" type="text" name="name" wire:model="ticketType.name" />
                    </x-bit.input.group>
                    <x-bit.input.group for="cost'" label="Cost">
                        <x-bit.input.currency id="cost'" class="w-full" type="text" name="cost" wire:model="ticketType.costInDollars" />
                    </x-bit.input.group>
                    <x-bit.input.group for="ticket-start" label="Availability Start">
                        <x-bit.input.date-time id="ticket-start" class="block w-full" name="start" wire:model="ticketType.formattedStart" />
                    </x-bit.input.group>
                    <x-bit.input.group for="ticket-end" label="Availability End">
                        <x-bit.input.date-time id="ticket-end" class="block w-full" name="end" wire:model="ticketType.formattedEnd" />
                    </x-bit.input.group>
                </div>
                <x-bit.button.round.primary type="submit">Save</x-bit.button.round.primary>
            </x-bit.panel.body>
        </form>
    </x-bit.panel>
</div>
