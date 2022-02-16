@props(['model' => false, 'label' => false, 'type' => false, 'options' => [], 'placeholder' => false, 'leading' => false, 'trailing' => false])

<div>
    <x-form.label :for="$model">{{ $label }}</x-form.label>

    @if($type === 'select')
    <x-dynamic-component component="form.select" :id="$model" wire:model="{{ $model }}" :options="$options" :placeholder="$placeholder" {{ $attributes }}/>
    @elseif($type === 'email' || $type === 'password')
    <x-dynamic-component :type="$type ?? 'text'" component="form.input" :id="$model" wire:model.lazy="{{ $model }}" :placeholder="$placeholder" :leading="$leading" :trailing="$trailing" {{ $attributes }}/>
    @elseif($type === 'input' || $type === 'number' || $type === 'text')
    <x-dynamic-component :type="$type ?? 'text'" component="form.input" :id="$model" wire:model="{{ $model }}" :placeholder="$placeholder" :leading="$leading" :trailing="$trailing" {{ $attributes }}/>
    @elseif($type)
    <x-dynamic-component :component="'form.' . $type" :id="$model" wire:model="{{ $model }}" {{ $attributes }}/>
    @else
    {{ $slot }}
    @endif
    <x-form.error :error="$errors->first($model)" />
</div>
