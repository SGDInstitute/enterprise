<div>
    <div class="flex-col mt-5 space-y-4">
        <div class="md:flex md:justify-between">
            <div class="flex flex-col space-y-4 md:items-end md:space-x-4 md:flex-row">
                <x-bit.input.text type="text" wire:model.live="filters.search" placeholder="Search donations..." />
            </div>
            <div class="flex items-end mt-4 space-x-2 md:mt-0">
                <x-bit.data-table.per-page />
            </div>
        </div>

        <x-bit.table>
            <x-slot name="head">
                <x-bit.table.heading class="w-8 pr-0">
                    <x-form.checkbox id="select-page" wire:model.live="selectPage" />
                </x-bit.table.heading>
                <x-bit.table.heading sortable wire:click="sortBy('id')" :direction="$sortField === 'id' ? $sortDirection : null">ID</x-bit.table.heading>
                @if ($this->user === null)
                <x-bit.table.heading sortable wire:click="sortBy('users.name')" :direction="$sortField === 'users.name' ? $sortDirection : null">User</x-bit.table.heading>
                @endif
                <x-bit.table.heading sortable wire:click="sortBy('type')" :direction="$sortField === 'type' ? $sortDirection : null">Type</x-bit.table.heading>
                <x-bit.table.heading sortable wire:click="sortBy('amount')" :direction="$sortField === 'amount' ? $sortDirection : null">Amount</x-bit.table.heading>
                <x-bit.table.heading sortable wire:click="sortBy('status')" :direction="$sortField === 'status' ? $sortDirection : null">Status</x-bit.table.heading>
                <x-bit.table.heading sortable wire:click="sortBy('created_at')" :direction="$sortField === 'created_at' ? $sortDirection : null">Created At</x-bit.table.heading>
                <x-bit.table.heading />
            </x-slot>

            <x-slot name="body">
                @if ($selectPage)
                <x-bit.table.row class="bg-gray-200" wire:key="row-message">
                    <x-bit.table.cell colspan="11">
                        @unless ($selectAll)
                        <div>
                            <span>You have selected <strong>{{ $donations->count() }}</strong> donations, do you want to select all <strong>{{ number_format($donations->total()) }}</strong>?</span>
                            <x-bit.button.link wire:click="selectAll" class="ml-1 text-blue-600">Select All</x-bit.button.link>
                        </div>
                        @else
                        <span>You have selected all <strong>{{ number_format($donations->total()) }}</strong> donations.</span>
                        @endif
                    </x-bit.table.cell>
                </x-bit.table.row>
                @endif

                @forelse ($donations as $donation)
                <x-bit.table.row wire:key="row-{{ $donation->id }}">
                    <x-bit.table.cell class="pr-0">
                        <x-form.checkbox id="select-donation-{{ $donation->id }}" wire:model.live="selected" value="{{ $donation->id }}" />
                    </x-bit.table.cell>
                    <x-bit.table.cell>{{ $donation->id }}</x-bit.table.cell>
                    @if ($this->user === null)
                    <x-bit.table.cell><a href="{{ route('galaxy.users.show', $donation->user) }}" class="hover:underline">{{ $donation->user->name }}</a></x-bit.table.cell>
                    @endif
                    <x-bit.table.cell>{{ $donation->formattedType }}</x-bit.table.cell>
                    <x-bit.table.cell>{{ $donation->formattedAmount }}</x-bit.table.cell>
                    <x-bit.table.cell>{{ $donation->status }}</x-bit.table.cell>
                    <x-bit.table.cell>{{ $donation->created_at->format('M, d Y') }}</x-bit.table.cell>

                    <x-bit.table.cell>
                        <x-bit.button.link size="py-1 px-2" href="{{ route('galaxy.donations.show', $donation) }}">
                            <x-heroicon-o-eye class="w-4 h-4 text-green-500 dark:text-green-400" />
                        </x-bit.button.link>
                    </x-bit.table.cell>

                </x-bit.table.row>
                @empty
                <x-bit.table.row>
                    <x-bit.table.cell colspan="11">
                        <div class="flex items-center justify-center space-x-2">
                            <x-heroicon-o-gift class="w-8 h-8 text-gray-400" />
                            <span class="py-8 text-xl font-medium text-gray-500 dark:text-gray-400">No donations found...</span>
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
