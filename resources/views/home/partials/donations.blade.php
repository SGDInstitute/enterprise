<h2>Your donations</h2>

<table class="table">
    <thead>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Amount</th>
        <th>Donated On</th>
        <th>Recurring?</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @forelse($donations as $donation)
        <tr>
            <td>{{ $donation->name }}</td>
            <td>{{ $donation->email }}</td>
            <td>${{ number_format($donation->amount/100, 2) }}</td>
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
            <td><a href="/donations/{{ $donation->hash }}">View</a></td>
        </tr>
    @empty
        <tr>
            <td colspan="7">
                Looks like you haven't made a donation that is associated with this account, would you like to
                <a href="/donations/create">make one now</a>?
            </td>
        </tr>
    @endforelse
    </tbody>
</table>