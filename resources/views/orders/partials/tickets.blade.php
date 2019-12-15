@foreach($order->tickets as $ticket)
    @includeWhen($ticket->user_id === null, 'orders.partials.emptyTicket')
    @includeWhen($ticket->user_id !== null, 'orders.partials.filledTicket')
@endforeach

<form action="/orders/{{ $order->id }}/tickets" method="post">
    @csrf
    <button class="btn btn-gray">
        <i class="fa fa-fw fa-plus mr-2"></i>
        Add Ticket
    </button>
</form>