<div>
    <div class="flex-col mt-5 space-y-4">
        <div class="md:flex md:justify-between">
            <div class="flex flex-col space-y-4 md:items-end md:space-x-4 md:flex-row md:w-1/2">
                <x-bit.input.text type="text" wire:model="filters.search" placeholder="Search Proposals..." />
            </div>
            <div class="flex items-end mt-4 md:mt-0">
                <x-bit.data-table.per-page />
            </div>
        </div>

        <x-bit.table>
            <x-slot name="head">
                <x-bit.table.heading>Name</x-bit.table.heading>
                <x-bit.table.heading>Workshop</x-bit.table.heading>
                <x-bit.table.heading>Status</x-bit.table.heading>
                <x-bit.table.heading>Created At</x-bit.table.heading>
                <x-bit.table.heading />
            </x-slot>

            <x-slot name="body">
                @forelse($workshops as $workshop)
                <x-bit.table.row wire:key="row-{{ $workshop->id }}">
                    <x-bit.table.cell>{{ $workshop->form->name }}</x-bit.table.cell>
                    <x-bit.table.cell>{{ $workshop->name  }}</x-bit.table.cell>
                    <x-bit.table.cell>{{ $workshop->status }}</x-bit.table.cell>
                    <x-bit.table.cell>{{ $workshop->created_at->format('M, d Y') }}</x-bit.table.cell>

                    <x-bit.table.cell>
                        <x-bit.button.link size="py-1 px-2" href="{{ route('galaxy.responses.show', ['response' => $workshop]) }}">
                            <x-heroicon-o-eye class="w-4 h-4 text-green-500 dark:text-green-400" />
                        </x-bit.button.link>
                    </x-bit.table.cell>

                </x-bit.table.row>
                @empty
                <x-bit.table.row>
                    <x-bit.table.cell colspan="9">
                        <div class="flex items-center justify-center space-x-2">
                            <x-heroicon-o-users class="w-8 h-8 text-gray-400" />
                            <span class="py-8 text-xl font-medium text-gray-500 dark:text-gray-400 glacial">No workshops found...</span>
                        </div>
                    </x-bit.table.cell>
                </x-bit.table.row>
                @endforelse
            </x-slot>
        </x-bit.table>

        <div>
            {{ $workshops->links() }}
        </div>
    </div>

</div>
