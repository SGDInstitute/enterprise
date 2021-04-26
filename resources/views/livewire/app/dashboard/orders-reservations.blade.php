<div class="space-y-8">
    <h1 class="text-2xl dark:text-gray-200">Orders & Reservations</h1>

    @if($reservations->count() > 0)
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-lg dark:text-gray-200">Reservations</h2>

            <span class="relative z-0 inline-flex rounded-md shadow-sm">
                <button wire:click="$set('reservationsView', 'table')" type="button" class="{{ $reservationsView === 'table' ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-200' : 'text-gray-500 bg-white dark:text-gray-400 dark:bg-gray-900' }} relative inline-flex items-center px-2 py-2 text-sm font-medium border border-gray-300 dark:border-gray-700 rounded-l-md hover:bg-gray-50 dark:hover:bg-gray-700 focus:z-10 focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500">
                    <span class="sr-only">Table View</span>
                    <x-heroicon-o-table class="w-5 h-5" />
                </button>
                <button wire:click="$set('reservationsView', 'grid')" type="button" class="{{ $reservationsView === 'grid' ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-200' : 'text-gray-500 bg-white dark:text-gray-400 dark:bg-gray-900' }} relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium border border-gray-300 dark:border-gray-700 rounded-r-md hover:bg-gray-50 dark:hover:bg-gray-700 focus:z-10 focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500">
                    <span class="sr-only">Grid View</span>
                    <x-heroicon-o-view-grid class="w-5 h-5" />
                </button>
            </span>

        </div>

        @if($reservationsView === 'table')
        <div class="flex-col mt-5 space-y-4">
            <div class="md:flex md:justify-between">
                <div class="flex flex-col space-y-4 md:items-end md:space-x-4 md:flex-row md:w-1/2">
                    <x-bit.input.text type="text" wire:model="filters.search" placeholder="Search Reservations..." />
                </div>
                <div class="flex items-end mt-4 md:mt-0">
                    <x-bit.data-table.per-page wire:model="reservationsPerPage"/>
                </div>
            </div>

            <x-bit.table>
                <x-slot name="head">
                    <x-bit.table.heading>Event</x-bit.table.heading>
                    <x-bit.table.heading># Tickets</x-bit.table.heading>
                    <x-bit.table.heading>Created At</x-bit.table.heading>
                    <x-bit.table.heading />
                </x-slot>

                <x-slot name="body">
                    @forelse($reservations as $reservation)
                    <x-bit.table.row wire:key="row-{{ $reservation->id }}">
                        <x-bit.table.cell>{{ $reservation->event->name }}</x-bit.table.cell>
                        <x-bit.table.cell>{{ $reservation->tickets->count()  }}</x-bit.table.cell>
                        <x-bit.table.cell>{{ $reservation->created_at->format('M, d Y') }}</x-bit.table.cell>

                        <x-bit.table.cell>
                            <x-bit.button.link size="py-1 px-2" href="{{ route('app.reservations.show', $reservation) }}">
                                <x-heroicon-o-eye class="w-4 h-4 text-green-500 dark:text-green-400" />
                            </x-bit.button.link>
                        </x-bit.table.cell>

                    </x-bit.table.row>
                    @empty
                    <x-bit.table.row>
                        <x-bit.table.cell colspan="9">
                            <div class="flex items-center justify-center space-x-2">
                                <x-heroicon-o-users class="w-8 h-8 text-gray-400" />
                                <span class="py-8 text-xl font-medium text-gray-500 dark:text-gray-400 glacial">No reservations found...</span>
                            </div>
                        </x-bit.table.cell>
                    </x-bit.table.row>
                    @endforelse
                </x-slot>
            </x-bit.table>

            <div>
                {{ $reservations->links() }}
            </div>
        </div>
        @else
            <div class="grid grid-cols-3 gap-8">
                @foreach($reservations as $reservation)
                <a href="{{ route('app.reservations.show', $reservation) }}" class="block h-64 transition duration-150 ease-in-out bg-white dark:bg-gray-800 group hover:bg-green-500 hover:shadow">
                    <div class="bg-center bg-cover h-1/2" style="background-image: url({{ $reservation->event->backgroundUrl }});">
                        <img src="{{ $reservation->event->backgroundUrl }}" alt="{{ $reservation->event->name }}" class="sr-only">
                    </div>
                    <div class="px-4 py-2 mx-4 -mt-8 transition duration-150 ease-in-out bg-white dark:bg-gray-800 group-hover:bg-green-500">
                        <p class="text-2xl text-gray-900 dark:text-gray-200 group-hover:text-gray-200">{{ $reservation->event->name }}</p>
                        <p class="text-sm text-gray-700 dark:text-gray-400 text-italic group-hover:text-gray-300">{{ $reservation->event->formattedDuration }}</p>
                        <p class="text-sm text-gray-700 dark:text-gray-400 text-italic group-hover:text-gray-300">{{ $reservation->event->formattedLocation }}</p>
                        <p class="flex items-center mt-2 space-x-2 text-lg text-gray-900 dark:text-gray-200 text-italic group-hover:text-gray-200">
                            <x-heroicon-o-ticket class="w-6 h-6" />
                            <span>{{ $reservation->tickets->count() }} Tickets</span>
                        </p>
                    </div>
                </a>
                @endforeach
            </div>
        @endif
    </div>
    @endif

    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-lg dark:text-gray-200">Paid Orders</h2>

            <span class="relative z-0 inline-flex rounded-md shadow-sm">
                <button wire:click="$set('ordersView', 'table')" type="button" class="{{ $ordersView === 'table' ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-200' : 'text-gray-500 bg-white dark:text-gray-400 dark:bg-gray-900' }} relative inline-flex items-center px-2 py-2 text-sm font-medium border border-gray-300 dark:border-gray-700 rounded-l-md hover:bg-gray-50 dark:hover:bg-gray-700 focus:z-10 focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500">
                    <span class="sr-only">Table View</span>
                    <x-heroicon-o-table class="w-5 h-5" />
                </button>
                <button wire:click="$set('ordersView', 'grid')" type="button" class="{{ $ordersView === 'grid' ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-200' : 'text-gray-500 bg-white dark:text-gray-400 dark:bg-gray-900' }} relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium border border-gray-300 dark:border-gray-700 rounded-r-md hover:bg-gray-50 dark:hover:bg-gray-700 focus:z-10 focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500">
                    <span class="sr-only">Grid View</span>
                    <x-heroicon-o-view-grid class="w-5 h-5" />
                </button>
            </span>

        </div>

        @if($ordersView === 'table')
        <div class="flex-col mt-5 space-y-4">
            <div class="md:flex md:justify-between">
                <div class="flex flex-col space-y-4 md:items-end md:space-x-4 md:flex-row md:w-1/2">
                    <x-bit.input.text type="text" wire:model="filters.search" placeholder="Search orders..." />
                </div>
                <div class="flex items-end mt-4 md:mt-0">
                    <x-bit.data-table.per-page wire:model="ordersPerPage"/>
                </div>
            </div>

            <x-bit.table>
                <x-slot name="head">
                    <x-bit.table.heading>Event</x-bit.table.heading>
                    <x-bit.table.heading># Tickets</x-bit.table.heading>
                    <x-bit.table.heading>Created At</x-bit.table.heading>
                    <x-bit.table.heading />
                </x-slot>

                <x-slot name="body">
                    @forelse($orders as $order)
                    <x-bit.table.row wire:key="row-{{ $order->id }}">
                        <x-bit.table.cell>{{ $order->event->name }}</x-bit.table.cell>
                        <x-bit.table.cell>{{ $order->tickets->count()  }}</x-bit.table.cell>
                        <x-bit.table.cell>{{ $order->created_at->format('M, d Y') }}</x-bit.table.cell>

                        <x-bit.table.cell>
                            <x-bit.button.link size="py-1 px-2" href="{{ route('app.orders.show', $order) }}">
                                <x-heroicon-o-eye class="w-4 h-4 text-green-500 dark:text-green-400" />
                            </x-bit.button.link>
                        </x-bit.table.cell>

                    </x-bit.table.row>
                    @empty
                    <x-bit.table.row>
                        <x-bit.table.cell colspan="9">
                            <div class="flex items-center justify-center space-x-2">
                                <x-heroicon-o-users class="w-8 h-8 text-gray-400" />
                                <span class="py-8 text-xl font-medium text-gray-500 dark:text-gray-400 glacial">No orders found...</span>
                            </div>
                        </x-bit.table.cell>
                    </x-bit.table.row>
                    @endforelse
                </x-slot>
            </x-bit.table>

            <div>
                {{ $orders->links() }}
            </div>
        </div>
        @else
            <div class="grid grid-cols-3 gap-8">
                @forelse($orders as $order)
                <a href="{{ route('app.orders.show', $order) }}" class="block h-64 transition duration-150 ease-in-out bg-white dark:bg-gray-800 group hover:bg-green-500 hover:shadow">
                    <div class="bg-center bg-cover h-1/2" style="background-image: url({{ $order->event->backgroundUrl }});">
                        <img src="{{ $order->event->backgroundUrl }}" alt="{{ $order->event->name }}" class="sr-only">
                    </div>
                    <div class="px-4 py-2 mx-4 -mt-8 transition duration-150 ease-in-out bg-white dark:bg-gray-800 group-hover:bg-green-500">
                        <p class="text-2xl text-gray-900 dark:text-gray-200 group-hover:text-gray-200">{{ $order->event->name }}</p>
                        <p class="text-sm text-gray-700 dark:text-gray-400 text-italic group-hover:text-gray-300">{{ $order->event->formattedDuration }}</p>
                        <p class="text-sm text-gray-700 dark:text-gray-400 text-italic group-hover:text-gray-300">{{ $order->event->formattedLocation }}</p>
                        <p class="flex items-center mt-2 space-x-2 text-lg text-gray-900 dark:text-gray-200 text-italic group-hover:text-gray-200">
                            <x-heroicon-o-ticket class="w-6 h-6" />
                            <span>{{ $order->tickets->count() }} Tickets</span>
                        </p>
                    </div>
                </a>
                @empty
                    <div class="flex items-center justify-center space-x-2 bg-gray-100 dark:bg-gray-700">
                        <x-heroicon-o-calendar class="w-8 h-8 text-gray-400" />
                        <span class="py-8 text-xl font-medium text-gray-500 dark:text-gray-400 glacial">No orders found</span>
                    </div>
                @endforelse
            </div>
        @endif
    </div>
</div>
