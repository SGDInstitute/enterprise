<div class="rounded-md dark:bg-gray-700">
    <div class="flex items-center justify-between p-4 bg-gray-100 dark:bg-gray-900 rounded-t-md">
        <span class="dark:text-gray-400">Question {{ $index + 1 }}</span>
        @include('livewire.galaxy.events.edit.workshop-form.toolbar')
    </div>
    <div class="p-4 space-y-4 rounded-b-md">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
            <x-bit.input.group :for="'question-id-'.$index" label="ID">
                <x-bit.input.text type="text" class="w-full mt-1" :id="'question-id-'.$index" wire:model="form.{{ $index }}.id" />
                <x-bit.input.help>Short, unique identifier for question. Use dashes instead of spaces.</x-bit.input.help>
            </x-bit.input.group>

            <x-bit.input.group :for="'question-type-'.$index" label="Type of Question">
                <x-bit.input.select class="w-full mt-1" :id="'question-type-'.$index" wire:model="form.{{ $index }}.type">
                    @foreach($typeOptions as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </x-bit.input.select>
            </x-bit.input.group>

            <x-bit.input.group :for="'question-rules-'.$index" label="Rules">
                <x-bit.input.text type="text" class="w-full mt-1" :id="'question-rules-'.$index" placeholder="required" wire:model="form.{{ $index }}.rules" />
                <x-bit.input.help>Pipe delineated list of validation rules</x-bit.input.help>
            </x-bit.input.group>

            <x-bit.input.group :for="'question-question-'.$index" label="Question" class="col-span-4">
                <x-bit.input.text type="text" class="w-full mt-1" :id="'question-question-'.$index" wire:model="form.{{ $index }}.question" />
            </x-bit.input.group>
        </div>
        @if($question['type'] === 'list')
        <div class="pt-4 space-y-4 border-t border-gray-100 dark:border-gray-800">
            <x-bit.input.group :for="'question-options-'.$index" label="Options">
                <x-bit.input.textarea class="w-full mt-1" :id="'question-options-'.$index" wire:model="form.{{ $index }}.options" />
                <x-bit.input.help>Put each option on a new line or separate by commas</x-bit.input.help>
            </x-bit.input.group>

            <div class="flex space-x-8">
                <x-bit.input.group :for="'question-list-style-'.$index" label="Style of List">
                    <div class="flex mt-1 space-x-4">
                        <x-bit.input.radio wire:model="form.{{ $index }}.list-style" :id="'question-list-style-'.$index.'-checkbox'" value="checkbox" label="Checkbox" />
                        <x-bit.input.radio wire:model="form.{{ $index }}.list-style" :id="'question-list-style-'.$index.'-radio'" value="radio" label="Radio" />
                        <x-bit.input.radio wire:model="form.{{ $index }}.list-style" :id="'question-list-style-'.$index.'-dropdown'" value="dropdown" label="Dropdown" />
                    </div>
                    <x-bit.input.help>Choose checkbox if multiple can be selected</x-bit.input.help>
                </x-bit.input.group>

                <x-bit.input.group :for="'question-list-other-'.$index" label="Other">
                    <div class="flex mt-1 space-x-4">
                        <x-bit.input.checkbox wire:model="form.{{ $index }}.list-other" :id="'question-list-other-'.$index.'-checkbox'" value="checkbox" label="Enable Other Option" />
                    </div>
                    <x-bit.input.help>Turn on if users are allowed to fill in their own option.</x-bit.input.help>
                </x-bit.input.group>
            </div>
        </div>
        @endif
    </div>
</div>
