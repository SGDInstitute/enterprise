<table class="table">
    <thead>
        <tr>
            <th>Confirmation Number</th>
            <th>Ticket #</th>
            <th>Name</th>
            <th>Email</th>
            <th>Pronouns</th>
            <th>College</th>
            <th>T-Shirt</th>
            <th>Accommodation</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $registrant)
            <tr>
                <td>{{ $registrant->confirmation_number }}</td>
                <td>{{ $registrant->hash }}</td>
                <td>{{ $registrant->name }}</td>
                <td>{{ $registrant->email }}</td>
                <td>{{ $registrant->pronouns }}</td>
                <td>{{ $registrant->college }}</td>
                <td>{{ $registrant->tshirt }}</td>
                <td>{{ $registrant->accommodation }}</td>
            </tr>
        @endforeach
    </tbody>
</table>