@component('mail::message')
Hello!

We’re excited to have you join us in {{ $order->event->location }} for {{ $order->event->title }}! You’ve started the registration process, but still need to complete filling out some of your {{ $order->event->ticket_string }} information. For sustainability reasons, we base our swag purchases on the number of filled out and paid registrants only. Help us make a more responsible impact and complete your order today!

# Number of {{ Str::plural($order->event->ticket_string) }} Filled: {{ $order->tickets()->filled()->count() }} of {{ $order->tickets->count() }}

To complete your order for {{ $order->tickets->count() }} tickets, follow the link below:

@component('mail::button', ['url' => $url])
Complete Order
@endcomponent

@if(!$order->isPaid())
Need to delete your order? We have that option in the order detail page as well.

@component('mail::button', ['url' => $url])
Delete Order
@endcomponent
@endif

{{ $order->event->title }} is about envisioning a future together. We can’t wait to have you with us on that journey!

Thanks,<br>
{{ $order->event->title }} Planning Team and the Midwest Institute for Sexuality and Gender Diversity
@endcomponent