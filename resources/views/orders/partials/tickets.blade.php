@foreach($order->tickets as $ticket)
    @includeWhen($ticket->user_id === null, 'orders.partials.emptyTicket')
    @includeWhen($ticket->user_id !== null, 'orders.partials.filledTicket')
@endforeach