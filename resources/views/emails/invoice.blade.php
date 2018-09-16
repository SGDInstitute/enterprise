@section('header-title')
    @if(isset($ticket->order->event->logo_dark))
        <img src="{{ $ticket->order->event->logo_dark }}" alt="{{ $ticket->order->event->title }} Logo"
             style="width: 50%; float: right;">
    @else
        <p>{{ $ticket->order->event->title }}</p>
    @endif
@endsection

@component('mail::message')
Hi {{ $order->user->name }},

Thanks for creating an invoice for {{ $order->event->title }}, you will find the invoice as an attachment.

Order details:

@component('mail::table')
| Item                                                 | Quantity               | Price                                        | Total                                          |
| ---------------------------------------------------- | ----------------------:| --------------------------------------------:| ----------------------------------------------:|
@foreach($order->getTicketsWithNameAndAmount() as $ticket)
| {{ $ticket['name'] }} for {{ $order->event->title }} | {{ $ticket['count'] }} | ${{ number_format($ticket['cost']/100, 2) }} | ${{ number_format($ticket['amount']/100, 2) }} |
@endforeach
|                                                      |                        | Total:                                       | ${{ number_format($order->amount/100, 2) }}    |
@endcomponent

@component('mail::button', ['url' => $url])
    View Order
@endcomponent

If you have any questions about this invoice, simply reply to this email or reach out to our
[support team](https://support.sgdinstitute.org) for help.

Looking forward to seeing you,<br>
The {{ $order->event->title }} Team

@endcomponent