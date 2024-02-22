<div class="rounded-md bg-white shadow dark:bg-gray-800">
    <div class="flex items-center justify-between rounded-md bg-white p-4 dark:bg-gray-850">
        <span class="w-2/3 truncate dark:text-gray-400">
            Question {{ $index + 1 }}{{ $form[$index]['question'] !== '' ? ': ' . $form[$index]['question'] : '' }}
        </span>
        @include('livewire.galaxy.forms.toolbar')
    </div>
    @if ($openIndex === $index)
        <div class="space-y-4 rounded-b-md p-4">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                <x-bit.input.group :for="'question-id-'.$index" label="ID">
                    <x-bit.input.text
                        type="text"
                        class="mt-1 w-full"
                        :id="'question-id-'.$index"
                        wire:model.live="form.{{ $index }}.id"
                    />
                    <x-bit.input.help>
                        Short, unique identifier for question. Use dashes instead of spaces.
                    </x-bit.input.help>
                </x-bit.input.group>

                <x-bit.input.group :for="'question-type-'.$index" label="Type of Question">
                    <x-bit.input.select
                        class="mt-1 w-full"
                        :id="'question-type-'.$index"
                        wire:model.live="form.{{ $index }}.type"
                    >
                        <option value="" disabled>Select Type</option>
                        @foreach ($typeOptions as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-bit.input.select>
                </x-bit.input.group>

                <div class="mt-6 flex items-start justify-end">
                    <x-bit.button.round.secondary wire:click="openSettings({{ $index }})" class="hover:bg-gray-800">
                        Settings
                    </x-bit.button.round.secondary>
                </div>

                <x-bit.input.group :for="'question-question-'.$index" label="Question" class="col-span-3">
                    <x-bit.input.text
                        type="text"
                        class="mt-1 w-full"
                        :id="'question-question-'.$index"
                        wire:model.live="form.{{ $index }}.question"
                    />
                </x-bit.input.group>
                <x-bit.input.group :for="'question-help-'.$index" label="Help Text" class="col-span-3">
                    <x-bit.input.text
                        type="text"
                        class="mt-1 w-full"
                        :id="'question-help-'.$index"
                        wire:model.live="form.{{ $index }}.help"
                    />
                </x-bit.input.group>
            </div>

            @includeWhen($question['type'] === 'list', 'livewire.galaxy.forms.types.list')
            @includeWhen($question['type'] === 'matrix', 'livewire.galaxy.forms.types.matrix')
        </div>
    @endif
</div>
