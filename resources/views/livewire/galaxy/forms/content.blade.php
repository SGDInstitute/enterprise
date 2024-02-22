<div class="rounded-md bg-white shadow dark:bg-gray-800">
    <div class="flex items-center justify-between rounded-md bg-white p-4 dark:bg-gray-850">
        <span class="dark:text-gray-400">Content {{ $index + 1 }}</span>
        @include('livewire.galaxy.forms.toolbar')
    </div>
    @if ($openIndex === $index)
        <div class="space-y-4 rounded-b-md p-4">
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
            <x-bit.input.group :for="'text-content-'.$index" label="Content">
                <x-bit.input.trix
                    :id="'text-content-'.$index"
                    class="mt-1 block w-full"
                    name="content"
                    wire:model.live="form.{{ $index }}.content"
                />
            </x-bit.input.group>
        </div>
    @endIf
</div>
