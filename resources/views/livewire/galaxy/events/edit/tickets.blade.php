<form wire:submit.prevent="save">
    <x-bit.panel>
        <x-bit.panel.body class="divide-y divide-gray-600">
            @foreach($ticketTypes as $index => $ticket)
            <div class="grid grid-cols-1 gap-4 py-8 md:grid-cols-2">
                <x-bit.input.group for="ticket{{ $index }}name" label="Ticket Name">
                    <x-bit.input.text id="ticket{{ $index }}name" class="w-full mt-1" type="text" name="name" wire:model="ticketTypes.{{ $index }}.name" />
                </x-bit.input.group>
                <x-bit.input.group for="ticket{{ $index }}description" label="Description">
                    <x-bit.input.text id="ticket{{ $index }}description" class="w-full mt-1" type="text" name="description" wire:model="ticketTypes.{{ $index }}.description" />
                </x-bit.input.group>
                <x-bit.input.group for="ticket{{ $index }}type" label="Type">
                    <x-bit.input.select id="ticket{{ $index }}type" class="w-full mt-1" name="type" wire:model="ticketTypes.{{ $index }}.type">
                        <option value="">Select preset</option>
                        <option value="regular">Regular</option>
                        <option value="discount">Discount</option>
                    </x-bit.input.select>
                </x-bit.input.group>
                <x-bit.input.group for="ticket{{ $index }}cost" label="Cost">
                    <x-bit.input.currency id="ticket{{ $index }}cost" class="w-full mt-1" type="text" name="cost" wire:model="ticketTypes.{{ $index }}.cost" />
                </x-bit.input.group>
                <x-bit.input.group for="start" label="Availability Start">
                    <x-bit.input.date-time class="block w-full mt-1" id="start" name="start" wire:model="ticketTypes.{{ $index }}.start" />
                </x-bit.input.group>
                <x-bit.input.group for="end" label="Availability End">
                    <x-bit.input.date-time class="block w-full mt-1" id="end" name="end" wire:model="ticketTypes.{{ $index }}.end" />
                </x-bit.input.group>
                <x-bit.input.group for="ticket{{ $index }}num_tickets" label="Number of Tickets">
                    <x-bit.input.text id="ticket{{ $index }}num_tickets" class="w-full mt-1" type="text" name="num_tickets" wire:model="ticketTypes.{{ $index }}.num_tickets" />
                </x-bit.input.group>
                <div class="flex items-end justify-end">
                    <x-bit.button.secondary wire:click="remove({{ $index }})">
                        <x-heroicon-s-trash class="w-5 h-5"/>
                        <span class="sr-only">Remove</span>
                    </x-bit.button.secondary>
                </div>
            </div>
            @endforeach
            <x-bit.button.secondary wire:click="add">Add</x-bit.button.secondary>
        </x-bit.panel.body>
        <x-bit.panel.footer>
            @if($formChanged)
            <x-bit.button.primary type="submit">Save</x-bit.button.primary>
            <x-bit.badge color="indigo" class="ml-4">
                Unsaved Changes
            </x-bit.badge>
            @else
            <x-bit.button.primary type="submit" disabled>Save</x-bit.button.primary>
            @endif
        </x-bit.panel.footer>
    </x-bit.panel>
</form>
