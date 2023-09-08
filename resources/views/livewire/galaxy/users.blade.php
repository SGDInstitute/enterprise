<div class="flex-col mt-5 space-y-4">
    <div class="md:flex md:justify-between">
        <div class="flex flex-col space-y-4 md:items-end md:space-x-4 md:flex-row md:w-1/2">
            <x-bit.input.text wire:model.live="filters.search" x-on:keydown.slash="this.focus()" placeholder="Search Users..." />
        </div>
        <div class="flex items-end mt-4 space-x-4 md:mt-0">
            <x-bit.data-table.per-page />
            <x-bit.button.round.secondary :href="route('galaxy.users.create')" class="flex items-center space-x-2">
                <x-heroicon-o-plus class="w-4 h-4 text-gray-400 dark:text-gray-300" /> <span>Create</span>
            </x-bit.button.round.secondary>
        </div>
    </div>

    <x-bit.table>
        <x-slot name="head">
            <x-bit.table.heading sortable wire:click="sortBy('id')" :direction="$sortField === 'id' ? $sortDirection : null">ID</x-bit.table.heading>
            <x-bit.table.heading sortable wire:click="sortBy('name')" :direction="$sortField === 'name' ? $sortDirection : null">Name</x-bit.table.heading>
            <x-bit.table.heading sortable wire:click="sortBy('email')" :direction="$sortField === 'email' ? $sortDirection : null">Email</x-bit.table.heading>
            <x-bit.table.heading sortable wire:click="sortBy('verified')" :direction="$sortField === 'verified' ? $sortDirection : null">Verified</x-bit.table.heading>
            <x-bit.table.heading sortable wire:click="sortBy('created_at')" :direction="$sortField === 'created_at' ? $sortDirection : null">Created At</x-bit.table.heading>
            <x-bit.table.heading />
        </x-slot>

        <x-slot name="body">
            @forelse ($users as $user)
            <x-bit.table.row wire:key="row-{{ $user->id }}">
                <x-bit.table.cell>
                    {{ $user->id }}
                </x-bit.table.cell>

                <x-bit.table.cell>
                    <x-bit.link href="{{ route('galaxy.users.show', $user) }}">{{ $user->name }}</x-bit.link>
                </x-bit.table.cell>

                <x-bit.table.cell>
                    <x-bit.link href="{{ route('galaxy.users.show', $user) }}">{{ $user->email }}</x-bit.link>
                </x-bit.table.cell>

                <x-bit.table.cell>
                    @if ($user->email_verified_at)
                        <x-heroicon-o-thumb-up class="w-4 h-4 text-green-500" />
                    @else
                        <x-heroicon-o-thumb-down class="w-4 h-4 text-red-400" />
                    @endif
                </x-bit.table.cell>

                <x-bit.table.cell>{{ $user->created_at->format('M, d Y') }}</x-bit.table.cell>

                <x-bit.table.cell>
                    <x-bit.button.link size="py-1 px-2" href="{{ route('galaxy.users.show', $user) }}">
                        <x-heroicon-o-eye class="w-4 h-4 text-blue-500 dark:text-blue-400" />
                    </x-bit.button.link>
                    <x-bit.button.link size="py-1 px-2" wire:click="impersonate({{ $user->id }})">
                        <x-heroicon-o-support class="w-4 h-4 text-blue-500 dark:text-blue-400" />
                    </x-bit.button.link>
                </x-bit.table.cell>

            </x-bit.table.row>
            @empty
            <x-bit.table.row >
                <x-bit.table.cell colspan="7">
                    <div class="flex items-center justify-center space-x-2">
                        <x-heroicon-o-users class="w-8 h-8 text-gray-400" />
                        <span class="py-8 text-xl font-medium text-gray-500 dark:text-gray-400 ">No users found...</span>
                    </div>
                </x-bit.table.cell>
            </x-bit.table.row>
            @endforelse
        </x-slot>
    </x-bit.table>

    <div>
        {{ $users->links() }}
    </div>
</div>
