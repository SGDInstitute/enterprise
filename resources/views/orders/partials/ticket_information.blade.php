<h4>{{ $order->event->ticket_string }} Details</h4>
<table class="table">
    <thead>
    <tr>
        <th>Name</th>
        <th>E-Mail</th>
        <th>T-Shirt</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @forelse ($order->tickets()->filled() as $ticket)
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    @empty
        <tr>
            <td colspan="3" class="text-center">Looks like you don't have
                any {{ str_plural($order->event->ticket_string) }} filled
                out!<br><br>
                <button type="button" class="btn btn-primary border-dark" data-toggle="modal"
                        data-target="#exampleModal">
                    Add {{ $order->event->ticket_string }} Information Now
                </button>
            </td>
        </tr>
    @endforelse
    </tbody>
</table>