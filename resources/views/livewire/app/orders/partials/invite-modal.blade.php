<form wire:submit="inviteAttendee">
    <x-bit.modal.dialog wire:model="showInviteModal" max-width="lg">
        <x-slot name="title">
            Invite Attendee
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                @if ($editingTicket->user_id === null || $editingTicket->id === auth()->id())
                <x-bit.button.round.secondary size="xs" wire:click="loadAuthUser">Load My Information</x-bit.button.round.secondary>
                @endif
                <x-form.group type="email" model="invite.email" label="Email" />
                <x-form.group type="email" model="invite.email_confirmation" label="Confirm Email" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="space-x-2">
                <x-bit.button.flat.secondary wire:click="$set('showInviteModal', false)">Cancel</x-bit.button.flat.secondary>

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
