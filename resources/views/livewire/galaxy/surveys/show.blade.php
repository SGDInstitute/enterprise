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
            <div class="px-3 py-2">{!! nl2br($answer) !!}</div>
            @endforeach
        </div>
        @endif
    </div>
    @endforeach
</div>
