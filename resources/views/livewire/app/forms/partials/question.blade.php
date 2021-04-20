@if($item['type'] === 'textarea')
<x-bit.input.group :for="$item['id']" :label="$item['question']" :error="$errors->first('answers.' . $item['id'])">
    <x-bit.input.textarea wire:ignore class="w-full mt-1" :id="$item['id']" wire:model="answers.{{ $item['id'] }}" :disabled="!$fillable" />
</x-bit.input.group>
@elseif($item['type'] === 'text')
<x-bit.input.group :for="$item['id']" :label="$item['question']" :error="$errors->first('answers.' . $item['id'])">
    <x-bit.input.text type="text" class="w-full mt-1" :id="$item['id']" wire:model="answers.{{ $item['id'] }}" :disabled="!$fillable" />
</x-bit.input.group>
@elseif($item['type'] === 'list')
    @include('livewire.app.forms.partials.question-list')
@else
@json($item)
@endif
