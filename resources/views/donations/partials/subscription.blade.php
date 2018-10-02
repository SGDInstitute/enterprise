<table class="table">
    <tbody>
    <tr>
        <td class="w-48">Amount</td>
        <td>${{ number_format($donation->amount/100, 2) }}</td>
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
    <tr>
        <td>Card</td>
        <td>
            ****-****-****-{{ $subscription->card->last4 }}
            <i class="fab fa-cc-{{ strtolower($subscription->card->brand) }}"></i>
            <span class="text-sm text-grey-darker ml-4">(Expires {{ $subscription->card->exp_month }}/{{ $subscription->card->exp_year }})</span>

            <update-card-button class="text-sm float-right btn-link"></update-card-button>
        </td>
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