<div class="card mb-2">
    <div class="card-body">
        <p class="pull-right text-muted mb-0">#{{ $ticket->hash }}</p>
        @if($ticket->user->name !== null)
            <h4 class="card-title">{{ $ticket->user->name }}</h4>
        @endif

        <a href="mailto:{{ $ticket->user->email }}" class="card-link">{{ $ticket->user->email }}</a>

        @if(Auth::user()->id === $ticket->user->id)
            <a href="/settings" class="card-link">Update my information</a>
        @endif
        @if($ticket->type === 'manual')
            <modal-button class="card-link" event="editProfileModal" payload="{{ $ticket->user }}">
                Edit Details
            </modal-button>
        @endif
        <modal-button class="card-link" event="showViewProfileModal" payload="{{ $ticket->hash }}">
            View Details
        </modal-button>

        <remove-user-button hash="{{ $ticket->hash }}" redirect="{{ url('/orders/' . $ticket->order->id) }}" class="card-link"></remove-user-button>
    </div>
</div>