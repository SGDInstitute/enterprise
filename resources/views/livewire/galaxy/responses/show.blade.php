<div class="grid grid-cols-1 gap-8 md:grid-cols-5">
    <div class="space-y-8 md:col-span-3">
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
    </div>

    <div class="space-y-4 md:col-span-2">
        <livewire:bit.response-log :response="$formResponse" />

        <x-ui.card class="p-6">
            <x-form.group model="tags" type="tags" label="Tags"/>
        </x-ui.card>

        @if ($form->review)
        <livewire:galaxy.responses.review :reviewForm="$form->review" :parent="$formResponse" />
        @endif
    </div>
</div>
