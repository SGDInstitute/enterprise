<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Activity</th>
            <th>Date</th>
            <th>Start</th>
            <th>End</th>
        </tr>
    </thead>
    <tbody>
        @foreach($schedule->activities as $activity)
        @foreach($activity->users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $activity->title }}</td>
            <td>{{ $activity->start->tz($schedule->event->timezone)->format('Y-m-d') }}</td>
            <td>{{ $activity->start->tz($schedule->event->timezone)->format('h:i a') }}</td>
            <td>{{ $activity->end->tz($schedule->event->timezone)->format('h:i a') }}</td>
        </tr>
        @endforeach
        @endforeach
    </tbody>
</table>