<div class="space-y-4">
    <div class="rounded bg-red-500 px-4 py-2 text-gray-200">
        <p>This ticket has not been paid for yet. Payment is required to checkin.</p>

        @can('update', $ticket->order)
            <x-bit.button.round.primary :href="route('app.orders.show', ['order' => $ticket->order])">
                Pay Now
            </x-bit.button.round.primary>
        @endcan
    </div>
</div>
