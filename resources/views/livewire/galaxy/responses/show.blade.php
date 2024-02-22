<div class="grid grid-cols-1 gap-8 md:grid-cols-5">
    <div class="space-y-8 md:col-span-3">
        @if ($form->type === 'finalize')
            @foreach ($qa as $question => $answer)
                <div>
                    <h2 class="mb-2 text-sm text-gray-700 dark:text-gray-400">{{ $question }}</h2>

                    @if (is_array($answer))
                        <p class="text-lg text-gray-900 dark:text-gray-200">{{ implode(', ', $answer) }}</p>
                    @else
                        <p class="text-lg text-gray-900 dark:text-gray-200">{{ $answer }}</p>
                        @if ($formResponse->parent_id)
                            <p class="mt-2 text-base text-gray-700 dark:text-gray-400">
                                <strong>Old Answer:</strong>
                                {!! nl2br($formResponse->parent->answers[$question]) !!}
                            </p>
                        @endif
                    @endif
                </div>
            @endforeach
        @else
            @foreach ($qa as $question => $answer)
                <div>
                    <h2 class="mb-2 text-sm text-gray-700 dark:text-gray-400">{{ $question }}</h2>

                    @if (is_array($answer))
                        <p class="text-lg text-gray-900 dark:text-gray-200">{{ implode(', ', $answer) }}</p>
                    @else
                        <p class="text-lg text-gray-900 dark:text-gray-200">{{ $answer }}</p>
                    @endif
                </div>
            @endforeach
        @endif
    </div>

    @if ($form->type === 'workshop')
        <div class="space-y-4 md:col-span-2">
            <livewire:bit.response-log :response="$formResponse" />

            <x-ui.card class="p-6">
                <x-form.group model="tags" type="tags" label="Tags" />
            </x-ui.card>

            @if ($form->review)
                <livewire:galaxy.responses.review :reviewForm="$form->review" :parent="$formResponse" />
            @endif
        </div>
    @endif
</div>
