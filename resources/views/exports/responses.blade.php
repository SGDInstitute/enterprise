<table>
    <thead>
        <tr>
            @foreach ($questions as $question)
                @if ($question['type'] === 'matrix')
                    <th colspan="{{ count($question['options']) }}">{{ $question['question'] }}</th>
                @else
                    <th>{{ $question['question'] }}</th>
                @endif
            @endforeach
        </tr>
        <tr>
            @foreach ($questions as $question)
                @if ($question['type'] === 'matrix')
                    @foreach ($question['options'] as $option)
                        <th>{{ $option }}</th>
                    @endforeach
                @else
                    <th></th>
                @endif
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($responses as $response)
            <tr>
                @foreach ($questions as $question)
                    @if ($question['type'] === 'matrix')
                        @foreach ($question['options'] as $option)
                            <td>{{ $response->answers[$question['id']][$option] ?? '-' }}</td>
                        @endforeach
                    @elseif (isset($response->answers[$question['id']]))
                        <td>
                            {{ is_array($response->answers[$question['id']]) ? implode(', ', $response->answers[$question['id']]) : $response->answers[$question['id']] }}
                        </td>
                    @else
                        <td></td>
                    @endif
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
