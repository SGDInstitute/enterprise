<div class="card mb-2">
    <div class="card-body">
        <p class="pull-right text-muted mb-0">#{{ $ticket->hash }}</p>
        <h4 class="card-title">{{ $ticket->ticket_type->name }}</h4>

        @if(! $order->tickets->pluck('user_id')->contains(Auth::user()->id))
            <a href="#" class="card-link">Add my information</a>
        @endif
        <modal-button class="card-link" event="showManualUserModal" payload="{{ $ticket->hash }}">
            Manually add information
        </modal-button>
        <modal-button class="card-link" event="showInviteUsers">
            Invite users to fill out information
        </modal-button>
    </div>
</div>