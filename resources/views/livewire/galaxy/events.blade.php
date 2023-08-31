<div>
    <div class="flex-col mt-5 space-y-4">
        <div class="md:flex md:justify-between">
            <div class="flex flex-col space-y-4 md:items-end md:space-x-4 md:flex-row md:w-1/2">
                <x-bit.input.group for="search" label="Search" sr-only>
                    <x-bit.input.text id="search" class="block w-full mt-1" type="text" name="search" placeholder="Search Events..." wire:model.live="filters.search" />
                </x-bit.input.group>
            </div>
            <div class="flex items-end mt-4 space-x-4 md:mt-0">
                <x-bit.data-table.per-page />
                <x-bit.button.round.secondary :href="route('galaxy.events.create')" class="flex items-center space-x-2">
                    <x-heroicon-o-plus class="w-4 h-4 text-gray-400 dark:text-gray-300" /> <span>Create</span>
                </x-bit.button.round.secondary>
            </div>
        </div>

        <x-bit.table>
            <x-slot name="head">
                <x-bit.table.heading sortable wire:click="sortBy('name')" :direction="$sortField === 'name' ? $sortDirection : null">Name</x-bit.table.heading>
                <x-bit.table.heading sortable wire:click="sortBy('start')" :direction="$sortField === 'start' ? $sortDirection : null">Start</x-bit.table.heading>
                <x-bit.table.heading sortable wire:click="sortBy('end')" :direction="$sortField === 'end' ? $sortDirection : null">End</x-bit.table.heading>
                <x-bit.table.heading sortable wire:click="sortBy('location')" :direction="$sortField === 'location' ? $sortDirection : null">Location</x-bit.table.heading>
                <x-bit.table.heading />
            </x-slot>

            <x-slot name="body">
                @forelse ($events as $event)
                <x-bit.table.row wire:key="row-{{ $event->id }}">
                    <x-bit.table.cell><div class="w-64 truncate">{{ $event->name }}</div></x-bit.table.cell>
                    <x-bit.table.cell>{{ $event->formattedStart }} {{ $event->formattedTimezone }}</x-bit.table.cell>
                    <x-bit.table.cell>{{ $event->formattedEnd }} {{ $event->formattedTimezone }}</x-bit.table.cell>
                    <x-bit.table.cell>{{ $event->location }}</x-bit.table.cell>
                    <x-bit.table.cell class="flex space-x-1">
                        <x-bit.button.link size="py-1 px-2" href="{{ route('galaxy.events.show', ['event' => $event ]) }}">
                            <x-heroicon-o-eye class="w-4 h-4 text-green-500 dark:text-green-400" />
                        </x-bit.button.link>
                        <x-bit.button.link size="py-1 px-2" href="{{ route('galaxy.events.edit', ['event' => $event ]) }}">
                            <x-heroicon-o-cog class="w-4 h-4 text-green-500 dark:text-green-400" />
                        </x-bit.button.link>
                    </x-bit.table.cell>

                </x-bit.table.row>
                @empty
                <x-bit.table.row>
                    <x-bit.table.cell colspan="7">
                        <div class="flex items-center justify-center space-x-2">
                            <x-heroicon-o-calendar class="w-8 h-8 text-gray-400" />
                            <span class="py-8 text-xl font-medium text-gray-500 dark:text-gray-400 ">No events found...</span>
                        </div>
                    </x-bit.table.cell>
                </x-bit.table.row>
                @endforelse
            </x-slot>
        </x-bit.table>

        <div>
            {{ $events->links() }}
        </div>
    </div>
</div>
