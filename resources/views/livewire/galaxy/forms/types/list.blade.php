<div class="pt-4 space-y-4 border-t border-gray-100 dark:border-gray-800">
    <x-bit.input.group :for="'question-options-'.$index" label="Options">
        <x-bit.input.textarea class="w-full mt-1" :id="'question-options-'.$index" wire:model.live="form.{{ $index }}.options" />
        <x-bit.input.help>Put each option on a new line or separate by commas</x-bit.input.help>
    </x-bit.input.group>

    <div class="flex space-x-8">
        <x-bit.input.group :for="'question-list-style-'.$index" label="Style of List">
            <div class="flex mt-1 space-x-4">
                <x-bit.input.radio wire:model.live="form.{{ $index }}.list-style" :id="'question-list-style-'.$index.'-checkbox'" value="checkbox" label="Checkbox" />
                <x-bit.input.radio wire:model.live="form.{{ $index }}.list-style" :id="'question-list-style-'.$index.'-radio'" value="radio" label="Radio" />
                <x-bit.input.radio wire:model.live="form.{{ $index }}.list-style" :id="'question-list-style-'.$index.'-dropdown'" value="dropdown" label="Dropdown" />
            </div>
            <x-bit.input.help>Choose checkbox if multiple can be selected</x-bit.input.help>
        </x-bit.input.group>

        <x-bit.input.group :for="'question-list-other-'.$index" label="Other">
            <div class="flex mt-1 space-x-4">
                <x-bit.input.checkbox wire:model.live="form.{{ $index }}.list-other" :id="'question-list-other-'.$index.'-checkbox'" label="Enable Other Option" />
            </div>
            <x-bit.input.help>Turn on if users are allowed to fill in their own option.</x-bit.input.help>
        </x-bit.input.group>
    </div>
</div>
