<x-bit.modal.dialog wire:model.defer="showCheckModal" max-width="lg">
    <x-slot name="title">
        Pay with Check
    </x-slot>

    <x-slot name="content">
        <div class="prose dark:prose-light">
            <p>Your order total is {{ $subtotal }}. Please download the invoice and mail it and the check to {{ config('globals.institute_address') }}</p>

            <p>Please make checks payable to the Midwest Institute for Sexuality and Gender Diversity.</p>
            <p>On the memo line please write: <strong>Order {{ $order->event->order_prefix }}{{ $order->id }}</strong></p>
        </div>
    </x-slot>

    <x-slot name="footer">
        <div class="space-x-2">
            <x-bit.button.flat.secondary wire:click="$set('showCheckModal', false)">Close</x-bit.button.flat.secondary>

            <x-bit.button.flat.primary type="submit" wire:click="downloadInvoice">Download Invoice</x-bit.button.flat.primary>
        </div>
    </x-slot>
</x-bit.modal.dialog>
