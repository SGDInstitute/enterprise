<div class="grid grid-cols-1 gap-8 md:grid-cols-2">
    <div class="space-y-4">
        <h2 class="mb-8 text-xl font-semibold text-gray-900 dark:text-gray-200">FAQ</h2>
        <div>
            <x-bit.button.round.primary wire:click="save">Save</x-bit.button.round.primary>
            <x-bit.button.round.secondary wire:click="addTab">Add FAQ</x-bit.button.round.secondary>
        </div>

        @foreach ($faq as $index => $tab)
        <div wire:key="$index" class="p-4 space-y-2 bg-gray-100 rounded dark:bg-gray-700">
            <x-bit.input.group :for="'faq-name-'.$index" label="Question">
                <x-bit.input.text :id="'faq-name-'.$index" class="block w-64 mt-1" type="text" name="name" wire:model="faq.{{ $index }}.name" />
            </x-bit.input.group>
            <x-bit.input.group :for="'faq-content-'.$index" label="Answer">
                <x-bit.input.markdown :id="'faq-content-'.$index" class="block w-full mt-1" type="text" name="content" wire:model="faq.{{ $index }}.content" />
            </x-bit.input.group>
        </div>
        @endforeach
    </div>
    <div class="space-y-4">
        <h2 class="mb-8 text-xl font-semibold text-gray-900 dark:text-gray-200">Contact</h2>
        <div>
            <x-bit.button.round.primary wire:click="saveContact">Save</x-bit.button.round.primary>
        </div>

        <div class="p-4 space-y-2 bg-gray-100 rounded dark:bg-gray-700">
            <x-bit.input.group for="contact" label="Contact Page">
                <x-bit.input.markdown id="contact" class="block w-full mt-1" type="text" name="content" wire:model="contact" />
            </x-bit.input.group>
        </div>
    </div>
</div>
