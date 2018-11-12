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
            <td>{{ $response->responses[$question['id']] ?? '' }}</td>
        @endforeach
    </tr>
    @endforeach
    </tbody>
</table>