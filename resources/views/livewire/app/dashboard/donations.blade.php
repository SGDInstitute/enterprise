<div class="space-y-8">
    <h1 class="text-2xl text-gray-900 dark:text-gray-200">Donations</h1>

    <div class="space-y-8">
        @if ($subscription)
            <div class="overflow-hidden rounded-md bg-white shadow dark:bg-gray-800">
                <div class="space-y-4 px-8 py-6 md:flex md:items-center md:justify-between md:space-x-4 md:space-y-0">
                    <div>
                        <span class="text-3xl text-gray-900 dark:text-gray-200">
                            {{ $subscription->formattedAmount }}
                        </span>
                        <span class="text-base text-gray-600 dark:text-gray-400">/monthly</span>
                    </div>

                    @if ($subscription->card)
                        <div>
                            <p class="text-gray-700 dark:text-gray-400">Card Used</p>
                            <p class="text-xl text-gray-900 dark:text-gray-200">
                                {{ strtoupper($subscription->card->brand) }}
                                {{ $subscription->card->last4 }}
                            </p>
                        </div>
                    @endif

                    <div>
                        <p class="text-gray-700 dark:text-gray-400">Last Bill Date</p>
                        <p class="text-xl text-gray-900 dark:text-gray-200">{{ $subscription->last_bill_date }}</p>
                    </div>

                    <div>
                        <p class="text-gray-700 dark:text-gray-400">Next Bill Date</p>
                        <p class="text-xl text-gray-900 dark:text-gray-200">{{ $subscription->next_bill_date }}</p>
                    </div>
                </div>

                <div class="w-full space-x-1 bg-gray-50 px-8 py-2 dark:bg-gray-850 md:flex md:justify-end">
                    <x-bit.button.link size="px-2 py-1" wire:click="openPortal">Change Amount</x-bit.button.link>
                    <x-bit.button.link size="px-2 py-1" wire:click="openPortal">Update Card</x-bit.button.link>
                    @if ($subscription->status !== 'canceled')
                        <x-bit.button.link size="px-2 py-1" wire:click="cancel({{ $subscription->id }})">
                            Cancel
                        </x-bit.button.link>
                    @else
                        <x-bit.button.link size="px-2 py-1" wire:click="openPortal">Renew</x-bit.button.link>
                    @endif
                </div>
            </div>
        @endif

        @if ($donations->count() > 0)
            <div class="mt-5 flex-col space-y-4">
                <div class="md:flex md:items-center md:justify-between">
                    @if ($subscription)
                        <h2 class="text-xl text-gray-900 dark:text-gray-200">One-Time Donations</h2>
                    @endif

                    <div class="mt-4 flex items-end md:mt-0">
                        <x-bit.data-table.per-page wire:model.live="perPage" />
                    </div>
                </div>

                <x-bit.table>
                    <x-slot name="head">
                        <x-bit.table.heading>Date Donated</x-bit.table.heading>
                        <x-bit.table.heading>Type</x-bit.table.heading>
                        <x-bit.table.heading>Amount</x-bit.table.heading>
                        <x-bit.table.heading>Status</x-bit.table.heading>
                    </x-slot>

                    <x-slot name="body">
                        @forelse ($donations as $donation)
                            <x-bit.table.row wire:key="row-{{ $donation->id }}">
                                <x-bit.table.cell>
                                    {{ $donation->created_at->timezone('America/Chicago')->format('M, d Y') }}
                                </x-bit.table.cell>
                                <x-bit.table.cell>{{ $donation->formattedType }}</x-bit.table.cell>
                                <x-bit.table.cell>{{ $donation->formattedAmount }}</x-bit.table.cell>
                                <x-bit.table.cell>{{ $donation->status }}</x-bit.table.cell>
                            </x-bit.table.row>
                        @empty
                            <x-bit.table.row>
                                <x-bit.table.cell colspan="9">
                                    <div class="flex items-center justify-center space-x-2">
                                        <x-heroicon-o-users class="h-8 w-8 text-gray-400" />
                                        <span class="py-8 text-xl font-medium text-gray-500 dark:text-gray-400">
                                            No donations found...
                                        </span>
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
        @endif
    </div>

    <x-bit.modal.dialog wire:model.live="thankYouModal" max-width="sm">
        <x-slot name="title">{{ $thankYouTitle }}</x-slot>

        <x-slot name="content">
            <div class="prose dark:prose-light">
                {!! markdown($thankYouContent) !!}
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-bit.button.flat.secondary size="xs" wire:click="$set('thankYouModal', false)">
                Close
            </x-bit.button.flat.secondary>
        </x-slot>
    </x-bit.modal.dialog>
</div>
