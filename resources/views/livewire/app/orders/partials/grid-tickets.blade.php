@foreach ($tickets as $ticket)
    <div class="p-4 space-y-2 bg-white shadow dark:bg-gray-800">
        <div class="flex items-center justify-between">
            <p class="text-sm dark:text-gray-400">{{ $ticket->ticketType->name }} - {{ $ticket->price->name }}</p>

            @if (! $order->isPaid())
                @can('delete', $ticket)
                <button class="p-1 text-gray-700 rounded dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-800" title="Remove ticket from order" wire:click="delete({{ $ticket->id }})"><x-heroicon-o-trash class="w-5 h-5"/></button>
                @endcan
            @endif
        </div>
        @if ($ticket->isFilled())
        <div class="flex items-center justify-between">
            <p class="text-lg text-gray-900 dark:text-gray-200">{{ $ticket->user->name }} <span class="text-sm">({{ $ticket->user->email }})</span> <span class="text-sm italic">{{ $ticket->user->pronouns }}</span></p>
            <div>
                @can('update', $ticket)
                <x-bit.button.round.secondary size="xs" wire:click="loadTicket({{ $ticket->id }})">Edit User</x-bit.button.round.secondary>
                @endcan
                @can('delete', $ticket)
                <x-bit.button.round.secondary size="xs" wire:click="removeUserFromTicket({{ $ticket->id }})" onclick="confirm('Are you sure?') || event.stopImmediatePropagation()">Remove User</x-bit.button.round.secondary>
                @endcan
            </div>
        </div>
        @else
        @can('update', $ticket)
        <x-bit.button.round.secondary wire:click="loadTicket({{ $ticket->id }})">Assign/Add Ticketholder Information</x-bit.button.round.secondary>
        @endcan
        @endif
    </div>
@endforeach
