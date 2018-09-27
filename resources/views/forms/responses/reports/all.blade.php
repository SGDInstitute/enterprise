<table class="table table-bordered">
    <tr>
        <td></td>
        @foreach($fields as $field)
            <td>{{ $field['question'] }}</td>
        @endforeach
    </tr>
    @foreach($responses as $index => $response)
        <tr>
            <td>{{ base64_encode($response->email) }}</td>
            @foreach($fields as $field)
                <td>
                    @if($response->responses->has($field['id']))
                        @if(is_array($response->responses->get($field['id'])))
                            {{ implode(', ', $response->responses->get($field['id'])) }}
                        @else
                            {{ $response->responses->get($field['id']) }}
                        @endif
                    @endif
                </td>
            @endforeach
        </tr>
    @endforeach
</table>