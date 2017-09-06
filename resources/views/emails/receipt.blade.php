@extends('layouts.email')

@section('header')
    @if(isset($order->event->logo_dark))
        <img src="{{ $order->event->logo_dark }}" alt="{{ $order->event->title }} Logo"
             style="width: 50%;">
    @else
        <h4 class="card-title">{{ $order->event->title }}</h4>
    @endif
@endsection

@section('content')
    <h3>Hi {{ $order->user->name }},</h3>
    <p>Thanks for purchasing tickets to {{ $order->event->title }}. This email is the receipt for your purchase. No payment is due.</p>

    @if($order->isCard())
        <p>This purchase will appear as “[Credit Card Statement Name]” on your credit card statement for your
            [credit_card_brand] ending in {{ $order->card_last_four }}.</p>
    @else
        <p>The check we received ({{ $order->transaction_id }}) has been deposited, and your records should reflect this very soon.</p>
    @endif

    <table class="purchase" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td><h3>Confirmation Number: {{ $order->confirmation_number }}</h3></td>
            <td><h3 class="align-right">{{ $order->transaction_date->toFormattedDateString() }}</h3></td>
        </tr>
        <tr>
            <td colspan="2">
                <table class="purchase_content" width="100%" cellpadding="0" cellspacing="0">
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
            </td>
        </tr>
    </table>

    <p>If you have any questions about this receipt, simply reply to this email or reach out to our <a
                href="[support_url]">support team</a> for help.</p>
    <p>Cheers,
        <br>The {{ $order->event->title }} Team</p>
    <a href="/orders/{{ $order->id }}">View Order</a>
@endsection