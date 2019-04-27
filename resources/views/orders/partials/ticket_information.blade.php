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
                any {{ Str::plural($order->event->ticket_string) }} filled
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

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Are you ready to tell us who’s
                    attending {{ $order->event->title }}?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Great! There are two options to do so. How do you want to proceed?</p>

                <div class="row">
                    <div class="col">
                        <a href="/orders/{{ $order->id }}/tickets/manual" class="btn btn-outline-secondary btn-block">
                            Fill out attendee information manually</a>
                    </div>
                    <div class="col">
                        <a href="/orders/{{ $order->id }}/tickets/invite" class="btn btn-outline-secondary btn-block">
                            Invite attendees to fill out their own information</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>