<table class="table">
    <tbody>
    <tr>
        <td>ID</td>
        <td>{{ $donation->charge_id }}</td>
    </tr>
    <tr>
        <td>Amount</td>
        <td>{{ $donation->amount }}</td>
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