<form wire:submit="saveInvoice">
    <x-bit.modal.dialog wire:model="showInvoiceModal" max-width="lg">
        <x-slot name="title">
            Invoice
        </x-slot>

        <x-slot name="content">
            <div class="prose dark:prose-light">
                <p>If you need to add specific contact or tax information to your invoice, like your full business name, or address of record, you may add it here.</p>

                <x-bit.input.group for="billable" label="Billing Information">
                    <x-bit.input.textarea id="billable" class="w-full mt-1" name="billable" wire:model.live="order.invoice.billable" />
                </x-bit.input.group>
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="space-x-2">
                <x-bit.button.flat.secondary wire:click="$set('showInvoiceModal', false)">Close</x-bit.button.flat.secondary>

                <x-bit.button.flat.primary type="submit">Save</x-bit.button.flat.primary>
                <x-bit.button.flat.primary wire:click="downloadInvoice">Download Invoice</x-bit.button.flat.primary>
            </div>
        </x-slot>
    </x-bit.modal.dialog>
</form>
