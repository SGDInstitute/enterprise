<div class="space-y-4">
    <div class="md:flex md:justify-between">
        <div class="flex flex-col space-y-4 md:items-end md:space-x-4 md:flex-row md:w-1/2">
            <x-bit.input.text type="text" wire:model.live="filters.search" placeholder="Search..." />
        </div>
        <div class="flex items-end mt-4 md:mt-0">
            <x-bit.data-table.per-page />
        </div>
    </div>

    <x-bit.table>
        <x-slot name="head">
            <x-bit.table.heading></x-bit.table.heading>
            <x-bit.table.heading sortable wire:click="sortBy('ticket_id')" :direction="$sortField === 'ticket_id' ? $sortDirection : null">Ticket ID</x-bit.table.heading>
            <x-bit.table.heading sortable wire:click="sortBy('user_id')" :direction="$sortField === 'user_id' ? $sortDirection : null">User ID</x-bit.table.heading>
            <x-bit.table.heading sortable wire:click="sortBy('name')" :direction="$sortField === 'name' ? $sortDirection : null">Name</x-bit.table.heading>
            <x-bit.table.heading sortable wire:click="sortBy('pronouns')" :direction="$sortField === 'pronouns' ? $sortDirection : null">Pronouns</x-bit.table.heading>
            <x-bit.table.heading sortable wire:click="sortBy('email')" :direction="$sortField === 'email' ? $sortDirection : null">Email</x-bit.table.heading>
            <x-bit.table.heading sortable wire:click="sortBy('printed')" :direction="$sortField === 'printed' ? $sortDirection : null">Printed</x-bit.table.heading>
            <x-bit.table.heading sortable wire:click="sortBy('created_at')" :direction="$sortField === 'created_at' ? $sortDirection : null">Created At</x-bit.table.heading>
        </x-slot>

        <x-slot name="body">
            @forelse ($queue as $item)
            <x-bit.table.row wire:key="row-{{ $item->id }}">
                <x-bit.table.cell class="pr-0">
                    <x-bit.input.checkbox wire:model.live="selected" value="{{ $item->id }}" />
                </x-bit.table.cell>
                <x-bit.table.cell>{{ $item->ticket_id }}</x-bit.table.cell>
                <x-bit.table.cell>{{ $item->user_id }}</x-bit.table.cell>
                <x-bit.table.cell>{{ $item->name }}</x-bit.table.cell>
                <x-bit.table.cell>{{ $item->pronouns }}</x-bit.table.cell>
                <x-bit.table.cell>{{ $item->email }}</x-bit.table.cell>
                <x-bit.table.cell>{{ $item->printed ? 'Yes' : 'No' }}</x-bit.table.cell>
                <x-bit.table.cell>{{ $item->created_at }}</x-bit.table.cell>
            </x-bit.table.row>
            @empty
            <x-bit.table.row>
                <x-bit.table.cell colspan="9">
                    <div class="flex items-center justify-center space-x-2">
                        <x-heroicon-o-calendar class="w-8 h-8 text-gray-400" />
                        <span class="py-8 text-xl font-medium text-gray-500 dark:text-gray-400 ">No badges in queue...</span>
                    </div>
                </x-bit.table.cell>
            </x-bit.table.row>
            @endforelse
        </x-slot>
    </x-bit.table>

    <div>
        {{ $queue->links() }}
    </div>
</div>
