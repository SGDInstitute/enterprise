<form wire:submit="save">
    <x-bit.panel class="w-1/3 mb-8">
        <x-bit.panel.body>
            <x-bit.input.group for="preset" label="Event Preset">
                <x-bit.input.select id="preset" class="block w-full mt-1" type="text" name="preset" wire:model.live="preset">
                    <option value="">Select preset</option>
                    <option value="mblgtacc">MBLGTACC</option>
                    <option value="conference">Conference</option>
                    <option value="small">Small event</option>
                    <option value="virtual">Virtual</option>
                </x-bit.input.select>
            </x-bit.input.group>
        </x-bit.panel.body>
    </x-bit.panel>
    <x-bit.panel>
        <x-bit.panel.body class="space-y-8 divide-y divide-gray-200 dark:divide-gray-900">
            {{-- Event Details --}}
            <div class="space-y-2">
                <h2 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-200">Event Details</h2>

                <div class="grid grid-cols-6 gap-6">
                    <x-bit.input.group for="name" label="Event Name" class="col-span-6">
                        <x-bit.input.text id="name" class="block w-full mt-1" type="text" name="name" wire:model.live="event.name" />
                    </x-bit.input.group>
                    <x-bit.input.group for="start" label="Event Start" class="col-span-2">
                        <x-bit.input.date-time class="block w-full mt-1" id="start" name="start" wire:model.live="event.start"/>
                    </x-bit.input.group>
                    <x-bit.input.group for="end" label="Event End" class="col-span-2">
                        <x-bit.input.date-time class="block w-full mt-1" id="end" name="end" wire:model.live="event.end"/>
                    </x-bit.input.group>
                    <x-bit.input.group for="timezone" label="Timezone" class="col-span-2">
                        <x-bit.input.select class="block w-full mt-1" wire:model.live="event.timezone" id="timezone">
                            @foreach ($timezones as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </x-bit.input.select>
                    </x-bit.input.group>
                    <x-bit.input.group for="location" label="Event Location" class="col-span-4">
                        <x-bit.input.text id="location" class="block w-full mt-1" type="text" name="location" wire:model.live="event.location" />
                        <x-bit.input.help>If event is virtual, leave blank.</x-bit.input.help>
                    </x-bit.input.group>
                    <x-bit.input.group for="order_prefix" label="Custom Order # Prefix" class="col-span-2">
                        <x-bit.input.text id="order_prefix" class="block w-full mt-1" type="text" name="order_prefix" wire:model.live="event.order_prefix" />
                    </x-bit.input.group>
                    <x-bit.input.group for="description" label="Event Description" class="col-span-6">
                        <x-bit.input.textarea id="description" rows="6" class="block w-full mt-1" name="description" wire:model.live="event.description" />
                    </x-bit.input.group>
                </div>
            </div>

            {{-- Tickets --}}
            <div class="pt-8">
                <h2 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-200">Tickets</h2>
                <fieldset>
                    <div class="mt-4 space-y-4">
                        <x-bit.input.checkbox id="reservations" name="reservations" wire:model.live="event.settings.reservations" label="Enable reservations"
                            help="This allows a user to not pay right away but reserve tickets to pay another time" />
                        <x-bit.input.checkbox id="volunteer_discounts" name="volunteer_discounts" wire:model.live="event.settings.volunteer_discounts" label="Enable volunteer discounts" />
                        <x-bit.input.checkbox id="presenter_discounts" name="presenter_discounts" type="checkbox" wire:model.live="event.settings.presenter_discounts" label="Enable presenter discounts" />
                        <x-bit.input.checkbox id="demographics" name="demographics" wire:model.live="event.settings.demographics" label="Collect demographics" />
                        <x-bit.input.checkbox id="add_ons" name="add_ons" wire:model.live="event.settings.add_ons" label="Enable Add on options" help="These are extra cost items that can be added to a ticket e.g. meal tickets, t-shirts." />
                        <x-bit.input.checkbox id="bulk" name="bulk" wire:model.live="event.settings.bulk" label="Allow bulk orders" />
                        <x-bit.input.checkbox id="invoices" name="invoices" wire:model.live="event.settings.invoices" label="Enable invoice generation" />
                        <x-bit.input.checkbox id="check_payment" name="check_payment" wire:model.live="event.settings.check_payment" label="Allow pay by check" help="If unchecked the event can only be paid for by credit card." />
                        <x-bit.input.checkbox id="onsite" name="onsite" wire:model.live="event.settings.onsite" label="On-site check-in" />
                        <x-bit.input.checkbox id="livestream" name="livestream" type="checkbox" wire:model.live="event.settings.livestream" label="Enable livestream portal" />
                    </div>
                </fieldset>
            </div>

            {{-- Workshops/Volunteers --}}
            <div class="pt-8">
                <h2 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-200">Workshop/Volunteers</h2>
                <fieldset>
                    <div class="mt-4 space-y-4">
                        <x-bit.input.checkbox id="has_workshops" name="has_workshops" wire:model.live="event.settings.has_workshops" label="Has workshop proposals" />
                        <x-bit.input.checkbox id="has_volunteers" name="has_volunteers" wire:model.live="event.settings.has_volunteers" label="Has volunteers" />
                    </div>
                </fieldset>
            </div>

            {{-- Fundraising --}}
            <div class="pt-8">
                <h2 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-200">Fundraising</h2>
                <fieldset>
                    <div class="mt-4 space-y-4">
                        <x-bit.input.checkbox id="has_sponsorship" name="has_sponsorship" wire:model.live="event.settings.has_sponsorship" label="Has sponsorship packages" />
                        <x-bit.input.checkbox id="has_vendors" name="has_vendors" wire:model.live="event.settings.has_vendors" label="Has vendor tables" />
                        <x-bit.input.checkbox id="has_ads" name="has_ads" wire:model.live="event.settings.has_ads" label="Has program ads" />
                        <x-bit.input.checkbox id="allow_donations" name="allow_donations" wire:model.live="event.settings.allow_donations" label="Allow one-time donations" />
                    </div>
                </fieldset>
            </div>
        </x-bit.panel.body>

        <x-bit.panel.footer>
            @if ($formChanged)
            <x-bit.button.flat.primary type="submit">Save</x-bit.button.flat.primary>
            <x-bit.badge color="indigo" class="ml-4">
                Unsaved Changes
            </x-bit.badge>
            @else
            <x-bit.button.flat.primary type="submit" disabled>Save</x-bit.button.flat.primary>
            @endif
        </x-bit.panel.footer>
    </x-bit.panel>
</form>
