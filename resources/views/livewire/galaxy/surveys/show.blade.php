<div>
    <div class="grid grid-cols-1 gap-8 md:grid-cols-4">
        <x-bit.stat title="Total Number of Responses" :value="$numberOfResponses" />
        @if($numberOfResponses > $numberOfUniqueResponses)
        <x-bit.stat title="Total - Likely Duplicates" subtitle="only unique answers are shown" :value="$numberOfUniqueResponses"/>
        @endif
    </div>

    <div class="prose dark:prose-light max-w-none">
        @foreach($responsesByQuestion as $qa)
        <div>
            <h3>{{ $qa['question']['question'] }}</h3>

            @if($qa['question']['type'] === 'list')
            <div class="flex">
                <div class="w-2/3">
                    <table>
                        <tbody>
                            @foreach($qa['question']['options'] as $option)
                            <tr>
                                <th>{{ $option }}</th>
                                <td>{{ $qa['answers'][$option] ?? 0 }}</td>
                            </tr>
                            @endforeach
                            @if(isset($qa['question']['list-other']) && $qa['question']['list-other'])
                            <tr>
                                <th>Other</th>
                                <td>{{ $qa['answers']['other'] ?? 0 }}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                @isset($qa['others'])
                <div class="w-1/3 px-8">
                    <h4>Other Answers</h4>
                    {{ $qa['others'] }}
                </div>
                @endisset
            </div>
            @elseif($qa['question']['type'] === 'matrix')
            <table>
                <thead>
                    <tr>
                        <th></th>
                        @foreach($qa['question']['scale'] as $scale)
                        <th>{{ $scale }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($qa['question']['options'] as $option)
                    <tr>
                        <th>{{ $option }}</th>
                        @foreach($qa['question']['scale'] as $scale)
                        <td>{{ $qa['answers'][$option][$scale] ?? 0 }}</td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="overflow-scroll border divide-y rounded-md h-96">
                @foreach($qa['answers'] as $answer)
                <div class="flex justify-between px-3 py-2">
                    <span>{!! nl2br($answer) !!}</span>
                    <button type="button" wire:click="showFullResponse('{{ Str::limit($answer, 20, '') }}')"><x-heroicon-o-eye class="w-4 h-4 text-green-500" /></button>
                </div>
                @endforeach
            </div>
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
