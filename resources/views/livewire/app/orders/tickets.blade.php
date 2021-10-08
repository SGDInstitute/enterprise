<div class="space-y-4">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-bold leading-7 text-gray-900 dark:text-gray-100 sm:text-2xl sm:truncate">Tickets</h2>

        <span class="relative z-0 inline-flex rounded-md shadow-sm">
            <button wire:click="$set('ticketsView', 'table')" type="button" class="{{ $ticketsView === 'table' ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-200' : 'text-gray-500 bg-white dark:text-gray-400 dark:bg-gray-900' }} relative inline-flex items-center px-2 py-2 text-sm font-medium border border-gray-300 dark:border-gray-700 rounded-l-md hover:bg-gray-50 dark:hover:bg-gray-700 focus:z-10 focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500">
                <span class="sr-only">Table View</span>
                <x-heroicon-o-table class="w-5 h-5" />
            </button>
            <button wire:click="$set('ticketsView', 'grid')" type="button" class="{{ $ticketsView === 'grid' ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-200' : 'text-gray-500 bg-white dark:text-gray-400 dark:bg-gray-900' }} relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium border border-gray-300 dark:border-gray-700 rounded-r-md hover:bg-gray-50 dark:hover:bg-gray-700 focus:z-10 focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500">
                <span class="sr-only">Grid View</span>
                <x-heroicon-o-view-grid class="w-5 h-5" />
            </button>
        </span>
    </div>

    @if($ticketsView === 'table')
    <div class="flex-col mt-5 space-y-4">
        <div class="md:flex md:justify-between">
            <x-bit.input.text type="text" wire:model="filters.search" placeholder="Search tickets..." />
            <div class="flex space-x-4">
                <x-bit.data-table.per-page />
                @if(!$editMode)
                <x-bit.button.round.secondary wire:click="enableEditMode">Enable In-line Editing</x-bit.button.round.secondary>
                @else
                <x-bit.button.round.secondary wire:click="$set('editMode', false)">Disable Editing</x-bit.button.round.secondary>
                <x-bit.button.round.primary wire:click="saveTickets">Save Changes</x-bit.button.round.primary>
                @endif
            </div>
        </div>

        @if(!$editMode)
        @include('livewire.app.orders.partials.table-tickets')
        @else
        @include('livewire.app.orders.partials.table-tickets-editable')
        @endif

        <div>
            {{ $tickets->links() }}
        </div>
    </div>
    @else
    @include('livewire.app.orders.partials.grid-tickets')
    @endif

    @if($editingTicket)
    @include('livewire.app.orders.partials.ticket-modal')
    @endif
</div>
