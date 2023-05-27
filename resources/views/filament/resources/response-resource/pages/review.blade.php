<x-filament::page>
    <div class="grid grid-cols-3 gap-8">
        <div class="col-span-2 space-y-4">
            <x-filament::card>
                <x-forms::field-wrapper id="review-form" label="Form" statePath="form.name">
                    {{ $record->form->name }}
                </x-forms::field-wrapper> 
                <x-forms::field-wrapper id="review-type" label="Type" statePath="type">
                    {{ $record->type }}
                </x-forms::field-wrapper> 
                <x-forms::field-wrapper id="review-user-name" label="Creator" statePath="user.name">
                    {{ $record->user->name ?? $record->email ?? 'n/a' }}
                </x-forms::field-wrapper> 
                @if($record->collaborators->filter(fn ($user) => $user->id !== $record->user_id)->count() > 1)
                <x-forms::field-wrapper id="review-collaborators" label="Collaborators" statePath="collaborators">
                    {{ $record->collaborators->filter(fn ($user) => $user->id !== $record->user_id)->implode('name') }}
                </x-forms::field-wrapper>
                @endif
                @if($record->invitations->count() > 0)
                <x-forms::field-wrapper id="review-invitations" label="Invitations" statePath="invitations">
                    {{ $record->invitations->implode('email') }}
                </x-forms::field-wrapper>
                @endif
                <x-forms::field-wrapper id="review-status" label="Status" statePath="status">
                    {{ $record->status }}
                </x-forms::field-wrapper> 
            </x-filament::card>
            <x-filament::card>
                @foreach ($qa as $question => $answer)
                    <div>
                        <h2 class="mb-2 text-sm text-gray-700 dark:text-gray-400">{{ $question }}</h2>
                        @if (is_array($answer))
                            <p class="text-lg text-gray-900 dark:text-gray-200">{{ implode(', ', $answer) }}</p>
                        @elseif($answer != strip_tags($answer))
                        <div class="prose dark:prose-light">
                            {!! $answer !!}
                        </div>
                        @else
                        <p class="text-lg text-gray-900 dark:text-gray-200">{{ $answer }}</p>
                        @endif
                    </div>
                @endforeach
            </x-filament::card>
        </div>
    </div>
</x-filament::page>
