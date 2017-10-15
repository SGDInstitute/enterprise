<table class="table">
    <tbody>
    <tr>
        <td>Amount</td>
        <td>${{ number_format($donation->amount/100, 2) }}</td>
    </tr>
    @if(isset($charge))
    <tr>
        <td>Card</td>
        <td>
            ****-****-****-{{ $charge->source->last4 }}
            <i class="fa fa-cc-{{ strtolower($charge->source->brand) }}"></i>
        </td>
    </tr>
    @endif
    <tr>
        <td>Date</td>
        <td>{{ $donation->created_at->toFormattedDateString() }}</td>
    </tr>
    </tbody>
</table>