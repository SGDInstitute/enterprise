<div class="card mb-2">
    <div class="card-body">
        <p class="pull-right text-muted mb-0">#{{ $ticket->hash }}</p>
        <h4 class="card-title">{{ $ticket->ticket_type->name }}</h4>

        @if(Auth::user()->can('update', $order))
            @if(! $order->tickets->pluck('user_id')->contains(Auth::user()->id))
                <add-user-button id="me" class="card-link" ticket="{{ $ticket->hash }}" user="{{ Auth::user()->id }}"></add-user-button>
            @endif
            <modal-button id="manually" class="card-link" event="showManualUserModal" payload="{{ $ticket->hash }}">
                Manually add information
            </modal-button>
            <modal-button id="invite" class="card-link" event="showInviteUsers">
                Invite users to fill out information
            </modal-button>
        @endif
    </div>
</div>