<table class="table">
    <thead>
        <tr>
            <th>Contribution</th>
            <th>Type</th>
            <th>Quantity</th>
            <th>Amount</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($donation->contributions as $contribution)
        <tr>
            <td>{{ $contribution->title }}</td>
            <td class="text-xs uppercase tracking-wide">{{ $contribution->type }}</td>
            <td class="text-right">{{ $contribution->pivot->quantity }}</td>
            <td class="text-right">${{ number_format($contribution->pivot->amount / 100, 2) }}</td>
            <td class="text-right">${{ number_format($contribution->pivot->amount * $contribution->pivot->quantity / 100, 2) }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4"></td>
            <td class="text-rightme">${{ number_format($donation->amount/100, 2) }}</td>
        </tr>
    </tfoot>
</table>