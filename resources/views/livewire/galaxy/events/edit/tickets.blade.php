<div>
    <div class="flex-col mt-5 space-y-4">
        <div class="md:flex md:justify-between">
            <div class="flex flex-col space-y-4 md:items-end md:space-x-4 md:flex-row md:w-1/2">
                <x-bit.input.group for="search" label="Search" sr-only>
                    <x-bit.input.text id="search" class="block w-full mt-1" type="text" name="search" placeholder="Search Ticket Types..." wire:model="filters.search" />
                </x-bit.input.group>
            </div>
            <div class="flex items-end mt-4 space-x-4 md:mt-0">
                <x-bit.data-table.per-page />
                <x-bit.button.round.secondary wire:click="showCreateModal" class="flex items-center space-x-2">
                    <x-heroicon-o-plus class="w-4 h-4 text-gray-400 dark:text-gray-300" /> <span>Create</span>
                </x-bit.button.round.secondary>
            </div>
        </div>

        <x-bit.table>
            <x-slot name="head">
                <x-bit.table.heading sortable wire:click="sortBy('name')" :direction="$sortField === 'name' ? $sortDirection : null">Name</x-bit.table.heading>
                <x-bit.table.heading sortable wire:click="sortBy('type')" :direction="$sortField === 'type' ? $sortDirection : null">Type</x-bit.table.heading>
                <x-bit.table.heading sortable wire:click="sortBy('cost')" :direction="$sortField === 'cost' ? $sortDirection : null">Cost</x-bit.table.heading>
                <x-bit.table.heading sortable wire:click="sortBy('start')" :direction="$sortField === 'start' ? $sortDirection : null">Start</x-bit.table.heading>
                <x-bit.table.heading sortable wire:click="sortBy('end')" :direction="$sortField === 'end' ? $sortDirection : null">End</x-bit.table.heading>
                <x-bit.table.heading class="flex space-x-1">
                    <x-bit.button.link size="py-1 px-2">
                        <x-heroicon-o-pencil class="w-4 h-4 text-green-500 dark:text-green-400" />
                    </x-bit.button.link>
                    <x-bit.button.link size="py-1 px-2">
                        <x-heroicon-o-trash class="w-4 h-4 text-green-500 dark:text-green-400" />
                    </x-bit.button.link>
                </x-bit.table.heading>
            </x-slot>

            <x-slot name="body">
                @forelse($ticketTypes as $ticketType)
                <x-bit.table.row wire:key="row-{{ $ticketType->id }}">
                    <x-bit.table.cell>{{ $ticketType->name }}</x-bit.table.cell>
                    <x-bit.table.cell>{{ $ticketType->type }}</x-bit.table.cell>
                    <x-bit.table.cell>{{ $ticketType->formattedCost }}</x-bit.table.cell>
                    <x-bit.table.cell>{{ $ticketType->formattedStart }}</x-bit.table.cell>
                    <x-bit.table.cell>{{ $ticketType->formattedEnd }}</x-bit.table.cell>
                    <x-bit.table.cell class="flex space-x-1">
                        <x-bit.button.link size="py-1 px-2" wire:click="showEditModal({{ $ticketType->id }})">
                            <x-heroicon-o-pencil class="w-4 h-4 text-green-500 dark:text-green-400" />
                        </x-bit.button.link>
                        <x-bit.button.link size="py-1 px-2" wire:click="remove({{ $ticketType->id }})">
                            <x-heroicon-o-trash class="w-4 h-4 text-green-500 dark:text-green-400" />
                        </x-bit.button.link>
                    </x-bit.table.cell>

                </x-bit.table.row>
                @empty
                <x-bit.table.row>
                    <x-bit.table.cell colspan="7">
                        <div class="flex items-center justify-center space-x-2">
                            <x-heroicon-o-ticket class="w-8 h-8 text-gray-400" />
                            <span class="py-8 text-xl font-medium text-gray-500 dark:text-gray-400 glacial">No ticket types found...</span>
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

    <form wire:submit.prevent="save">
        <x-bit.modal.dialog wire:model.defer="showModal">
            <x-slot name="title">{{ $editing->id ? 'Edit' : 'Create' }} Ticket Type</x-slot>

            <x-slot name="content">
            <div class="grid grid-cols-1 gap-4 py-8 md:grid-cols-2">
                <x-bit.input.group for="ticket-name" label="Ticket Name">
                    <x-bit.input.text id="ticket-name" class="w-full mt-1" type="text" name="name" wire:model="editing.name" />
                </x-bit.input.group>
                <x-bit.input.group for="ticket-description" label="Description">
                    <x-bit.input.text id="ticket-description" class="w-full mt-1" type="text" name="description" wire:model="editing.description" />
                </x-bit.input.group>
                <x-bit.input.group for="ticket-type" label="Type">
                    <x-bit.input.select id="ticket-type" class="w-full mt-1" name="type" wire:model="editing.type">
                        <option value="">Select type</option>
                        <option value="regular">Regular</option>
                        <option value="discount">Discount</option>
                    </x-bit.input.select>
                </x-bit.input.group>
                <x-bit.input.group for="ticket-cost" label="Cost">
                    <x-bit.input.currency id="ticket-cost" class="w-full mt-1" type="text" name="cost" wire:model="costInDollars" />
                </x-bit.input.group>
                <x-bit.input.group for="start" label="Availability Start">
                    <x-bit.input.date-time class="block w-full mt-1" id="start" name="start" wire:model="formattedStart" />
                </x-bit.input.group>
                <x-bit.input.group for="end" label="Availability End">
                    <x-bit.input.date-time class="block w-full mt-1" id="end" name="end" wire:model="formattedEnd" />
                </x-bit.input.group>
                <x-bit.input.group for="ticket-num_tickets" label="Number of Tickets">
                    <x-bit.input.text id="ticket-num_tickets" class="w-full mt-1" type="text" name="num_tickets" wire:model="editing.num_tickets" />
                </x-bit.input.group>
            </div>
            </x-slot>

            <x-slot name="footer">
                <x-bit.button.flat.secondary wire:click="$set('showModal', false)">Close</x-bit.button.flat.secondary>
                <x-bit.button.flat.primary type="submit">Save</x-bit.button.flat.primary>
            </x-slot>
        </x-bit.modal.dialog>
    </form>

</div>
