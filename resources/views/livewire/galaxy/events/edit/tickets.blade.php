<div>
    <div class="mt-5 flex-col space-y-4">
        <div class="md:flex md:justify-between">
            <div class="flex flex-col space-y-4 md:w-1/2 md:flex-row md:items-end md:space-x-4">
                <x-bit.input.group for="search" label="Search" sr-only>
                    <x-bit.input.text
                        id="search"
                        class="mt-1 block w-full"
                        type="text"
                        name="search"
                        placeholder="Search Ticket Types..."
                        wire:model.live="filters.search"
                    />
                </x-bit.input.group>
            </div>
            <div class="mt-4 flex items-end space-x-4 md:mt-0">
                <x-bit.data-table.per-page />
                <x-bit.dropdown title="Create" placement="right">
                    <x-bit.dropdown.item :href="route('galaxy.ticket-types.create.flat', ['event' => $event->id])">
                        Flat Price
                    </x-bit.dropdown.item>
                    <x-bit.dropdown.item :href="route('galaxy.ticket-types.create.scaled', ['event' => $event->id])">
                        Sliding Scale
                    </x-bit.dropdown.item>
                </x-bit.dropdown>
            </div>
        </div>

        <x-bit.table>
            <x-slot name="head">
                <x-bit.table.heading
                    sortable
                    wire:click="sortBy('name')"
                    :direction="$sortField === 'name' ? $sortDirection : null"
                >
                    Name
                </x-bit.table.heading>
                <x-bit.table.heading
                    sortable
                    wire:click="sortBy('type')"
                    :direction="$sortField === 'type' ? $sortDirection : null"
                >
                    Type
                </x-bit.table.heading>
                <x-bit.table.heading
                    sortable
                    wire:click="sortBy('cost')"
                    :direction="$sortField === 'cost' ? $sortDirection : null"
                >
                    Cost
                </x-bit.table.heading>
                <x-bit.table.heading
                    sortable
                    wire:click="sortBy('start')"
                    :direction="$sortField === 'start' ? $sortDirection : null"
                >
                    Start
                </x-bit.table.heading>
                <x-bit.table.heading
                    sortable
                    wire:click="sortBy('end')"
                    :direction="$sortField === 'end' ? $sortDirection : null"
                >
                    End
                </x-bit.table.heading>
                <x-bit.table.heading class="flex space-x-1">
                    <x-bit.button.link size="py-1 px-2">
                        <x-heroicon-o-pencil class="h-4 w-4 text-green-500 dark:text-green-400" />
                    </x-bit.button.link>
                    <x-bit.button.link size="py-1 px-2">
                        <x-heroicon-o-trash class="h-4 w-4 text-green-500 dark:text-green-400" />
                    </x-bit.button.link>
                </x-bit.table.heading>
            </x-slot>

            <x-slot name="body">
                @forelse ($ticketTypes as $ticketType)
                    <x-bit.table.row wire:key="row-{{ $ticketType->id }}">
                        <x-bit.table.cell>{{ $ticketType->name }}</x-bit.table.cell>
                        <x-bit.table.cell>{{ $ticketType->structure }}</x-bit.table.cell>
                        <x-bit.table.cell>{{ $ticketType->priceRange }}</x-bit.table.cell>
                        <x-bit.table.cell>{{ $ticketType->formattedStart }}</x-bit.table.cell>
                        <x-bit.table.cell>{{ $ticketType->formattedEnd }}</x-bit.table.cell>
                        <x-bit.table.cell class="flex space-x-1">
                            <x-bit.button.link size="py-1 px-2" :href="route('galaxy.ticket-types.edit', $ticketType)">
                                <x-heroicon-o-pencil class="h-4 w-4 text-green-500 dark:text-green-400" />
                            </x-bit.button.link>
                            <x-bit.button.link size="py-1 px-2" wire:click="remove({{ $ticketType->id }})">
                                <x-heroicon-o-trash class="h-4 w-4 text-green-500 dark:text-green-400" />
                            </x-bit.button.link>
                        </x-bit.table.cell>
                    </x-bit.table.row>
                @empty
                    <x-bit.table.row>
                        <x-bit.table.cell colspan="7">
                            <div class="flex items-center justify-center space-x-2">
                                <x-heroicon-o-ticket class="h-8 w-8 text-gray-400" />
                                <span class="py-8 text-xl font-medium text-gray-500 dark:text-gray-400">
                                    No ticket types found...
                                </span>
                            </div>
                        </x-bit.table.cell>
                    </x-bit.table.row>
                @endforelse
            </x-slot>
        </x-bit.table>

        <div>
            {{ $ticketTypes->links() }}
        </div>
    </div>
</div>
