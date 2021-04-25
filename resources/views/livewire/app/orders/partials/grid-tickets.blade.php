@foreach($order->tickets as $ticket)
    <div class="p-4 space-y-2 bg-gray-100 shadow dark:bg-gray-700">
        <p class="text-sm dark:text-gray-400">{{ $ticket->ticketType->name }} - {{ $ticket->price->name }}</p>
        @if($ticket->isFilled())
        <div class="flex items-center justify-between">
            <p class="text-lg text-gray-900 dark:text-gray-200">{{ $ticket->user->name }} <span class="text-sm">({{ $ticket->user->email }})</span> <span class="text-sm italic">{{ $ticket->user->pronouns }}</span></p>
            <div>
                <x-bit.button.round.secondary size="xs" wire:click="loadTicketholder({{ $ticket->id }})">Edit User</x-bit.button.round.secondary>
                <x-bit.button.round.secondary size="xs" wire:click="removeTicketholder({{ $ticket->id }})" onclick="confirm('Are you sure?') || event.stopImmediatePropagation()">Remove User</x-bit.button.round.secondary>
            </div>
        </div>
        @else
        <x-bit.button.round.secondary wire:click="$toggle('showTicketholderModal')">Assign/Add Ticketholder Information</x-bit.button.round.secondary>
        @endif
    </div>
@endforeach
