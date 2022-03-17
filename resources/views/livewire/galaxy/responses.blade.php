<div>
    <div class="flex-col mt-5 space-y-4">
        <div class="md:flex md:justify-between">
            <div class="flex flex-col space-y-4 md:items-end md:space-x-4 md:flex-row md:w-1/2">
                <x-bit.input.text type="text" wire:model="filters.search" placeholder="Search..." />
            </div>
            <div class="flex items-end mt-4 md:mt-0">
                <x-bit.data-table.per-page />
            </div>
        </div>

        <x-bit.table>
            <x-slot name="head">
                <x-bit.table.heading>Status</x-bit.table.heading>
                @forelse ($form->settings->searchable as $label)
                <x-bit.table.heading>{{ str_replace(['question', '_', '-'], '', $label) }}</x-bit.table.heading>
                @empty
                <x-bit.table.heading>Workshop</x-bit.table.heading>
                @endforelse
                <x-bit.table.heading>Created At</x-bit.table.heading>
                <x-bit.table.heading />
            </x-slot>

            <x-slot name="body">
                @forelse ($workshops as $workshop)
                <x-bit.table.row wire:key="row-{{ $workshop->id }}">
                    <x-bit.table.cell class="flex items-center space-x-1">
                        <span>{{ $workshop->status }}</span>
                        @if (isset($assignedWorkshops[$workshop->id]))
                        <x-bit.button.link size="py-1 px-2" wire:click="editItem({{ $assignedWorkshops[$workshop->id] }})">
                            <x-heroicon-o-pencil class="w-4 h-4 text-green-500 dark:text-green-400" />
                        </x-bit.button.link>
                        @elseif ($workshop->status === 'approved' && $event->items->count() > 0)
                        <x-bit.button.link size="py-1 px-2" wire:click="assignTime({{ $workshop->id }})">
                            <x-heroicon-o-calendar class="w-4 h-4 text-green-500 dark:text-green-400" />
                        </x-bit.button.link>
                        @endif
                    </x-bit.table.cell>
                    @forelse ($form->settings->searchable as $item)
                    <x-bit.table.cell>
                        {{ $workshop->answers[$item] ?? '?' }}
                    </x-bit.table.cell>
                    @empty
                    <x-bit.table.cell>{{ $workshop->name }}</x-bit.table.cell>
                    @endforelse
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
                            <span class="py-8 text-xl font-medium text-gray-500 dark:text-gray-400 ">No {{ $type ?? 'responses' }} found...</span>
                        </div>
                    </x-bit.table.cell>
                </x-bit.table.row>
                @endforelse
            </x-slot>
        </x-bit.table>

        <div>
            {{ $responses->links() }}
        </div>
    </div>

</div>
