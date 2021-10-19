<div>
    <div class="grid grid-cols-1 gap-8 md:grid-cols-4">
        <x-bit.stat title="Total Number of Responses" :value="$numberOfResponses" />
        @if($numberOfResponses > $numberOfUniqueResponses)
        <x-bit.stat title="Total - Likely Duplicates" subtitle="only unique answers are shown" :value="$numberOfUniqueResponses"/>
        @endif
    </div>

    <div class="mt-8 space-y-12">
        @foreach($responsesByQuestion as $qa)
        <div class="space-y-4">
            <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-300">{{ $qa['question']['question'] }}</h3>

            @if($qa['question']['type'] === 'list')
            <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                <div class="col-span-2">
                    <x-bit.table>
                        <x-slot name="head">
                            <x-bit.table.heading>Option</x-bit.table.heading>
                            <x-bit.table.heading># Chosen</x-bit.table.heading>
                        </x-slot>
                        <x-slot name="body">
                            @foreach($qa['question']['options'] as $option)
                            <x-bit.table.row wire:key="row-{{ $option }}">
                                <x-bit.table.cell>{{ $option }}</x-bit.table.cell>
                                <x-bit.table.cell>{{ $qa['answers'][$option] ?? 0 }}</x-bit.table.cell>
                            </x-bit.table.row>
                            @endforeach
                            @if(isset($qa['question']['list-other']) && $qa['question']['list-other'])
                            <x-bit.table.row wire:key="row-other">
                                <x-bit.table.cell>Other</x-bit.table.cell>
                                <x-bit.table.cell>{{ $qa['answers']['other'] ?? 0 }}</x-bit.table.cell>
                            </x-bit.table.row>
                            @endif
                        </x-slot>
                    </x-bit.table>
                </div>
                @isset($qa['others'])
                <div>
                    <h4 class="mb-4 text-lg font-medium text-gray-700 dark:text-gray-300">Other Answers</h4>
                    <div class="text-gray-900 dark:text-gray-200">{{ $qa['others'] }}</div>
                </div>
                @endisset
            </div>
            @elseif($qa['question']['type'] === 'matrix')
            <x-bit.table>
                <x-slot name="head">
                    <x-bit.table.heading></x-bit.table.heading>
                    @foreach($qa['question']['scale'] as $scale)
                        <x-bit.table.heading>{{ $scale }}</x-bit.table.heading>
                    @endforeach
                </x-slot>

                <x-slot name="body">
                    @foreach($qa['question']['options'] as $option)
                    <x-bit.table.row>
                        <x-bit.table.cell>{{ $option }}</x-bit.table.cell>
                        @foreach($qa['question']['scale'] as $scale)
                        <x-bit.table.cell>{{ $qa['answers'][$option][$scale] ?? 0 }}</x-bit.table.cell>
                        @endforeach
                    </x-bit.table.row>
                    @endforeach
                </x-slot>
            </x-bit.table>
            @else
            <x-bit.table class="max-h-96">
                <x-slot name="head">
                    <x-bit.table.heading colspan="2">Answers (obvious non-answers have been filtered out)</x-bit.table.heading>
                </x-slot>
                <x-slot name="body">
                    @foreach($qa['answers'] as $answer)
                    <x-bit.table.row>
                        <x-bit.table.cell>{!! nl2br($answer) !!}</x-bit.table.cell>
                        <x-bit.table.cell>
                            <button type="button" wire:click="showFullResponse('{{ Str::limit($answer, 20, '') }}')"><x-heroicon-o-eye class="w-4 h-4 text-green-500" /></button>
                        </x-bit.table.cell>
                    </x-bit.table.row>
                    @endforeach
                </x-slot>
            </x-bit.table>
            @endif
        </div>
        @endforeach
    </div>

    @if($foundAnswer)
    <x-bit.modal.dialog wire:model="showModal" max-width="6xl">
        <x-slot name="title">
            Responses with the selected answer
            <span class="block text-xs truncate max-w-prose">{{ $foundAnswer }}</span>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-8">
                <div>
                    <h2 class="text-lg font-bold text-gray-500 dark:text-gray-300">ID</h2>

                    <div class="flex space-x-4 border-gray-400 divide-x">
                        @foreach($foundResponses as $response)
                        <div class="flex-1">
                            {{ $response->id }}
                        </div>
                        @endforeach
                    </div>
                </div>
                @foreach($survey->form as $question)
                <div>
                    <h2 class="mb-4 text-lg font-bold text-gray-500 dark:text-gray-300">{{ $question['question'] }}</h2>

                    <div class="flex space-x-4 border-gray-400 divide-x">
                        @foreach($foundResponses as $response)
                        <div class="flex-1 text-gray-900 dark:text-gray-200">
                            {{ is_array($response->answers[$question['id']]) ? implode(', ', $response->answers[$question['id']]) : $response->answers[$question['id']] }}
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach

                @if($foundResponses->count() > 1)
                <div>
                    <div class="flex space-x-4 border-gray-400 divide-x">
                        @foreach($foundResponses as $response)
                        <div class="flex-1 text-gray-900 dark:text-gray-200">
                            <x-bit.button.round.secondary wire:click="delete({{ $response->id }})">Delete</x-bit.button.round.secondary>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-bit.button.flat.secondary size="xs" wire:click="closeModal">Close</x-bit.button.flat.secondary>
        </x-slot>
    </x-bit.modal.dialog>
    @endif
</div>
