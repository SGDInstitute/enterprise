<div>
    <x-bit.panel class="w-1/3 mb-8">
        <x-bit.panel.body>
            <x-bit.input.group for="preset" label="Event Preset">
                <x-bit.input.select id="preset" class="block w-full mt-1" type="text" name="preset" wire:model="preset">
                    <option value="">Select preset</option>
                    <option value="conference">Conference</option>
                    <option value="small">Small event</option>
                    <option value="virtual">Virtual</option>
                </x-bit.input.select>
            </x-bit.input.group>
        </x-bit.panel.body>
    </x-bit.panel>
    <x-bit.panel class="w-1/3 mb-8">
        <x-bit.panel.body>
            @json($event)
        </x-bit.panel.body>
    </x-bit.panel>
    <x-bit.panel>
        <x-bit.panel.body class="space-y-8 divide-y divide-gray-200 dark:divide-gray-900">
            {{-- Event Details --}}
            <div class="space-y-2">
                <h2 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-200">Event Details</h2>

                <div class="grid grid-cols-6 gap-6">
                    <x-bit.input.group for="name" label="Event Name" class="col-span-6">
                        <x-bit.input.text id="name" class="block w-full mt-1" type="text" name="name" wire:model="event.name" />
                    </x-bit.input.group>
                    <x-bit.input.group for="start" label="Event Start" class="col-span-3">
                        <x-bit.input.text id="start" class="block w-full mt-1" type="text" name="start" wire:model="event.start" />
                    </x-bit.input.group>
                    <x-bit.input.group for="end" label="Event End" class="col-span-3">
                        <x-bit.input.text id="end" class="block w-full mt-1" type="text" name="end" wire:model="event.end" />
                    </x-bit.input.group>
                    <x-bit.input.group for="location" label="Event Location" class="col-span-4">
                        <x-bit.input.text id="location" class="block w-full mt-1" type="text" name="location" wire:model="event.location" />
                        <x-bit.input.help>If event is virtual, leave blank.</x-bit.input.help>
                    </x-bit.input.group>
                    <x-bit.input.group for="order_prefix" label="Custom Order # Prefix" class="col-span-2">
                        <x-bit.input.text id="order_prefix" class="block w-full mt-1" type="text" name="order_prefix" wire:model="event.order_prefix" />
                    </x-bit.input.group>
                    <x-bit.input.group for="description" label="Event Description" class="col-span-6">
                        <x-bit.input.textarea id="description" class="block w-full mt-1" name="description" wire:model="event.description" />
                    </x-bit.input.group>
                </div>
            </div>

            {{-- Tickets --}}
            <div class="pt-8">
                <h2 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-200">Tickets</h2>
                <fieldset>
                    <div class="mt-4 space-y-4">
                        <div class="relative flex items-start">
                            <div class="flex items-center h-5">
                                <input id="volunteer-discounts" name="volunteer-discounts" type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="volunteer-discounts" class="font-medium text-gray-700 dark:text-gray-200">Enable reservations</label>
                                <p class="text-gray-500 dark:text-gray-400">This allows a user to not pay right away but reserve tickets to pay another time.</p>
                            </div>
                        </div>
                        <div class="relative flex items-start">
                            <div class="flex items-center h-5">
                                <input id="volunteer-discounts" name="volunteer-discounts" type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="volunteer-discounts" class="font-medium text-gray-700 dark:text-gray-200">Enable volunteer discounts</label>
                            </div>
                        </div>
                        <div class="relative flex items-start">
                            <div class="flex items-center h-5">
                                <input id="comments" name="comments" type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="comments" class="font-medium text-gray-700 dark:text-gray-200">Enable presenter discounts</label>
                            </div>
                        </div>
                        <div class="relative flex items-start">
                            <div class="flex items-center h-5">
                                <input id="candidates" name="candidates" type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="candidates" class="font-medium text-gray-700 dark:text-gray-200">Collect demographics</label>
                            </div>
                        </div>
                        <div class="relative flex items-start">
                            <div class="flex items-center h-5">
                                <input id="offers" name="offers" type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="offers" class="font-medium text-gray-700 dark:text-gray-200">Enable Add on options</label>
                                <p class="text-gray-500 dark:text-gray-400">These are extra cost items that can be added to a ticket e.g. meal tickets, t-shirts.</p>
                            </div>
                        </div>
                        <div class="relative flex items-start">
                            <div class="flex items-center h-5">
                                <input id="offers" name="offers" type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="offers" class="font-medium text-gray-700 dark:text-gray-200">Enable invoice generation</label>
                            </div>
                        </div>
                        <div class="relative flex items-start">
                            <div class="flex items-center h-5">
                                <input id="offers" name="offers" type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="offers" class="font-medium text-gray-700 dark:text-gray-200">Allow pay by check</label>
                                <p class="text-gray-500 dark:text-gray-400">If unchecked the event can only be paid for by credit card.</p>
                            </div>
                        </div>
                        <div class="relative flex items-start">
                            <div class="flex items-center h-5">
                                <input id="offers" name="offers" type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="offers" class="font-medium text-gray-700 dark:text-gray-200">On-site check-in</label>
                            </div>
                        </div>
                        <div class="relative flex items-start">
                            <div class="flex items-center h-5">
                                <input id="offers" name="offers" type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="offers" class="font-medium text-gray-700 dark:text-gray-200">Enable livestream portal</label>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>

            {{-- Workshops/Volunteers --}}
            <div class="pt-8">
                <h2 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-200">Workshop/Volunteers</h2>
                <fieldset>
                    <div class="mt-4 space-y-4">
                        <div class="relative flex items-start">
                            <div class="flex items-center h-5">
                                <input id="has_workshops" name="has_workshops" type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="has_workshops" class="font-medium text-gray-700 dark:text-gray-200">Has workshop proposals</label>
                            </div>
                        </div>
                        <div class="relative flex items-start">
                            <div class="flex items-center h-5">
                                <input id="has_volunteers" name="has_volunteers" type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="has_volunteers" class="font-medium text-gray-700 dark:text-gray-200">Has volunteers</label>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>

            {{-- Fundraising --}}
            <div class="pt-8">
                <h2 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-200">Fundraising</h2>
                <fieldset>
                    <div class="mt-4 space-y-4">
                        <div class="relative flex items-start">
                            <div class="flex items-center h-5">
                                <input id="has_sponsorship" name="has_sponsorship" type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="has_sponsorship" class="font-medium text-gray-700 dark:text-gray-200">Has sponsorship packages</label>
                            </div>
                        </div>
                        <div class="relative flex items-start">
                            <div class="flex items-center h-5">
                                <input id="has_vendors" name="has_vendors" type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="has_vendors" class="font-medium text-gray-700 dark:text-gray-200">Has vendor tables</label>
                            </div>
                        </div>
                        <div class="relative flex items-start">
                            <div class="flex items-center h-5">
                                <input id="has_programs" name="has_programs" type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="has_programs" class="font-medium text-gray-700 dark:text-gray-200">Has program ads</label>
                            </div>
                        </div>
                        <div class="relative flex items-start">
                            <div class="flex items-center h-5">
                                <input id="allow_donations" name="allow_donations" type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="allow_donations" class="font-medium text-gray-700 dark:text-gray-200">Allow one-time donations</label>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </x-bit.panel.body>

        <x-bit.panel.footer>
            @if($formChanged)
            <x-bit.button.primary type="button" wire:click="save">Save</x-bit.button.primary>
            <x-bit.badge>
                Unsaved Changes
            </x-bit.badge>
            @else
            <x-bit.button.primary type="button" wire:click="save" disabled>Save</x-bit.button.primary>
            @endif
        </x-bit.panel.footer>
    </x-bit.panel>
</div>
