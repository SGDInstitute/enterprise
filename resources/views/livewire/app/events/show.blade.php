<div class="space-y-12">
    <x-ui.steps :steps="$steps" />

    @guest
    <div class="sticky z-50 mx-auto mb-8 max-w-prose top-20">
        <div class="p-4 bg-green-600 rounded-md">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8 text-gray-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="flex-1 ml-3 md:flex md:justify-between">
                    <p class="text-lg text-gray-200">
                        You must <a href="/login" class="font-bold text-white underline">Login</a> or <a href="/register" class="font-bold text-white underline">Create an Account</a> before starting a reservation.
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endauth

    <div class="grid grid-cols-1 gap-8 px-4 mx-auto max-w-7xl sm:px-6 lg:px-8 md:grid-cols-3">
        <livewire:app.events.modals :event="$event" />

        <div class="col-span-2">
            <livewire:app.events.tickets :event="$event" />
        </div>
    </div>

    <x-bit.modal.dialog wire:model="showPreviousOrders" max-width="6xl">
        <x-slot name="title"></x-slot>

        <x-slot name="content">
            <livewire:app.dashboard.orders-reservations :event="$event" />
        </x-slot>

        <x-slot name="footer">
            <x-bit.button.flat.secondary wire:click="$set('showPreviousOrders', false)">Start a new order</x-bit.button.flat.secondary>
        </x-slot>
    </x-bit.modal.dialog>
</div>
