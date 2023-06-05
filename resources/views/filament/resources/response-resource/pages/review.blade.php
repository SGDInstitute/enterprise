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
                    <x-filament-support::link :href="route('filament.resources.users.edit', $record->user)">
                        {{ $record->user->name }} <span class="ml-2 text-sm italic">{{ $record->user->pronouns }}</span>
                    </x-filament-support::link>
                    @else
                    {{ $record->user->name ?? $record->email ?? 'n/a' }}
                    @endif
                </x-forms::field-wrapper>
                <x-forms::field-wrapper id="review-co-presenters" label="Co-Presenters" statePath="co-presenters">
                    @forelse ($record->collaborators->filter(fn ($user) => $user->id !== $record->user_id) as $collaborator)
                    <div>
                        <x-filament-support::link :href="route('filament.resources.users.edit', $collaborator)">
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
                    <x-filament::button type="button" x-on:click="isOpen = true">View Rubric</x-filament::button>
                </x-slot>

                <x-slot name="header">
                    Proposal Review Rubric
                </x-slot>

                @include('filament.resources.response-resource.actions.rubric')
            </x-filament::modal>

            <x-filament::card class="mt-4" heading="Filled Reviews">
                <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                    <thead>
                        <tr class="divide-x divide-gray-200 dark:divide-gray-700">
                            <th scope="col"></th>
                            <th scope="col" class="text-xs -rotate-[50deg] origin-top-left leading-none translate-y-2">Alignment</th>
                            <th scope="col" class="text-xs -rotate-[50deg] origin-top-left leading-none translate-y-2">Presenter <br>Experience</th>
                            <th scope="col" class="text-xs -rotate-[50deg] origin-top-left leading-none translate-y-2">Priority</th>
                            <th scope="col" class="text-xs -rotate-[50deg] origin-top-left leading-none translate-y-2">Track</th>
                            <th scope="col" class="text-xs -rotate-[50deg] origin-top-left leading-none translate-y-2">Score</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        @foreach ($reviews as $review)
                        <tr class="divide-x divide-gray-200 dark:divide-gray-700">
                            <td class="p-1 pl-0 text-sm font-medium text-gray-900 dark:text-gray-200 whitespace-nowrap">{{ $review->user->name }}</td>
                            <td class="p-1 text-sm text-right text-gray-500 dark:text-gray-400 whitespace-nowrap">{{ $review->alignment }}</td>
                            <td class="p-1 text-sm text-right text-gray-500 dark:text-gray-400 whitespace-nowrap">{{ $review->experience }}</td>
                            <td class="p-1 text-sm text-right text-gray-500 dark:text-gray-400 whitespace-nowrap">{{ $review->priority }}</td>
                            <td class="p-1 text-sm text-right text-gray-500 dark:text-gray-400 whitespace-nowrap">{{ $review->track }}</td>
                            <td class="p-1 text-sm text-right text-gray-500 dark:text-gray-400 whitespace-nowrap">{{ $review->score }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="divide-x divide-gray-200 dark:divide-gray-700">
                            <td class="p-1 pl-0 text-sm text-right text-gray-900 dark:text-gray-200 whitespace-nowrap">Total</td>
                            <td class="p-1 text-sm text-right text-gray-900 dark:text-gray-200 whitespace-nowrap">{{ $reviews->avg('alignment') }}</td>
                            <td class="p-1 text-sm text-right text-gray-900 dark:text-gray-200 whitespace-nowrap">{{ $reviews->avg('experience') }}</td>
                            <td class="p-1 text-sm text-right text-gray-900 dark:text-gray-200 whitespace-nowrap">{{ $reviews->avg('priority') }}</td>
                            <td class="p-1 text-sm text-right text-gray-900 dark:text-gray-200 whitespace-nowrap">{{ $reviews->avg('track') }}</td>
                            <td class="p-1 text-sm text-right text-gray-900 dark:text-gray-200 whitespace-nowrap">{{ $reviews->avg('score') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </x-filament::card>

            <x-filament::card class="mt-4" heading="Review this Proposal">
                <form wire:submit.prevent="submit">
                    {{ $this->form }}

                    <x-filament::button type="submit" class="mt-4">Save Review</x-filament::button>
                </form>
            </x-filament::card>
        </div>
    </div>
</x-filament::page>