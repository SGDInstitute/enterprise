<div class="space-y-8">
    @if ($event->start->diffInDays(now()) < 14)
        @if ($event->settings->allow_checkin)
        <div class="w-1/4 p-4 mx-auto rounded-md bg-blue-50 dark:bg-blue-900">
            <div class="flex">
                <div class="flex-shrink-0">
                    <x-heroicon-o-ticket class="w-5 h-5 text-blue-400" />
                </div>
                <div class="flex-1 ml-3 md:flex md:justify-between">
                    <p class="text-sm text-blue-700 dark:text-blue-200">
                        Check-in is open.
                    </p>
                    <button wire:loading.remove wire:click="closeCheckin" class="font-medium text-blue-700 dark:text-blue-200 whitespace-nowrap hover:text-blue-600 dark:hover:text-blue-50">Close <span aria-hidden="true">&rarr;</span></button>
                </div>
            </div>
        </div>
        @else
        <div class="p-4 mx-12 rounded-md bg-blue-50 dark:bg-blue-900">
            <div class="flex">
                <div class="flex-shrink-0">
                    <x-heroicon-o-ticket class="w-5 h-5 text-blue-400" />
                </div>
                <div class="flex-1 ml-3 md:flex md:justify-between">
                    <p class="text-sm text-blue-700 dark:text-blue-200">
                        Open & Allow attendees to check-in. This will send a notification to all paid attendees.
                    </p>
                    <p class="mt-3 text-sm md:mt-0 md:ml-6">
                    <div wire:loading class="flex items-center space-x-4 font-medium text-blue-700 dark:text-blue-200">
                        <svg class="w-5 h-5 text-blue-700 dark:text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Sending Emails...</span>
                    </div>
                    <button wire:loading.remove wire:click="openCheckin" class="font-medium text-blue-700 dark:text-blue-200 whitespace-nowrap hover:text-blue-600 dark:hover:text-blue-50">Open Check-in & Send Notifications <span aria-hidden="true">&rarr;</span></button>
                    </p>
                </div>
            </div>
        </div>
        @endif
    @endif

    <form wire:submit.prevent="save">
        <x-bit.panel>
            <x-bit.panel.body class="space-y-8 divide-y divide-gray-200 dark:divide-gray-900">
                {{-- Tickets --}}
                <div>
                    <h2 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-200">Tickets</h2>
                    <fieldset>
                        <div class="mt-4 space-y-4">
                            <x-bit.input.checkbox id="reservations" name="reservations" wire:model="event.settings.reservations" label="Enable reservations" help="This allows a user to not pay right away but reserve tickets to pay another time" />
                            @if ($event->settings->reservations)
                            <x-bit.input.group class="ml-12" for="reservation-length" label="Reservation Length">
                                <x-bit.input.text type="text" class="mt-1" id="reservation-length" name="reservation-length" wire:model="event.settings.reservation_length" label="Reservation Length" />
                                <x-bit.input.help>How many days does a reservation have to be paid</x-bit.input.help>
                            </x-bit.input.group>
                            @endif
                            <x-bit.input.checkbox id="volunteer_discounts" name="volunteer_discounts" wire:model="event.settings.volunteer_discounts" label="Enable volunteer discounts" />
                            <x-bit.input.checkbox id="presenter_discounts" name="presenter_discounts" type="checkbox" wire:model="event.settings.presenter_discounts" label="Enable presenter discounts" />
                            <x-bit.input.checkbox id="demographics" name="demographics" wire:model="event.settings.demographics" label="Collect demographics" />
                            <x-bit.input.checkbox id="add_ons" name="add_ons" wire:model="event.settings.add_ons" label="Enable Add on options" help="These are extra cost items that can be added to a ticket e.g. meal tickets, t-shirts." />
                            <x-bit.input.checkbox id="bulk" name="bulk" wire:model="event.settings.bulk" label="Allow bulk orders" />
                            <x-bit.input.checkbox id="invoices" name="invoices" wire:model="event.settings.invoices" label="Enable invoice generation" />
                            <x-bit.input.checkbox id="check_payment" name="check_payment" wire:model="event.settings.check_payment" label="Allow pay by check" help="If unchecked the event can only be paid for by credit card." />
                            <x-bit.input.checkbox id="onsite" name="onsite" wire:model="event.settings.onsite" label="On-site check-in" />
                            <x-bit.input.checkbox id="livestream" name="livestream" type="checkbox" wire:model="event.settings.livestream" label="Enable livestream portal" />
                        </div>
                    </fieldset>
                </div>

                {{-- Workshops/Volunteers --}}
                <div class="pt-8">
                    <h2 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-200">Workshop/Volunteers</h2>
                    <fieldset>
                        <div class="mt-4 space-y-4">
                            <x-bit.input.checkbox id="has_workshops" name="has_workshops" wire:model="event.settings.has_workshops" label="Has workshop proposals" />
                            <x-bit.input.checkbox id="has_volunteers" name="has_volunteers" wire:model="event.settings.has_volunteers" label="Has volunteers" />
                        </div>
                    </fieldset>
                </div>

                {{-- Fundraising --}}
                <div class="pt-8">
                    <h2 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-200">Fundraising</h2>
                    <fieldset>
                        <div class="mt-4 space-y-4">
                            <x-bit.input.checkbox id="has_sponsorship" name="has_sponsorship" wire:model="event.settings.has_sponsorship" label="Has sponsorship packages" />
                            <x-bit.input.checkbox id="has_vendors" name="has_vendors" wire:model="event.settings.has_vendors" label="Has vendor tables" />
                            <x-bit.input.checkbox id="has_ads" name="has_ads" wire:model="event.settings.has_ads" label="Has program ads" />
                            <x-bit.input.checkbox id="allow_donations" name="allow_donations" wire:model="event.settings.allow_donations" label="Allow one-time donations" />
                        </div>
                    </fieldset>
                </div>
            </x-bit.panel.body>
            <x-bit.panel.footer>
                @if ($formChanged)
                <x-bit.button.round.primary type="submit">Save</x-bit.button.round.primary>
                <x-ui.badge color="indigo" class="ml-4">
                    Unsaved Changes
                </x-ui.badge>
                @else
                <x-bit.button.round.primary type="submit" disabled>Save</x-bit.button.round.primary>
                @endif
            </x-bit.panel.footer>
        </x-bit.panel>
    </form>
</div>
