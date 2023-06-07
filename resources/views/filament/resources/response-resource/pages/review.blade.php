<x-filament::page>
    <div class="grid grid-cols-5 gap-8">
        <div class="col-span-3 space-y-4">
            <x-filament::card>
                <x-forms::field-wrapper id="review-form" label="Form" statePath="form.name">
                    {{ $record->form->name }}
                </x-forms::field-wrapper>
                <x-forms::field-wrapper id="review-type" label="Type" statePath="type">
                    {{ $record->type }}
                </x-forms::field-wrapper>
                <x-forms::field-wrapper id="review-user-name" label="Creator" statePath="user.name">
                    @isset($record->user)
                    <x-filament-support::link darkMode="true" :href="route('filament.resources.users.edit', $record->user)">
                        {{ $record->user->name }} <span class="ml-2 text-sm italic">{{ $record->user->pronouns }}</span>
                    </x-filament-support::link>
                    @else
                    {{ $record->user->name ?? $record->email ?? 'n/a' }}
                    @endif
                </x-forms::field-wrapper>
                <x-forms::field-wrapper id="review-co-presenters" label="Co-Presenters" statePath="co-presenters">
                    @forelse ($record->collaborators->filter(fn ($user) => $user->id !== $record->user_id) as $collaborator)
                    <div>
                        <x-filament-support::link darkMode="true" :href="route('filament.resources.users.edit', $collaborator)">
                            {{ $collaborator->name }} <span class="ml-2 text-sm italic">{{ $collaborator->pronouns }}</span>
                        </x-filament-support::link>
                    </div>
                    @empty
                    no co-presenters
                    @endforelse
                </x-forms::field-wrapper>
                <x-forms::field-wrapper id="review-invitations" label="Invitations" statePath="invitations">
                    @php
                    $emails = $record->invitations->implode('email', ', ');
                    @endphp

                    {{ $emails === '' ? 'no pending invitations' : $emails }}
                </x-forms::field-wrapper>
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
                    @elseif ($answer != strip_tags($answer))
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
        <div class="col-span-2">
            <x-filament::modal width="6xl">
                <x-slot name="trigger">
                    <x-filament::button color="secondary" type="button" x-on:click="isOpen = true">View Rubric</x-filament::button>
                </x-slot>

                <x-slot name="header">
                    Proposal Review Rubric
                </x-slot>

                @include('filament.resources.response-resource.actions.rubric')
            </x-filament::modal>

            <x-filament::modal width="6xl">
                <x-slot name="trigger">
                    <x-filament::button color="secondary" type="button" x-on:click="isOpen = true">View Tracks</x-filament::button>
                </x-slot>

                <x-slot name="header">
                    Workshop Tracks
                </x-slot>

                @include('filament.resources.response-resource.actions.tracks')
            </x-filament::modal>

            <x-filament::modal width="4xl">
                <x-slot name="trigger">
                    <x-filament::button color="secondary" type="button" x-on:click="isOpen = true">View Scores & Notes</x-filament::button>
                </x-slot>

                <x-slot name="header">
                    Scores & Notes from Reviews
                </x-slot>

                <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                    @include('filament.resources.response-resource.actions.scores')
                    @include('filament.resources.response-resource.actions.notes')
                </div>
            </x-filament::modal>

            <x-filament::card class="mt-4" heading="Review this Proposal">
                <form wire:submit.prevent="submit">
                    {{ $this->form }}

                    <x-filament::button type="submit" class="mt-4">Save Review</x-filament::button>
                </form>
            </x-filament::card>
        </div>
    </div>
</x-filament::page>