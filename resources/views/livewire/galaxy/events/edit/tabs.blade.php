<div class="space-y-4">
    <div>
        <x-bit.button.round.primary wire:click="save">Save</x-bit.button.round.primary>
        <x-bit.button.round.secondary wire:click="addTab">Add Policy Tab</x-bit.button.round.secondary>
    </div>

    @foreach ($tabs as $index => $tab)
        <div
            wire:key="$index"
            class="space-y-2 rounded bg-white p-4 shadow dark:border dark:border-gray-700 dark:bg-gray-800"
        >
            <div class="grid grid-cols-4 gap-4">
                <x-form.group
                    :for="'policy-name-'.$index"
                    model="tabs.{{ $index }}.name"
                    type="text"
                    label="Policy Name"
                />
                <x-form.group
                    :for="'policy-slug-'.$index"
                    model="tabs.{{ $index }}.slug"
                    type="text"
                    label="Policy Slug"
                />
                <x-form.group
                    :for="'policy-slug-'.$index"
                    model="tabs.{{ $index }}.icon"
                    type="text"
                    label="Policy Icon"
                />
            </div>
            <x-bit.input.group :for="'policy-content-'.$index" label="Content">
                <x-bit.input.markdown
                    :id="'policy-content-'.$index"
                    class="mt-1 block w-full"
                    type="text"
                    name="content"
                    wire:model.live="tabs.{{ $index }}.content"
                />
            </x-bit.input.group>
        </div>
    @endforeach
</div>
