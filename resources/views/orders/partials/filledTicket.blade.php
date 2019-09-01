<div class="bg-gray-100 rounded shadow hover:bg-white hover:shadow-lg transition mb-4 px-6 py-4">
    <div class="mb-2">
        <p class="float-right text-gray-600 mb-0">#{{ $ticket->hash }}</p>
        @if($ticket->user->name !== null)
        <h4 class="text-xl text-semibold">{{ $ticket->user->name }}</h4>
        @else
        <h4 class="text-xl text-semibold">{{ $ticket->ticket_type->name }}</h4>
        @endif
    </div>

    <div class="flex justify-between">
        <a href="mailto:{{ $ticket->user->email }}" class="btn btn-link hover:bg-gray-200">{{ $ticket->user->email }}</a>

        @if(Auth::user()->id === $ticket->user->id)
        <a href="/settings" class="btn btn-link hover:bg-gray-200">Update my information</a>
        @endif
        @if($ticket->type === 'manual')
        <modal-button class="btn btn-link hover:bg-gray-200" event="editProfileModal" payload="{{ $ticket->user }}">
            Edit Details
        </modal-button>
        @endif
        <modal-button class="btn btn-link hover:bg-gray-200" event="showViewProfileModal" payload="{{ $ticket->hash }}">
            View Details
        </modal-button>

        @if(Auth::user()->can('update', $order))
        <remove-user-button hash="{{ $ticket->hash }}" redirect="{{ url('/orders/' . $ticket->order->id) }}" class="btn btn-link hover:bg-gray-200"></remove-user-button>
        @endif
    </div>
</div>