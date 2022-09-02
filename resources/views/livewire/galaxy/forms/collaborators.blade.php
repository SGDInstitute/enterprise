<div class="bg-white rounded-md shadow dark:bg-gray-800">
    <div class="flex items-center justify-between p-4 bg-white rounded-md dark:bg-gray-850">
        <span class="dark:text-gray-400">Collaborators {{ $index + 1 }}</span>
        @include('livewire.galaxy.forms.toolbar')
    </div>
    @if ($openIndex === $index)
    <div class="p-4 space-y-4 rounded-b-md">
        <x-bit.input.group :for="'question-id-'.$index" label="ID">
            <x-bit.input.text type="text" class="w-full mt-1" :id="'question-id-'.$index" wire:model="form.{{ $index }}.id" />
            <x-bit.input.help>Short, unique identifier for question. Use dashes instead of spaces.</x-bit.input.help>
        </x-bit.input.group>

        @if ($model->parent_id !== null)
        <div class="space-y-4">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200">Data</h3>
            <x-bit.input.checkbox :id="'question-data-'.$openIndex" :label="__('Pull Value From Parent Form')" wire:model="form.{{ $openIndex }}.data" />
        </div>
        @endif
    </div>
    @endif
</div>
