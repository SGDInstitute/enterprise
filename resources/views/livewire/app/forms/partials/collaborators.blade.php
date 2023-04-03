<div>
    <div class="space-y-2">
        <label for="question-collaborators" class="block font-medium leading-5 text-gray-700 dark:text-gray-200">Presenters</label>

        <table>
            <thead>
                <tr>
                    <th class="text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Email</th>
                    <th class="text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Name</th>
                    <th class="text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Pronouns</th>
                    <th class="text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase dark:text-gray-300"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($collaborators as $index => $collaborator)
                <tr wire:key="row-{{ $collaborator['id'] ?? $index }}">
                    <td>{{ $collaborator['email'] }}</td>
                    <td>{{ $collaborator['name'] }}</td>
                    <td>{{ $collaborator['pronouns'] }}</td>
                    <td>
                        <x-bit.button.round.secondary block wire:click="deleteCollaborator({{ $collaborator['id'] }})" :disabled="!$fillable || $response['user_id'] === $collaborator['id']">
                            <x-heroicon-o-trash class="w-4 h-4" />
                            <span class="sr-only">Remove Presenter</span>
                        </x-bit.button.round.secondary>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <x-bit.button.round.secondary wire:click="$set('showCollaboratorModal', true)" :disabled="!$fillable">Add presenter</x-bit.button.round.secondary>
    </div>
    <div class="space-y-2">
        @if ($invitations && $invitations->isNotEmpty())
        <label for="question-invitations" class="block font-medium leading-5 text-gray-700 dark:text-gray-200 mt-6">Invitations</label>

        <table>
            <thead>
                <tr>
                    <th class="text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Email</th>
                    <th class="text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase dark:text-gray-300"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invitations as $index => $invitation)
                <tr wire:key="row-{{ $invitation['id'] ?? $index }}">
                    <td>{{ $invitation['email'] }}</td>
                    <td>
                        <x-bit.button.round.secondary block wire:click="deleteInvitation({{ $invitation['id'] }})" :disabled="!$fillable">
                            <x-heroicon-o-trash class="w-4 h-4" />
                            <span class="sr-only">Remove Invite</span>
                        </x-bit.button.round.secondary>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
