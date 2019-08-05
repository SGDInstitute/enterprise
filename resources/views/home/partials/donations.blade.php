<div class="bg-white rounded shadow overflow-hidden">
    <nav class="bg-mint-200 flex px-8 pt-2 border-b border-mint-300">
        <h1 class="no-underline text-mint-600 border-b-2 border-mint-600 uppercase tracking-wide font-bold text-xs py-3 mr-8">Your donations</h1>
    </nav>
    <div class="p-6">
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
    </div>
</div>


