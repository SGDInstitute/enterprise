<x-bit.input.group :for="$item['id']" :label="$item['question']" :error="$errors->first('answers.' . $item['id'])">
    @isset($item['help'])
        <x-bit.input.help>{{ $item['help'] }}</x-bit.input.help>
    @endif

    <x-bit.input.textarea wire:ignore class="w-full mt-1" :id="$item['id']" wire:model.blur="answers.{{ $item['id'] }}" :disabled="!$fillable" />
</x-bit.input.group>
