@extends('layouts.email')

@section('header')
    <div class="text-right">
        @if(isset($order->event->logo_dark))
            <img src="{{ $order->event->logo_dark }}" alt="{{ $order->event->title }} Logo"
                 style="width: 50%; float: right;">
        @else
            <h4 class="card-title">{{ $order->event->title }}</h4>
        @endif
    </div>
@endsection

@section('content')
    <h1>Hi {{ $order->user->name }},</h1>
    <p>Thanks for purchasing tickets to {{ $order->event->title }}. This email is the receipt for your purchase confirming that your order is paid in full.</p>

    @if($order->isCard())
        <p>This purchase will appear as “[Credit Card Statement Name]” on your credit card statement for your
            [credit_card_brand] ending in {{ $order->receipt->card_last_four }}.</p>
    @else
        <p>The check we received ({{ $order->receipt->transaction_id }}) has been deposited, and your records should reflect this
            very soon.</p>
    @endif

    <p><strong>Confirmation Number: </strong> {{ join('-', str_split($order->confirmation_number, 4)) }}</p>
    <p><strong>Transaction Date: </strong> {{ $order->receipt->created_at->toFormattedDateString() }}</p>

    <spacer size="16"></spacer>

    <table class="table" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <th class="purchase_heading">
                <p>Item</p>
            </th>
            <th class="purchase_heading">
                <p class="align-right">Quantity</p>
            </th>
            <th class="purchase_heading">
                <p class="align-right">Price</p>
            </th>
            <th class="purchase_heading">
                <p class="align-right">Total</p>
            </th>
        </tr>
        @foreach($order->getTicketsWithNameAndAmount() as $ticket)
            <tr>
                <td>{{ $ticket['name'] }} for {{ $order->event->title }}</td>
                <td>{{ $ticket['count'] }}</td>
                <td>${{ number_format($ticket['cost']/100, 2) }}</td>
                <td>${{ number_format($ticket['amount']/100, 2) }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="3" class="purchase_footer" valign="middle"><strong>Total:</strong></td>
            <td class="purchase_footer" valign="middle">
                <p class="purchase_total">${{ number_format($order->amount/100, 2) }}</p>
            </td>
        </tr>
    </table>

    <row>
        <columns class="btn-column">
            <button href="/orders/{{ $order->id }}" class="radius text-center">View Order</button>
        </columns>
    </row>

    <p>If you have any questions about this receipt, simply reply to this email or reach out to our <a
                href="https://support.sgdinstitute.org">support team</a> for help.</p>
    <p>Thanks,
        <br>
        @if($order->event->stripe !== 'institute')
        The {{ $order->event->title }} and the
        @endif
        {{ config('institute.long_name') }} Team</p>
@endsection