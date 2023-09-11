<div class="mt-5">
    @if (!$user->hasVerifiedEmail())
    @include('livewire.galaxy.users.partials.verified-email')
    @endif

    <div class="mb-8">
        <x-bit.button.round.secondary wire:click="sendPasswordReset">
            <x-heroicon-o-paper-airplane class="w-5 h-5 mr-2 -ml-1 text-gray-400" />
            Send Password Reset
        </x-bit.button.round.secondary>
        <x-bit.button.round.secondary wire:click="impersonate">
            <x-heroicon-o-lightning-bolt class="w-5 h-5 mr-2 -ml-1 text-gray-400" />
            Impersonate
        </x-bit.button.round.secondary>
        <x-bit.button.round.secondary wire:click="$toggle('showDeleteModal')">
            <x-heroicon-o-exclamation-triangle class="w-5 h-5 mr-2 -ml-1 text-gray-400" />
            Delete User
        </x-bit.button.round.secondary>
    </div>

    <x-bit.nav.tabs :options="$pages" class="mb-8" />

    @include('livewire.galaxy.users.partials.pages')

    <form wire:submit="deleteUser">
        <x-bit.modal.confirmation wire:model="showDeleteModal">
            <x-slot name="title">Delete User</x-slot>

            <x-slot name="content">
                <div class="py-8 text-gray-700">Are you sure? This action is irreversible.</div>
            </x-slot>

            <x-slot name="footer">
                <x-bit.button.round.secondary wire:click="$set('showDeleteModal', false)">Cancel</x-bit.button.round.secondary>

                <x-bit.button.round.primary type="submit">Delete</x-bit.button.round.primary>
            </x-slot>
        </x-bit.modal.confirmation>
    </form>
</div>