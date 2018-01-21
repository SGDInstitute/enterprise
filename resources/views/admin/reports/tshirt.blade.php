<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Pronouns</th>
            <th>Sexuality</th>
            <th>Gender</th>
            <th>Race</th>
            <th>College</th>
            <th>T-Shirt</th>
            <th>Wants Program</th>
            <th>Accommodation</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $row)
        <tr>
            @foreach($row as $key => $column)
                @if($key === 'wants_program')
                    <td>{{ $column ? 'Yes' : 'No'}}</td>
                @else
                    <td>{{ $column }}</td>
                @endif
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>