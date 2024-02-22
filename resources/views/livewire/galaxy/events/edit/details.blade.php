<form wire:submit="save">
    <x-bit.panel>
        <x-bit.panel.body class="space-y-8 divide-y divide-gray-200 dark:divide-gray-900">
            <div class="space-y-2">
                <div class="grid grid-cols-6 gap-6">
                    <x-bit.input.group for="name" label="Event Name" class="col-span-6">
                        <x-bit.input.text
                            id="name"
                            class="mt-1 block w-full"
                            type="text"
                            name="name"
                            wire:model.live="event.name"
                        />
                    </x-bit.input.group>
                    <x-bit.input.group for="start" label="Event Start" class="col-span-2">
                        <x-bit.input.date-time
                            class="mt-1 block w-full"
                            id="start"
                            name="start"
                            wire:model.live="formattedStart"
                        />
                    </x-bit.input.group>
                    <x-bit.input.group for="end" label="Event End" class="col-span-2">
                        <x-bit.input.date-time
                            class="mt-1 block w-full"
                            id="end"
                            name="end"
                            wire:model.live="formattedEnd"
                        />
                    </x-bit.input.group>
                    <x-bit.input.group for="timezone" label="Timezone" class="col-span-2">
                        <x-bit.input.select class="mt-1 block w-full" wire:model.live="event.timezone" id="timezone">
                            @foreach ($timezones as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </x-bit.input.select>
                    </x-bit.input.group>
                    <x-bit.input.group for="location" label="Event Location" class="col-span-4">
                        <x-bit.input.text
                            id="location"
                            class="mt-1 block w-full"
                            type="text"
                            name="location"
                            wire:model.live="event.location"
                        />
                        <x-bit.input.help>If event is virtual, leave blank.</x-bit.input.help>
                    </x-bit.input.group>
                    <x-bit.input.group for="order_prefix" label="Custom Order # Prefix" class="col-span-2">
                        <x-bit.input.text
                            id="order_prefix"
                            class="mt-1 block w-full"
                            type="text"
                            name="order_prefix"
                            wire:model.live="event.order_prefix"
                        />
                    </x-bit.input.group>
                    <x-bit.input.group for="description" label="Event Description" class="col-span-6">
                        <x-bit.input.trix
                            id="description"
                            class="mt-1 block w-full"
                            name="description"
                            wire:model.live="event.description"
                        />
                    </x-bit.input.group>
                </div>
            </div>
        </x-bit.panel.body>

        <x-bit.panel.footer>
            @if ($formChanged)
                <x-bit.button.round.primary type="submit">Save</x-bit.button.round.primary>
                <x-bit.badge color="indigo" class="ml-4">Unsaved Changes</x-bit.badge>
            @else
                <x-bit.button.round.primary type="submit" disabled>Save</x-bit.button.round.primary>
            @endif
        </x-bit.panel.footer>
    </x-bit.panel>
</form>
