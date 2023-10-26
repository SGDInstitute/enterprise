
<div class="space-y-4">
    <div class="px-4 py-2 text-gray-200 bg-red-500 rounded">
        <p>This ticket has not been paid for yet. Payment is required to checkin.</p>

        <x-bit.button.round.primary :href="route('app.orders.show', ['order' => $ticket->order])">Pay Now</x-bit.button.round.primary>
    </div>
</div>
