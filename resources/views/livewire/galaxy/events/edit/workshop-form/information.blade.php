<div class="p-4 bg-white rounded-md shadow dark:bg-gray-800">
    <h2 class="text-gray-600 dark:text-gray-400">Information</h2>

    <div class="grid grid-cols-1 gap-6 mt-4 md:grid-cols-3">
        <x-bit.input.group for="start" label="Availability Start">
            <x-bit.input.date-time class="block w-full mt-1" id="start" name="start" wire:model.live="formattedStart" />
        </x-bit.input.group>
        <x-bit.input.group for="end" label="Availability End">
            <x-bit.input.date-time class="block w-full mt-1" id="end" name="end" wire:model.live="formattedEnd" />
        </x-bit.input.group>
        <x-bit.input.group for="timezone" label="Timezone">
            <x-bit.input.select class="block w-full mt-1" wire:model.live="workshopForm.timezone" id="timezone">
                @foreach ($timezones as $value => $label)
                <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </x-bit.input.select>
        </x-bit.input.group>

        <x-bit.input.group for="searchable" label="Searchable Questions">
            <x-bit.input.select multiple class="block w-full mt-1" id="searchable" name="searchable" wire:model.live="searchable">
                @foreach ($searchableFields as $id => $question)
                <option value="{{ $id }}">{{ $question }}</option>
                @endforeach
            </x-bit.input.select>
        </x-bit.input.group>

        <x-bit.input.group for="reminders" label="Reminders">
            <x-bit.input.text class="block w-full mt-1" id="reminders" name="reminders" wire:model.live="reminders" />
            <x-bit.input.help>Comma separate list of days when reminders should be sent</x-bit.input.help>
        </x-bit.input.group>
    </div>
</div>
