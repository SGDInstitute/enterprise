@foreach($order->tickets as $ticket)
    @includeWhen($ticket->user_id === null, 'orders.partials.emptyTicket')
    @includeWhen($ticket->user_id !== null, 'orders.partials.filledTicket')
@endforeach

@if(!$order->isPaid())
    <add-ticket :order="{{ $order }}" classes="btn btn-mint btn-sm"></add-ticket>
@endif