<div>
    <x-bit.button.round.primary wire:click="save">Save</x-bit.button.round.primary>

    <div class="grid grid-cols-1 gap-4 py-8 md:grid-cols-2">
        <x-bit.input.group for="ticket-name" label="Ticket Name">
            <x-bit.input.text id="ticket-name" class="w-full mt-1" type="text" name="name" wire:model="ticketType.name" />
        </x-bit.input.group>
        <x-bit.input.group for="ticket-description" label="Description">
            <x-bit.input.text id="ticket-description" class="w-full mt-1" type="text" name="description" wire:model="ticketType.description" />
        </x-bit.input.group>
        <x-bit.input.group for="ticket-structure" label="Structure">
            <x-bit.input.select id="ticket-structure" class="w-full mt-1" type="text" name="structure" wire:model="ticketType.structure">
                <option value="" disabled>Select Option</option>
                <option value="flat">Flat</option>
                <option value="scaled-defined">Scaled (Defined levels)</option>
                <option value="scaled-range">Scaled (Range)</option>
            </x-bit.input.select>
        </x-bit.input.group>
        @if($ticketType->structure === 'scaled')
        <div></div>
        <x-bit.input.group for="ticket-start" label="Availability Start">
            <x-bit.input.date-time id="ticket-start" class="block w-full mt-1" name="start" wire:model="formattedStart" />
        </x-bit.input.group>
        <x-bit.input.group for="ticket-end" label="Availability End">
            <x-bit.input.date-time id="ticket-end" class="block w-full mt-1" name="end" wire:model="formattedEnd" />
        </x-bit.input.group>
        @endif
    </div>

    @if($ticketType->structure !== '')
    <div class="pt-4 space-y-6 border-t border-gray-200 dark:border-gray-900">
        <h2 class="text-xl dark:text-gray-200">Pricing</h2>

        <div class="space-y-4">
            @foreach($prices as $index => $price)
            <div wire:key="$index" class="flex items-end space-x-4">
                <x-bit.input.group :for="$index.'-prices-name'" label="Name">
                    <x-bit.input.text :id="$index.'-prices-name'" class="w-full mt-1" type="text" name="cost" wire:model="prices.{{$index}}.name" />
                </x-bit.input.group>
                @if($ticketType->structure === 'scaled-defined')
                <x-bit.input.group :for="$index.'-prices-description'" label="Description">
                    <x-bit.input.text :id="$index.'-prices-description'" class="w-full mt-1" type="text" name="cost" wire:model="prices.{{$index}}.description" />
                </x-bit.input.group>
                @endif
                @if($ticketType->structure === 'flat' || $ticketType->structure === 'scaled-defined')
                <x-bit.input.group :for="$index.'-prices-cost'" label="Cost">
                    <x-bit.input.currency :id="$index.'-prices-cost'" class="w-full mt-1" type="text" name="cost" wire:model="prices.{{$index}}.costInDollars" />
                </x-bit.input.group>
                @endif
                @if($ticketType->structure === 'flat')
                <x-bit.input.group :for="$index.'-prices-start'" label="Availability Start">
                    <x-bit.input.date-time :id="$index.'-prices-start'" class="block w-full mt-1" name="start" wire:model="prices.{{$index}}.formattedStart" />
                </x-bit.input.group>
                <x-bit.input.group :for="$index.'-prices-end'" label="Availability End">
                    <x-bit.input.date-time :id="$index.'-prices-end'" class="block w-full mt-1" name="end" wire:model="prices.{{$index}}.formattedEnd" />
                </x-bit.input.group>
                @endif
                @if($ticketType->structure === 'scaled-range')
                <x-bit.input.group :for="$index.'-prices-min'" label="Min">
                    <x-bit.input.currency :id="$index.'-prices-min'" class="w-full mt-1" type="text" name="min" wire:model="prices.{{$index}}.minInDollars" />
                </x-bit.input.group>
                <x-bit.input.group :for="$index.'-prices-max'" label="Max">
                    <x-bit.input.currency :id="$index.'-prices-max'" class="w-full mt-1" type="text" name="max" wire:model="prices.{{$index}}.maxInDollars" />
                </x-bit.input.group>
                <x-bit.input.group :for="$index.'-prices-step'" label="Step">
                    <x-bit.input.text :id="$index.'-prices-step'" class="w-full mt-1" type="number" name="step" wire:model="prices.{{$index}}.step" />
                </x-bit.input.group>
                @endif
                <x-bit.button.round.secondary wire:click="removePrice({{ $index }})"><x-heroicon-o-trash class="w-5 h-5" /></x-bit.button.round.secondary>
            </div>
            @endforeach
        </div>

        @if($ticketType->structure === 'flat' || $ticketType->structure === 'scaled-defined')
        <x-bit.button.round.secondary wire:click="addPrice">Add Price</x-bit.button.round.secondary>
        @endif
    </div>
    @endif

    @if($ticketType->structure !== '')
    <div class="pt-4 mt-8 space-y-6 border-t border-gray-200 dark:border-gray-900">
        <h2 class="text-xl dark:text-gray-200">Form</h2>

        @forelse($form as $index => $question)
        @if($question['style'] === 'question')
        @include('livewire.galaxy.events.edit.workshop-form.question')
        @elseif ($question['style'] === 'content')
        @include('livewire.galaxy.events.edit.workshop-form.content')
        @elseif ($question['style'] === 'collaborators')
        @include('livewire.galaxy.events.edit.workshop-form.collaborators')
        @endif
        @empty
        <div class="p-4 rounded-md dark:bg-gray-700">
            <p class="dark:text-gray-200">This form is empty! Get started by adding a content section or a question below.</p>
        </div>
        @endforelse

        <x-bit.button.round.secondary wire:click="addQuestion">Add Question</x-bit.button.round.secondary>
    </div>
    @endif
</div>
