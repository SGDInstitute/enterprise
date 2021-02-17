<form wire:submit.prevent="save">
    <x-bit.panel>
        <x-bit.panel.body class="space-y-8 divide-y divide-gray-200 dark:divide-gray-900">
            {{-- Tickets --}}
            <div>
                <h2 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-200">Tickets</h2>
                <fieldset>
                    <div class="mt-4 space-y-4">
                        <x-bit.input.checkbox id="reservations" name="reservations" wire:model="event.settings.reservations" label="Enable reservations" help="This allows a user to not pay right away but reserve tickets to pay another time" />
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
            @if($formChanged)
            <x-bit.button.primary type="submit">Save</x-bit.button.primary>
            <x-bit.badge color="indigo" class="ml-4">
                Unsaved Changes
            </x-bit.badge>
            @else
            <x-bit.button.primary type="submit" disabled>Save</x-bit.button.primary>
            @endif
        </x-bit.panel.footer>
    </x-bit.panel>
</form>
