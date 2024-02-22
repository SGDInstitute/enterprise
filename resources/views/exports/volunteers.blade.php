<table>
    <tbody>
        @foreach ($shifts as $shift)
            <tr>
                <td style="font-weight: bold">{{ $shift->name }} - {{ $shift->formattedDuration }}</td>
            </tr>
            @forelse ($shift->users->unique() as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->pronouns }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No users</td>
                </tr>
            @endforelse
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endforeach
    </tbody>
</table>
