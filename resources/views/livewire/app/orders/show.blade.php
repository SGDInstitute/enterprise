<div class="space-y-12">
    @if ($order->user_id === auth()->id())
        <x-ui.steps :steps="$steps" />
    @endif

    <div class="grid grid-cols-1 gap-8 px-4 mx-auto max-w-7xl sm:px-6 lg:px-8 md:grid-cols-3 {{ $order->user_id === auth()->id() ? '' : 'pt-12' }}">
        <div class="space-y-4">
            <livewire:app.events.modals :event="$order->event" />

            @can('delete', $order)
            <x-bit.button.flat.primary block wire:click="delete" class="space-x-2">
                <x-heroicon-o-trash class="w-4 h-4" /> <span>Delete Order</span>
            </x-bit.button.flat.primary>
            @endcan
        </div>

        <div class="col-span-2">
            @if ($page === 'start')
            <livewire:app.orders.start :order="$order" />
            @elseif ($page === 'payment')
            <livewire:app.orders.payment :order="$order" />
            @elseif ($page === 'tickets')
            <livewire:app.orders.tickets :order="$order" />
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
@endpush
