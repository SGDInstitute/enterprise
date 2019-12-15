<div class="bg-gray-100 rounded shadow group hover:bg-white hover:shadow-lg transition mb-4 px-6 py-4">
    <div class="flex justify-between mb-2">
        <h4 class="text-xl text-semibold">{{ $ticket->ticket_type->name }}</h4>
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

    @if(Auth::user()->can('update', $order))
    <div class="md:flex justify-between">
        @if(! $order->tickets->pluck('user_id')->contains(Auth::user()->id))
        <add-user-button id="me" class="btn btn-link hover:bg-gray-200" ticket="{{ $ticket->hash }}" user="{{ Auth::user()->id }}"></add-user-button>
        @endif
        <manual-user-modal id="manually" :ticket="{{ $ticket }}" classes="btn btn-link hover:bg-gray-200"></manual-user-modal>

        <invite-users-form id="invite" :order="{{ $order }}" :tickets="{{ $order->tickets->where('user_id', null) }}" class="inline-block" classes="btn btn-link hover:bg-gray-200"></invite-users-form>
    </div>
    @endif
</div>