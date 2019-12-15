<div class="bg-gray-100 group rounded shadow hover:bg-white hover:shadow-lg transition mb-4 px-6 py-4">
    <div class="mb-2 flex justify-between">
        @if($ticket->user->name !== null)
        <h4 class="text-xl text-semibold">{{ $ticket->user->name }}</h4>
        @else
        <h4 class="text-xl text-semibold">{{ $ticket->ticket_type->name }}</h4>
        @endif

        <div class="flex items-center">
            @if(!$order->isPaid())
            <form action="/tickets/{{ $ticket->hash }}" method="post" class="mr-4 invisible group-hover:visible">
                @csrf
                @method('DELETE')
                <button class="btn btn-link btn-sm hover:bg-gray-200">
                    <i class="fa fa-fw fa-trash"></i>
                    <span class="sr-only">Delete Ticket</span>
                </button>
            </form>
            @endif
            <p class="text-gray-600 mb-0">#{{ $ticket->hash }}</p>
        </div>
    </div>

    <div class="md:flex justify-between">
        @if($order->tickets->pluck('user_id')->contains(Auth::user()->id))
        <a id="me" href="mailto:{{ $ticket->user->email }}" class="btn btn-link hover:bg-gray-200">{{ $ticket->user->email }}</a>
        @else
        <a href="mailto:{{ $ticket->user->email }}" class="btn btn-link hover:bg-gray-200">{{ $ticket->user->email }}</a>
        @endif

        @if(Auth::user()->id === $ticket->user->id)
        <a href="/settings" class="btn btn-link hover:bg-gray-200">Update my information</a>
        @endif
        @if($ticket->type === 'manual')
        <edit-manual-user :user="{{ $ticket->user }}" class="inline-block" classes="btn btn-link hover:bg-gray-200"></edit-manual-user>
        @endif
        <view-user :user="{{ $ticket->user}}" class="inline-block" classes="btn btn-link hover:bg-gray-200"></view-user>

        @if(Auth::user()->can('update', $order))
        <remove-user-button hash="{{ $ticket->hash }}" redirect="{{ url('/orders/' . $ticket->order->id) }}" class="btn btn-link hover:bg-gray-200"></remove-user-button>
        @endif
    </div>
</div>