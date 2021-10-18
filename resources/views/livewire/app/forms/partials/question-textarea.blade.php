<x-bit.input.group :for="$item['id']" :label="$item['question']" :error="$errors->first('answers.' . $item['id'])">
    <x-bit.input.textarea wire:ignore class="w-full mt-1" :id="$item['id']" wire:model="answers.{{ $item['id'] }}" :disabled="!$fillable" />
</x-bit.input.group>
