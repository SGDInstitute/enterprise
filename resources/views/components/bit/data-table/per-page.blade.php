@php
    $model = $attributes->get('wire:model.live') ?? 'perPage';
@endphp

<x-bit.input.group inline for="per-page" label="Per Page" inline borderless paddingless>
    <x-bit.input.select wire:model.live="{{ $model }}" id="per-page">
        <option>10</option>
        <option>15</option>
        <option>25</option>
        <option>50</option>
        <option>100</option>
    </x-bit.input.select>
</x-bit.input.group>
