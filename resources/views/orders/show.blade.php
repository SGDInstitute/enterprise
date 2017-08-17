{{ $order->event->title }}
{{ $order->event->place }}
{{ $order->event->location }}
{{ $order->event->duration }}
{{ '$' . number_format($order->amount/100, 2) }}
{{ $order->tickets()->filled()->count() }} of {{ $order->tickets->count() }}