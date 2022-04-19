<div class="space-y-12">
    <x-ui.steps :steps="$steps" />

    <div class="grid grid-cols-1 gap-8 px-4 mx-auto max-w-7xl sm:px-6 lg:px-8 md:grid-cols-3">
        <livewire:app.events.modals :event="$order->event" />

        <div class="col-span-2">
            @if ($page === 'payment')
            <livewire:app.orders.payment :order="$order" />
            @else
            <livewire:app.orders.tickets :order="$order" />
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
@endpush
