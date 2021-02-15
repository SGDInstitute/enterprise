<form wire:submit.prevent="save">
    <x-bit.panel>
        <x-bit.panel.body class="space-y-8 divide-y divide-gray-200 dark:divide-gray-900">
            {{-- Event Details --}}
        <div class="space-y-2">
                <h2 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-200">Event Details</h2>

                <div class="grid grid-cols-6 gap-6">
                    <x-bit.input.group for="name" label="Event Name" class="col-span-6">
                        <x-bit.input.text id="name" class="block w-full mt-1" type="text" name="name" wire:model="event.name" />
                    </x-bit.input.group>
                    <x-bit.input.group for="start" label="Event Start" class="col-span-2">
                        <x-bit.input.date-time class="block w-full mt-1" id="start" name="start" wire:model="event.formattedStart" />
                    </x-bit.input.group>
                    <x-bit.input.group for="end" label="Event End" class="col-span-2">
                        <x-bit.input.date-time class="block w-full mt-1" id="end" name="end" wire:model="event.formattedEnd" />
                    </x-bit.input.group>
                    <x-bit.input.group for="timezone" label="Timezone" class="col-span-2">
                        <x-bit.input.select class="block w-full mt-1" wire:model="event.timezone" id="timezone">
                            @foreach($timezones as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </x-bit.input.select>
                    </x-bit.input.group>
                    <x-bit.input.group for="location" label="Event Location" class="col-span-4">
                        <x-bit.input.text id="location" class="block w-full mt-1" type="text" name="location" wire:model="event.location" />
                        <x-bit.input.help>If event is virtual, leave blank.</x-bit.input.help>
                    </x-bit.input.group>
                    <x-bit.input.group for="order_prefix" label="Custom Order # Prefix" class="col-span-2">
                        <x-bit.input.text id="order_prefix" class="block w-full mt-1" type="text" name="order_prefix" wire:model="event.order_prefix" />
                    </x-bit.input.group>
                    <x-bit.input.group for="description" label="Event Description" class="col-span-6">
                        <x-bit.input.textarea id="description" rows="6" class="block w-full mt-1" name="description" wire:model="event.description" />
                    </x-bit.input.group>
                </div>
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
