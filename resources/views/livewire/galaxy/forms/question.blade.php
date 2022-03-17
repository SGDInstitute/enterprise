<div class="rounded-md dark:bg-gray-700">
    <div class="flex items-center justify-between p-4 bg-gray-100 dark:bg-gray-900 rounded-t-md">
        <span class="w-2/3 truncate dark:text-gray-400">
            Question {{ $index + 1 }}{{ $form[$index]['question'] !== '' ? ': ' . $form[$index]['question'] : '' }}
        </span>
        @include('livewire.galaxy.forms.toolbar')
    </div>
    @if ($openIndex === $index)
    <div class="p-4 space-y-4 rounded-b-md">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
            <x-bit.input.group :for="'question-id-'.$index" label="ID">
                <x-bit.input.text type="text" class="w-full mt-1" :id="'question-id-'.$index" wire:model="form.{{ $index }}.id" />
                <x-bit.input.help>Short, unique identifier for question. Use dashes instead of spaces.</x-bit.input.help>
            </x-bit.input.group>

            <x-bit.input.group :for="'question-type-'.$index" label="Type of Question">
                <x-bit.input.select class="w-full mt-1" :id="'question-type-'.$index" wire:model="form.{{ $index }}.type">
                    <option value="" disabled>Select Type</option>
                    @foreach ($typeOptions as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </x-bit.input.select>
            </x-bit.input.group>

            <div class="flex items-start justify-end mt-6">
                <x-bit.button.round.secondary wire:click="openSettings({{ $index }})" class="hover:bg-gray-800">Settings</x-bit.button.round.secondary>
            </div>

            <x-bit.input.group :for="'question-question-'.$index" label="Question" class="col-span-3">
                <x-bit.input.text type="text" class="w-full mt-1" :id="'question-question-'.$index" wire:model="form.{{ $index }}.question" />
            </x-bit.input.group>
        </div>

        @includeWhen($question['type'] === 'list', 'livewire.galaxy.forms.types.list')
        @includeWhen($question['type'] === 'matrix', 'livewire.galaxy.forms.types.matrix')
    </div>
    @endif
</div>
