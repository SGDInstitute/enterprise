@component('mail::message')
    # Hey there!

    @if ($order->isStripe())
        This is an automatic message to let you know {{ $count }} ticket(s) for {{ $order->event->name }} have been
        refunded. It may take 5-7 days for the refund of ${{ $amount / 100 }} to be applied to your original form of
        payment, depending on how fast your payment processor applies the credit.
    @else
        This is an automatic message to let you know {{ $count }} ticket(s) for {{ $order->event->name }} have been
        refunded. A check for the amount of ${{ $amount / 100 }} will be mailed to you.
    @endif
@endcomponent
