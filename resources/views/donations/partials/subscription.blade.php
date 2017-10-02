<table class="table">
    <tbody>
    <tr>
        <td>ID</td>
        <td>{{ $donation->subscription->subscription_id }}</td>
    </tr>
    <tr>
        <td>Amount</td>
        <td>{{ $donation->amount }}</td>
    </tr>
    <tr>
        <td>Frequency</td>
        <td>{{ ucfirst($donation->subscription->frequency) }}</td>
    </tr>
    <tr>
        <td>Upcoming Payment</td>
        @if($donation->subscription->isActive())
            <td>{{ date('m/d/Y', $subscription->current_period_end) }}</td>
        @else
            <td>Plan was canceled on {{ $donation->subscription->ended_at->toFormattedDateString() }}</td>
        @endif
    </tr>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="2">
            @if($donation->subscription->isActive())
                <form action="/donations/{{ $donation->hash }}/cancel">
                    {{ csrf_field() }}
                    {{ method_field('patch') }}
                    <button type="submit" class="btn btn-danger">Cancel</button>
                </form>
            @endif
        </td>
    </tr>
    </tfoot>
</table>