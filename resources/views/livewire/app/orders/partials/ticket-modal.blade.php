<form wire:submit="saveTicket">
    <x-bit.modal.dialog wire:model="showTicketholderModal" max-width="lg">
        <x-slot name="title">
            {{ $editingTicket->user_id !== null ? 'Edit' : 'Add' }} Ticketholder
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                @if ($editingTicket->user_id === null || $editingTicket->id === auth()->id())
                <x-bit.button.round.secondary size="xs" wire:click="loadAuthUser">Load My Information</x-bit.button.round.secondary>
                @endif
                <x-bit.input.group for="ticketholder-email" label="Email">
                    <x-bit.input.text class="w-full mt-1" type="email" id="ticketholder-email" wire:model.blur="ticketholder.email" />
                </x-bit.input.group>
                @if ($emailChanged)
                <div>
                    <p class="dark:text-gray-200">Looks like the email changed, did you want to fix a typo or invite someone else?</p>

                    <button wire:click="$set('updateEmail', true)" type="button" class="{{ $updateEmail === true ? 'bg-green-500' : 'bg-transparent' }} inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-gray-700 dark:text-gray-200 hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Fix a typo</button>
                    <button wire:click="$set('updateEmail', false)" type="button" class="{{ $updateEmail === false ? 'bg-green-500' : 'bg-transparent' }} inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-gray-700 dark:text-gray-200 hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Invite someone else</button>
                </div>
                @endif
                <x-bit.input.group for="ticketholder-name" label="Name">
                    <x-bit.input.text class="w-full mt-1" type="text" id="ticketholder-name" wire:model.live="ticketholder.name" />
                </x-bit.input.group>
                <x-bit.input.group for="ticketholder-pronouns" label="Pronouns">
                    <x-bit.input.text class="w-full mt-1" type="text" id="ticketholder-pronouns" wire:model.live="ticketholder.pronouns" />
                </x-bit.input.group>

                @if ($editingTicket !== null && $editingTicket->ticketType->form)
                    @foreach ($editingTicket->ticketType->form as $item)
                        @include('livewire.app.forms.partials.' . $item['style'])
                    @endforeach
                @endif
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="space-x-2">
                <x-bit.button.flat.secondary wire:click="$set('showTicketholderModal', false)">Cancel</x-bit.button.flat.secondary>

                @if ($editingTicket->user_id !== null)
                <x-bit.button.flat.primary type="submit" wire:click="$set('continue', false)">Save</x-bit.button.flat.primary>
                @else
                <x-bit.button.flat.primary type="submit" wire:click="$set('continue', false)">Add</x-bit.button.flat.primary>
                <x-bit.button.flat.primary type="submit" wire:click="$set('continue', true)">Add & Add Another</x-bit.button.flat.primary>
                @endif
            </div>
        </x-slot>
    </x-bit.modal.dialog>
</form>
