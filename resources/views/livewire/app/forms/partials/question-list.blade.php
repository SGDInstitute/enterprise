@php
    $options = [];

    foreach($item['options'] as $option) {
        if(str_contains($option, ':')) {
            $parts = explode(':', $option);
            $parts[0] = Str::slug($parts[0]);
            $options[$parts[0]] = $parts[1];
        } else {
            $options[$option] = $option;
        }
    }
@endphp

<div>
    @if($item['list-style'] === 'dropdown')
    <x-bit.input.group :for="$item['id']" :label="$item['question']">
        <x-bit.input.select class="w-full mt-1" :id="$item['id']" wire:model="answers.{{ $item['id'] }}" :disabled="!$fillable">
            <option value="" disabled>Select Option</option>
            @foreach($options as $key => $label)
            <option value="{{ $key }}">{{ $label }}</option>
            @endforeach
            @if($item['list-other'] === true)
            <option value="other">Other</option>
            @endif
        </x-bit.input.select>
    </x-bit.input.group>

    @if($answers[$item['id']] === 'other')
    <x-bit.input.group class="mt-2" :for="$item['id'].'-other'" label="Please fill in">
        <x-bit.input.text type="text" class="w-full mt-1" :id="$item['id'].'-other'" wire:model="answers.{{ $item['id'] }}-other" />
    </x-bit.input.group>
    @endif

    @elseif($item['list-style'] === 'checkbox')
    <x-bit.input.group :for="$item['id']" :label="$item['question']">
        <div class="mt-1 space-y-1">
            @foreach($options as $key => $label)
            <x-bit.input.checkbox :value="$key" :id="$item['id'].'-'.$key" :label="$label" wire:model="answers.{{ $item['id'] }}" :disabled="!$fillable" />
            @endforeach
            @if(isset($item['list-other']) && $item['list-other'] === true)
            <x-bit.input.checkbox value="other" label="Other" wire:model="answers.{{ $item['id'] }}" :disabled="!$fillable" />
            @endif
        </div>
    </x-bit.input.group>

    @if(in_array('other', $answers[$item['id']]))
    <x-bit.input.group class="mt-2" :for="$item['id'].'-other'" label="Please fill in">
        <x-bit.input.text type="text" class="w-full mt-1" :id="$item['id'].'-other'" wire:model="answers.{{ $item['id'] }}-other" />
    </x-bit.input.group>
    @endif

    @elseif($item['list-style'] === 'radio')
    <x-bit.input.group :for="$item['id']" :label="$item['question']">
        <div class="mt-1 space-y-1">
            @foreach($options as $key => $label)
            <x-bit.input.radio :value="$key" :id="$item['id'].'-'.$key" :label="$label" wire:model="answers.{{ $item['id'] }}" :disabled="!$fillable" />
            @endforeach
            @if(isset($item['list-other']) && $item['list-other'] === true)
            <x-bit.input.radio value="other" label="Other" wire:model="answers.{{ $item['id'] }}" :disabled="!$fillable" />
            @endif
        </div>
    </x-bit.input.group>

    @if($answers[$item['id']] === 'other')
    <x-bit.input.group class="mt-2" :for="$item['id'].'-other'" label="Please fill in">
        <x-bit.input.text type="text" class="w-full mt-1" :id="$item['id'].'-other'" wire:model="answers.{{ $item['id'] }}-other" />
    </x-bit.input.group>
    @endif

    @endif

</div>
