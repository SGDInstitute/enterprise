<div class="space-y-4">
    <div>
        <x-bit.button.round.primary wire:click="save">Save</x-bit.button.round.primary>
        <x-bit.button.round.secondary target="_blank" :href="$workshopForm->previewUrl">Preview</x-bit.button.round.secondary>
    </div>

    @include('livewire.galaxy.events.edit.workshop-form.information')

    @include('livewire.galaxy.events.edit.workshop-form.form')

    @include('livewire.galaxy.events.edit.workshop-form.rubric')
</div>
