<table>
    <thead>
    <tr>
        @foreach($form->form as $question)
        <th>{{ $question['question'] }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($responses as $response)
    <tr>
        @foreach($form->form as $question)
            @if(is_array($response->responses[$question['id']]))
            <td>
                @foreach($response->responses[$question['id']] as $item)
                    @if(is_array($item))
                        {{ implode($item) }}
                    @else
                        {{ $item }}@if (!$loop->last), @endif
                    @endif
                @endforeach
            </td>
            @else
            <td>{{ $response->responses[$question['id']] ?? '' }}</td>
            @endif
        @endforeach
    </tr>
    @endforeach
    </tbody>
</table>