<div class="space-y-2">
    <label for="question-collaborators" class="block font-medium leading-5 text-gray-700 dark:text-gray-200">Presenters</label>

    <div>
        <div class="grid grid-cols-7 gap-2 mb-2">
            <span class="block col-span-2 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Email</span>
            <span class="block col-span-2 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Name</span>
            <span class="block col-span-2 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Pronouns</span>
            <span class="block text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase dark:text-gray-300"></span>
        </div>
        <div class="space-y-1">
            @foreach ($collaborators as $index => $collaborator)
            <div wire:key="row-{{ $collaborator['id'] ?? $index }}" class="grid grid-cols-7 gap-2">
                <p class="col-span-2 m-0">{{ $collaborator['email'] }}</p>
                <p class="col-span-2 m-0">{{ $collaborator['name'] }}</p>
                <p class="col-span-2 m-0">{{ $collaborator['pronouns'] }}</p>

                <x-bit.button.round.secondary block wire:click="deleteCollaborator({{ $collaborator['id'] }})" :disabled="$response['user_id'] === $collaborator['id'] ?? $index === 0">
                    <x-heroicon-o-trash class="w-4 h-4" />
                    <span class="sr-only">Remove Presenter</span>
                </x-bit.button.round.secondary>
            </div>
            @endforeach
        </div>
    </div>

    <x-bit.button.round.secondary wire:click="$set('showCollaboratorModal', true)">Add presenter</x-bit.button.round.secondary>
</div>
