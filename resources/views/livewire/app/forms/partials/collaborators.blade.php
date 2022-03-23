<div class="space-y-2">
    <label for="question-collaborators" class="block font-medium leading-5 text-gray-700 dark:text-gray-200">Presenters</label>

    <div>
        <div class="grid grid-cols-3 gap-2 mb-2">
            <span class="block text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Email</span>
            <span class="block text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Name</span>
            <span class="block text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Pronouns</span>
        </div>
        <div class="space-y-1">
            @foreach ($collaborators as $index => $collaborator)
            <div wire:key="row-{{ $collaborator['id'] }}" class="grid grid-cols-3 gap-2">
                <x-bit.input.group :for="'presenter-email-'.$index" label="Email for presenter {{ $index + 1 }}" sr-only>
                    <x-bit.input.text class="w-full" :id="'presenter-email-'.$index" placeholder="Email" type="email" wire:model.lazy="collaborators.{{ $index }}.email" />
                </x-bit.input.group>

                <x-bit.input.group :for="'presenter-name-'.$index" label="Name for presenter {{ $index + 1 }}" sr-only>
                    <x-bit.input.text class="w-full" placeholder="Name" type="text" wire:model="collaborators.{{ $index }}.name" />
                </x-bit.input.group>

                <x-bit.input.group :for="'presenter-pronouns-'.$index" label="Pronouns for presenter {{ $index + 1 }}" sr-only>
                    <x-bit.input.text class="w-full" placeholder="Pronouns" type="text" wire:model="collaborators.{{ $index }}.pronouns" />
                </x-bit.input.group>
            </div>
            @endforeach
        </div>
    </div>

    <x-bit.button.round.secondary wire:click="addCollaborator">Add presenter</x-bit.button.round.secondary>
</div>
