<div class="card mb-2">
    <div class="card-body">
        <p class="pull-right text-muted mb-0">#{{ $ticket->hash }}</p>
        <h4 class="card-title">{{ $ticket->user->name }}</h4>

        <a href="mailto:{{ $ticket->user->email }}" class="card-link">{{ $ticket->user->email }}</a>
        @if(! is_null($ticket->user->profile->tshirt))
            <span class="card-link">{{ $ticket->user->profile->tshirt }}</span>
        @endif
        @if(! is_null($ticket->user->profile->pronouns))
            <span class="card-link">{{ $ticket->user->profile->pronouns }}</span>
        @endif

        @if(Auth::user()->id === $ticket->user->id)
            <a href="#" class="card-link">Update my information</a>
        @endif
    </div>
</div>