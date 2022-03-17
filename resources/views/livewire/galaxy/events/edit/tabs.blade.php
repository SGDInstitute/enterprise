<div class="space-y-4">
    <div>
        <x-bit.button.round.primary wire:click="save">Save</x-bit.button.round.primary>
        <x-bit.button.round.secondary wire:click="addTab">Add Policy Tab</x-bit.button.round.secondary>
    </div>

    @foreach ($tabs as $index => $tab)
    <div wire:key="$index" class="p-4 space-y-2 bg-gray-100 rounded dark:bg-gray-700">
        <x-bit.input.group :for="'policy-name-'.$index" label="Policy Name">
            <x-bit.input.text :id="'policy-name-'.$index" class="block w-64 mt-1" type="text" name="name" wire:model="tabs.{{ $index }}.name" />
        </x-bit.input.group>
        <x-bit.input.group :for="'policy-content-'.$index" label="Content">
            <x-bit.input.markdown :id="'policy-content-'.$index" class="block w-full mt-1" type="text" name="content" wire:model="tabs.{{ $index }}.content" />
        </x-bit.input.group>
    </div>
    @endforeach
</div>
