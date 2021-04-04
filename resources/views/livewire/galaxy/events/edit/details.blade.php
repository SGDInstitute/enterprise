<form wire:submit.prevent="save">
    <x-bit.panel>
        <x-bit.panel.body class="space-y-8 divide-y divide-gray-200 dark:divide-gray-900">
            <div class="space-y-2">
                <div class="grid grid-cols-6 gap-6">
                    <x-bit.input.group for="name" label="Event Name" class="col-span-6">
                        <x-bit.input.text id="name" class="block w-full mt-1" type="text" name="name" wire:model="event.name" />
                    </x-bit.input.group>
                    <x-bit.input.group for="start" label="Event Start" class="col-span-2">
                        <x-bit.input.date-time class="block w-full mt-1" id="start" name="start" wire:model="formattedStart" />
                    </x-bit.input.group>
                    <x-bit.input.group for="end" label="Event End" class="col-span-2">
                        <x-bit.input.date-time class="block w-full mt-1" id="end" name="end" wire:model="formattedEnd" />
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
                        <x-bit.input.trix id="description" class="block w-full mt-1" name="description" wire:model="event.description" />
                    </x-bit.input.group>

                    <x-bit.input.group class="col-span-6">
                        <x-bit.input.checkbox id="photo-policy" name="photo-policy" wire:model="tabs" label="Enable Photo Policy" value="photo" />
                        @if(in_array('photo', $tabs))
                        <x-bit.input.trix id="photo-policy-text" key="photo-policy-text" class="block w-full mt-1" name="photo-policy-text" wire:model="event.settings.policies.photo" />
                        @endif
                    </x-bit.input.group>

                    <x-bit.input.group class="col-span-6">
                        <x-bit.input.checkbox id="refund-policy" name="refund-policy" wire:model="tabs" label="Enable Refund Policy" value="refund" />
                        @if(in_array('refund', $tabs))
                        <x-bit.input.trix id="refund-policy-text" key="refund-policy-text" class="block w-full mt-1" name="refund-policy-text" wire:model="event.settings.policies.refund" />
                        @endif
                    </x-bit.input.group>

                    <x-bit.input.group class="col-span-6">
                        <x-bit.input.checkbox id="code-for-inclusion" name="code-for-inclusion" wire:model="tabs" label="Enable Code for Inclusion" value="code" />
                        @if(in_array('code', $tabs))
                        <x-bit.input.trix id="code-text" key="code-text" class="block w-full mt-1" name="code-text" wire:model="event.settings.policies.code" />
                        @endif
                    </x-bit.input.group>

                </div>
            </div>
        </x-bit.panel.body>

        <x-bit.panel.footer>
            @if($formChanged)
            <x-bit.button.round.primary type="submit">Save</x-bit.button.round.primary>
            <x-bit.badge color="indigo" class="ml-4">
                Unsaved Changes
            </x-bit.badge>
            @else
            <x-bit.button.round.primary type="submit" disabled>Save</x-bit.button.round.primary>
            @endif
        </x-bit.panel.footer>
    </x-bit.panel>
</form>
