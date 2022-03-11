<div class="space-y-8">
    <h1 class="text-2xl text-gray-900 dark:text-gray-200">Donations</h1>

    <div class="space-y-4">
        <div class="flex-col mt-5 space-y-4">
            <div class="md:flex md:justify-between md:items-center">
                <div class="flex items-end mt-4 md:mt-0">
                    <x-bit.data-table.per-page wire:model="perPage" />
                </div>
            </div>

            <x-bit.table>
                <x-slot name="head">
                    <x-bit.table.heading>Date Donated</x-bit.table.heading>
                    <x-bit.table.heading>Type</x-bit.table.heading>
                    <x-bit.table.heading>Amount</x-bit.table.heading>
                    <x-bit.table.heading>Status</x-bit.table.heading>
                    <x-bit.table.heading></x-bit.table.heading>
                </x-slot>

                <x-slot name="body">
                    @forelse($donations as $donation)
                    <x-bit.table.row wire:key="row-{{ $donation->id }}">
                        <x-bit.table.cell>{{ $donation->created_at->timezone('America/Chicago')->format('M, d Y') }}</x-bit.table.cell>
                        <x-bit.table.cell>{{ $donation->formattedType }}</x-bit.table.cell>
                        <x-bit.table.cell>{{ $donation->formattedAmount }}</x-bit.table.cell>
                        <x-bit.table.cell>{{ $donation->status }}</x-bit.table.cell>
                        <x-bit.table.cell class="space-x-1 text-right">
                            @if($donation->type === 'monthly')
                            <x-bit.button.link size="px-2 py-1" wire:click="openPortal">Change Amount</x-bit.button.link>
                            <x-bit.button.link size="px-2 py-1" wire:click="openPortal">Update Card</x-bit.button.link>
                            @if($donation->status !== 'canceled')
                            <x-bit.button.link size="px-2 py-1" wire:click="cancel({{ $donation->id }})">Cancel</x-bit.button.link>
                            @endif
                            @endif
                        </x-bit.table.cell>
                    </x-bit.table.row>
                    @empty
                    <x-bit.table.row>
                        <x-bit.table.cell colspan="9">
                            <div class="flex items-center justify-center space-x-2">
                                <x-heroicon-o-users class="w-8 h-8 text-gray-400" />
                                <span class="py-8 text-xl font-medium text-gray-500 dark:text-gray-400 ">No donations found...</span>
                            </div>
                        </x-bit.table.cell>
                    </x-bit.table.row>
                    @endforelse
                </x-slot>
            </x-bit.table>

            <div>
                {{ $donations->links() }}
            </div>
        </div>
    </div>

    <x-bit.modal.dialog wire:model="thankYouModal" max-width="sm">
        <x-slot name="title">{{ $thankYouTitle }}</x-slot>

        <x-slot name="content">
            {!! markdown($thankYouContent) !!}
        </x-slot>

        <x-slot name="footer">
            <x-bit.button.flat.secondary size="xs" wire:click="$set('thankYouModal', false)">Close</x-bit.button.flat.secondary>
        </x-slot>
    </x-bit.modal.dialog>

</div>
