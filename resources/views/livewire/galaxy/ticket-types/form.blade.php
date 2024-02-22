<div>
    <x-bit.button.round.primary wire:click="save">Save</x-bit.button.round.primary>

    <div class="grid grid-cols-1 gap-4 py-8 md:grid-cols-2">
        <x-bit.input.group for="ticket-name" label="Ticket Name">
            <x-bit.input.text
                id="ticket-name"
                class="mt-1 w-full"
                type="text"
                name="name"
                wire:model.live="ticketType.name"
            />
        </x-bit.input.group>
        <x-bit.input.group for="ticket-description" label="Description">
            <x-bit.input.text
                id="ticket-description"
                class="mt-1 w-full"
                type="text"
                name="description"
                wire:model.live="ticketType.description"
            />
        </x-bit.input.group>
        <x-bit.input.group for="ticket-structure" label="Structure">
            <x-bit.input.select
                id="ticket-structure"
                class="mt-1 w-full"
                type="text"
                name="structure"
                wire:model.live="ticketType.structure"
            >
                <option value="" disabled>Select Option</option>
                <option value="flat">Flat</option>
                <option value="scaled-defined">Scaled (Defined levels)</option>
                <option value="scaled-range">Scaled (Range)</option>
            </x-bit.input.select>
        </x-bit.input.group>

        @if ($ticketType->structure !== '')
            @includeWhen($ticketType->structure === 'flat', 'livewire.galaxy.ticket-types.partials.flat')
            @includeWhen($ticketType->structure === 'scaled-range', 'livewire.galaxy.ticket-types.partials.scaled-range')

            <div class="col-span-2">
                @include('livewire.galaxy.ticket-types.partials.extra-questions')
            </div>
        @endif
    </div>
</div>
