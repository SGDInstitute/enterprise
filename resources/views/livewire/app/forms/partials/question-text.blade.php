<x-bit.input.group :for="$item['id']" :label="$item['question']" :error="$errors->first('answers.' . $item['id'])">
    <x-bit.input.text type="text" class="w-full mt-1" :id="$item['id']" wire:model="answers.{{ $item['id'] }}" :disabled="!$fillable" />
</x-bit.input.group>
