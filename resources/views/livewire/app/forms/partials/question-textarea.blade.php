<x-bit.input.group :for="$item['id']" :label="$item['question']" :error="$errors->first('answers.' . $item['id'])">
    @isset($item['help'])
        <x-bit.input.help>{{ $item['help'] }}</x-bit.input.help>
    @endif

    <x-bit.input.textarea
        wire:ignore
        class="mt-1 w-full"
        :id="$item['id']"
        wire:model.blur="answers.{{ $item['id'] }}"
        :disabled="!$fillable"
    />
</x-bit.input.group>
