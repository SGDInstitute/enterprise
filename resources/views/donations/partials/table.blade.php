<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Amount</th>
            <th>For</th>
            <th>Donated On</th>
            <th>Recurring?</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($donations as $donation)
        <tr>
            <td>{{ $donation->name }}</td>
            <td>{{ $donation->email }}</td>
            <td>{{ $donation->amount }}</td>
            <td>{{ getNameFromGroup($donation->group) }}</td>
            <td>{{ $donation->created_at->toFormattedDateString() }}</td>
            <td>
                @if($donation->subscription && $donation->subscription->isActive())
                Yes
                @elseif($donation->subscription)
                Canceled
                @else
                No
                @endif
            </td>
            <td><a href="{{ route('donations.show', $donation) }}" class="btn btn-link">View</a></td>
        </tr>
        @endforeach
    </tbody>
</table>