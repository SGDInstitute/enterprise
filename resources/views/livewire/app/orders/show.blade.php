<div class="container px-12 py-12 mx-auto space-y-8">
    <div class="space-y-4">
        <h1 class="text-2xl font-bold leading-7 text-gray-900 dark:text-gray-100 sm:text-3xl sm:truncate">{{ $order->event->name }} {{ $order->isPaid() ? 'Order Details' : 'Reservation Details'}}</h1>
        <nav aria-label="Progress">
            <ol class="border border-gray-300 divide-y divide-gray-300 rounded-md dark:bg-gray-700 dark:divide-gray-500 dark:border-gray-500 md:flex md:divide-y-0">
                <li class="relative md:flex-1 md:flex">
                    <a href="#" class="flex items-center w-full group">
                        <span class="flex items-center px-6 py-4 text-sm font-medium">
                            <span class="flex items-center justify-center flex-shrink-0 w-10 h-10 bg-green-500 rounded-full group-hover:bg-green-700">
                                <x-heroicon-s-check class="w-6 h-6 text-white" />
                            </span>
                            <span class="ml-4 text-sm font-medium text-gray-900 dark:text-gray-200">Create Reservation</span>
                        </span>
                    </a>

                    <!-- Arrow separator for lg screens and up -->
                    <div class="absolute top-0 right-0 hidden w-5 h-full md:block" aria-hidden="true">
                        <svg class="w-full h-full text-gray-300 dark:text-gray-500" viewBox="0 0 22 80" fill="none" preserveAspectRatio="none">
                            <path d="M0 -2L20 40L0 82" vector-effect="non-scaling-stroke" stroke="currentcolor" stroke-linejoin="round" />
                        </svg>
                    </div>
                </li>

                <li class="relative md:flex-1 md:flex">
                    <!-- Current Step -->
                    <a href="#" class="flex items-center px-6 py-4 text-sm font-medium" aria-current="step">
                        <span class="flex items-center justify-center flex-shrink-0 w-10 h-10 border-2 border-green-500 rounded-full">
                            <span class="text-green-600">02</span>
                        </span>
                        <span class="ml-4 text-sm font-medium text-green-600">Pay</span>
                    </a>

                    <!-- Arrow separator for lg screens and up -->
                    <div class="absolute top-0 right-0 hidden w-5 h-full md:block" aria-hidden="true">
                        <svg class="w-full h-full text-gray-300 dark:text-gray-500" viewBox="0 0 22 80" fill="none" preserveAspectRatio="none">
                            <path d="M0 -2L20 40L0 82" vector-effect="non-scaling-stroke" stroke="currentcolor" stroke-linejoin="round" />
                        </svg>
                    </div>
                </li>

                <li class="relative md:flex-1 md:flex">
                    <!-- Upcoming Step -->
                    <a href="#" class="flex items-center group">
                        <span class="flex items-center px-6 py-4 text-sm font-medium">
                            <span class="flex items-center justify-center flex-shrink-0 w-10 h-10 border-2 border-gray-300 rounded-full dark:border-gray-500 group-hover:border-gray-400">
                                <span class="text-gray-500 group-hover:text-gray-900">03</span>
                            </span>
                            <span class="ml-4 text-sm font-medium text-gray-500 dark:text-gray-400 group-hover:text-gray-900">Add Folks to Tickets</span>
                        </span>
                    </a>

                    <div class="absolute top-0 right-0 hidden w-5 h-full md:block" aria-hidden="true">
                        <svg class="w-full h-full text-gray-300 dark:text-gray-500" viewBox="0 0 22 80" fill="none" preserveAspectRatio="none">
                            <path d="M0 -2L20 40L0 82" vector-effect="non-scaling-stroke" stroke="currentcolor" stroke-linejoin="round" />
                        </svg>
                    </div>
                </li>

                <li class="relative md:flex-1 md:flex">
                    <!-- Upcoming Step -->
                    <a href="#" class="flex items-center group">
                        <span class="flex items-center px-6 py-4 text-sm font-medium">
                            <span class="flex items-center justify-center flex-shrink-0 w-10 h-10 border-2 border-gray-300 rounded-full dark:border-gray-500 group-hover:border-gray-400">
                                <span class="text-gray-500 group-hover:text-gray-900">04</span>
                            </span>
                            <span class="ml-4 text-sm font-medium text-gray-500 dark:text-gray-400 group-hover:text-gray-900">Get Ready</span>
                        </span>
                    </a>
                </li>
            </ol>
        </nav>
    </div>

    <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
        <div class="space-y-4">
            <div class="block h-64 transition duration-150 ease-in-out bg-green-500 shadow">
                <div class="bg-center bg-cover h-1/2" style="background-image: url({{ $order->event->backgroundUrl }});">
                    <img src="{{ $order->event->backgroundUrl }}" alt="{{ $order->event->name }}" class="sr-only">
                </div>
                <div class="px-4 py-2 mx-4 -mt-8 transition duration-150 ease-in-out bg-green-500">
                    <p class="text-2xl text-gray-200">{{ $order->event->name }}</p>
                    <p class="text-sm text-gray-300 text-italic">{{ $order->event->formattedDuration }}</p>
                    <p class="text-sm text-gray-300 text-italic">{{ $order->event->formattedLocation }}</p>
                    <p class="flex items-center mt-2 space-x-2 text-lg text-gray-900 dark:text-gray-200 text-italic group-hover:text-gray-200">
                        <x-heroicon-o-ticket class="w-6 h-6" />
                        <span>{{ $order->tickets->count() }} Tickets</span>
                    </p>
                </div>
            </div>

            <div class="p-4 space-y-2 bg-gray-100 shadow dark:bg-gray-700">
                <p class="text-xl font-bold text-gray-700 dark:text-gray-400">{{ $subtotal }}</p>
                <p class="text-gray-700 dark:text-gray-400">Tickets filled: {{ $filledCount }} of {{ $order->tickets->count() }}</p>
            </div>

            <div class="grid grid-cols-1 overflow-hidden bg-gray-100 divide-y divide-gray-200 shadow dark:divide-gray-800 dark:bg-gray-700">
                @if($order->isPaid() && auth()->id() === $order->user_id)
                <button class="flex items-center w-full px-6 py-4 space-x-4 text-gray-900 hover:bg-gray-200 dark:hover:bg-gray-900 dark:text-gray-200">
                    <x-heroicon-o-receipt-tax class="w-6 h-6" />
                    <span>View Receipt</span>
                </button>
                @else
                <button class="flex items-center w-full px-6 py-4 space-x-4 text-gray-900 hover:bg-gray-200 dark:hover:bg-gray-900 dark:text-gray-200">
                    <x-heroicon-o-credit-card class="w-6 h-6" />
                    <span>Pay with Card</span>
                </button>
                <button class="flex items-center w-full px-6 py-4 space-x-4 text-gray-900 hover:bg-gray-200 dark:hover:bg-gray-900 dark:text-gray-200">
                    <x-heroicon-o-mail class="w-6 h-6" />
                    <span>Pay with Check</span>
                </button>
                @endif
                <button class="flex items-center w-full px-6 py-4 space-x-4 text-gray-900 hover:bg-gray-200 dark:hover:bg-gray-900 dark:text-gray-200">
                    <x-heroicon-o-document-text class="w-6 h-6" />
                    <span>Create Invoice</span>
                </button>
                <button wire:click="download" class="flex items-center w-full px-6 py-4 space-x-4 text-gray-900 hover:bg-gray-200 dark:hover:bg-gray-900 dark:text-gray-200">
                    <x-heroicon-o-document-download class="w-6 h-6" />
                    <span>Download W-9</span>
                </button>
                @if(!$order->isPaid() && auth()->id() === $order->user_id)
                <button wire:click="delete" onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" class="flex items-center w-full px-6 py-4 space-x-4 text-gray-900 hover:bg-gray-200 dark:hover:bg-gray-900 dark:text-gray-200">
                    <x-heroicon-o-trash class="w-6 h-6" />
                    <span>Delete Order</span>
                </button>
                @endif
            </div>
        </div>
        <div class="space-y-4 md:col-span-2">
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
                        <x-bit.button.round.primary wire:click="save">Save Changes</x-bit.button.round.primary>
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
        </div>
    </div>

    <form wire:submit.prevent="{{ $editingTicket ? 'editUser' : 'addUser' }}">
        <x-bit.modal.dialog wire:model.defer="showTicketholderModal" max-width="lg">
            <x-slot name="title">
                {{ $editingTicket ? 'Edit' : 'Add' }} Ticketholder
            </x-slot>

            <x-slot name="content">
                <div class="space-y-4">
                    @if($editingTicket === null || $editingTicket->id === auth()->id())
                    <x-bit.button.round.secondary size="xs" wire:click="loadAuthUser">Load My Information</x-bit.button.round.secondary>
                    @endif
                    <x-bit.input.group for="ticketholder-email" label="Email">
                        <x-bit.input.text class="w-full mt-1" type="email" id="ticketholder-email" wire:model.lazy="ticketholder.email" />
                    </x-bit.input.group>
                    <x-bit.input.group for="ticketholder-name" label="Name">
                        <x-bit.input.text class="w-full mt-1" type="text" id="ticketholder-name" wire:model="ticketholder.name" />
                    </x-bit.input.group>
                    <x-bit.input.group for="ticketholder-pronouns" label="Pronouns">
                        <x-bit.input.text class="w-full mt-1" type="text" id="ticketholder-pronouns" wire:model="ticketholder.pronouns" />
                    </x-bit.input.group>
                </div>
            </x-slot>

            <x-slot name="footer">
                <div class="space-x-2">
                <x-bit.button.flat.secondary wire:click="$set('showTicketholderModal', false)">Cancel</x-bit.button.flat.secondary>

                @if($editingTicket)
                    <x-bit.button.flat.primary type="submit" wire:click="$set('continue', false)">Save</x-bit.button.flat.primary>
                @else
                    <x-bit.button.flat.primary type="submit" wire:click="$set('continue', false)">Add</x-bit.button.flat.primary>
                    <x-bit.button.flat.primary type="submit" wire:click="$set('continue', true)">Add & Add Another</x-bit.button.flat.primary>
                @endif
                </div>
            </x-slot>
        </x-bit.modal.dialog>
    </form>
</div>
