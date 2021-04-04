<div class="space-y-4">
    <x-bit.button.round.primary wire:click="save">Save</x-bit.button.round.primary>
    <h2 class="text-gray-600 dark:text-gray-400">Options</h2>

    <div class="grid grid-cols-1 gap-6 p-4 bg-gray-700 rounded-md md:grid-cols-3">
        <x-bit.input.group for="start" label="Availability Start">
            <x-bit.input.date-time class="block w-full mt-1" id="start" name="start" wire:model="formattedStart" />
        </x-bit.input.group>
        <x-bit.input.group for="end" label="Availability End">
            <x-bit.input.date-time class="block w-full mt-1" id="end" name="end" wire:model="formattedEnd" />
        </x-bit.input.group>
        <x-bit.input.group for="timezone" label="Timezone">
            <x-bit.input.select class="block w-full mt-1" wire:model="workshopForm.timezone" id="timezone">
                @foreach($timezones as $value => $label)
                <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </x-bit.input.select>
        </x-bit.input.group>
    </div>

    <h2 class="text-gray-600 dark:text-gray-400">Form</h2>

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
    <x-bit.button.round.secondary wire:click="addContent">Add Content Section</x-bit.button.round.secondary>
    <x-bit.button.round.secondary wire:click="addCollaborators">Add Collaborators</x-bit.button.round.secondary>
</div>
