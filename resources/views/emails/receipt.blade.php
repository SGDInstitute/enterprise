@section('header-title')
    @if(isset($order->event->logo_dark))
        <img src="{{ $order->event->logo_dark }}" alt="{{ $order->event->title }} Logo"
             style="width: 50%; float: right;">
    @else
        <p>{{ $order->event->title }}</p>
    @endif
@endsection

@component('mail::message')

Hi {{ $order->user->name }},

Thanks for purchasing tickets to {{ $order->event->title }}. This email is the receipt for your purchase confirming
that your order is paid in full.

@if($order->isCard())
This purchase will appear as “{{ config("{$order->event->stripe}.stripe.statement") }}” on your credit card statement for your
card ending in {{ $order->receipt->card_last_four }}.
@else
The check we received ({{ $order->receipt->transaction_id }}) has been deposited, and your records should reflect
this very soon.
@endif

**Confirmation Number:** {{ join('-', str_split($order->confirmation_number, 4)) }}

**Transaction Date:** {{ $order->receipt->created_at->toFormattedDateString() }}

@component('mail::table')
| Item                                                 | Quantity               | Price                                        | Total                                          |
| ---------------------------------------------------- | ----------------------:| --------------------------------------------:| ----------------------------------------------:|
@foreach($order->getTicketsWithNameAndAmount() as $ticket)
| {{ $ticket['name'] }} for {{ $order->event->title }} | {{ $ticket['count'] }} | ${{ number_format($ticket['cost']/100, 2) }} | ${{ number_format($ticket['amount']/100, 2) }} |
@endforeach
|                                                      |                        | Total:                                       | ${{ number_format($order->amount/100, 2) }}    |
@endcomponent

@component('mail::button', ['url' => url("/orders/{$order->id}")])
    View Order
@endcomponent

If you have any questions about this receipt, simply reply to this email or reach out to our [support team](https://support.sgdinstitute.org) for help.

Looking forward to seeing you,<br>
The {{ $order->event->title }} Team

@endcomponent

@section('scripts')
<script>
    if (location.search.indexOf('print=true') >= 0) {
        window.print();
    }
</script>
@endsection