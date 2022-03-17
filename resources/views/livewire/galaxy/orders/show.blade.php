<div class="grid grid-cols-1 gap-4 md:grid-cols-3">
    <div class="space-y-4">
        <x-bit.panel title="Details">
            <x-bit.definition>
                <x-bit.definition.item key="ID" :value="$order->formattedId" />
                <x-bit.definition.item key="User">
                    <x-slot name="value">
                        <a href="{{ route('galaxy.users.show', $order->user) }}" class="hover:underline">{{ $order->user->name }}</a>
                    </x-slot>
                </x-bit.definition.item>
                <x-bit.definition.item key="Event">
                    <x-slot name="value">
                        <a href="{{ route('galaxy.events.show', $order->event) }}" class="hover:underline">{{ $order->event->name }}</a>
                    </x-slot>
                </x-bit.definition.item>
                <x-bit.definition.item key="# Tickets" :value="$order->tickets->count()" />
                @if ($order->isPaid())
                <x-bit.definition.item key="Confirmation Number" :value="$order->confirmation_number" />
                <x-bit.definition.item key="Transaction ID" :value="$order->transaction_id" />
                @endif
                <x-bit.definition.item key="Amount" :value="$order->formattedAmount" />
                @if ($order->isReservation())
                <x-bit.definition.item key="Due Date" :value="$order->reservation_ends->format('M, d Y')" />
                @else
                <x-bit.definition.item key="Paid At" :value="optional($order->paid_at)->format('M, d Y')" />
                @endif
                <x-bit.definition.item key="Created" :value="$order->created_at->format('M, d Y')" />
            </x-bit.definition>
        </x-bit.panel>

        @if ($order->invoice !== null)
        <x-bit.panel title="Invoice">
            <x-bit.definition>
                <x-bit.definition.item key="Created At" :value="Carbon\Carbon::parse($order->invoice['created_at'])->format('M, d Y')" />
                <x-bit.definition.item key="Due Date" :value="$order->invoice['due_date']" />
                <x-bit.definition.item key="Billable" :value="$order->invoice['billable']" />
            </x-bit.definition>
        </x-bit.panel>
        @endif
    </div>
    <div class="col-span-2">
        <livewire:app.orders.tickets :order="$order" />
    </div>
</div>
