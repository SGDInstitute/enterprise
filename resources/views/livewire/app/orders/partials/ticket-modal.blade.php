<form wire:submit.prevent="{{ $editingTicket ? 'editUser' : 'addUser' }}">
    <x-bit.modal.dialog wire:model.defer="showTicketholderModal" max-width="lg">
        <x-slot name="title">
            {{ $editingTicket ? 'Edit' : 'Add' }} Ticketholder
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                @if($editingTicket === null || $editingTicket->id === auth()->id())
                <x-bit.button.round.secondary size="xs" wire:click="loadAuthUser">Load My Information</x-bit.button.round.secondary>
                @endif
                <x-bit.input.group for="ticketholder-email" label="Email">
                    <x-bit.input.text class="w-full mt-1" type="email" id="ticketholder-email" wire:model.lazy="ticketholder.email" />
                </x-bit.input.group>
                <x-bit.input.group for="ticketholder-name" label="Name">
                    <x-bit.input.text class="w-full mt-1" type="text" id="ticketholder-name" wire:model="ticketholder.name" />
                </x-bit.input.group>
                <x-bit.input.group for="ticketholder-pronouns" label="Pronouns">
                    <x-bit.input.text class="w-full mt-1" type="text" id="ticketholder-pronouns" wire:model="ticketholder.pronouns" />
                </x-bit.input.group>
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="space-x-2">
                <x-bit.button.flat.secondary wire:click="$set('showTicketholderModal', false)">Cancel</x-bit.button.flat.secondary>

                @if($editingTicket)
                <x-bit.button.flat.primary type="submit" wire:click="$set('continue', false)">Save</x-bit.button.flat.primary>
                @else
                <x-bit.button.flat.primary type="submit" wire:click="$set('continue', false)">Add</x-bit.button.flat.primary>
                <x-bit.button.flat.primary type="submit" wire:click="$set('continue', true)">Add & Add Another</x-bit.button.flat.primary>
                @endif
            </div>
        </x-slot>
    </x-bit.modal.dialog>
</form>
