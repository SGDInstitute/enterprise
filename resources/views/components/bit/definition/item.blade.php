@props(['width' => '50/50', 'key' => '', 'value' => ''])

@php
    if ($width === '33/66') {
        $grid = 'grid-cols-3';
        $dt = '';
        $dd = 'col-span-2';
    } else {
        $grid = 'grid-cols-2';
        $dt = '';
        $dd = '';
    }
@endphp

<div
    class="sm:{{ $grid ?? 'grid-cols-2' }} {{ $attributes->get('class') ?? 'px-4 py-2 sm:px-6 sm:py-5' }} sm:grid sm:gap-4"
>
    <dt class="{{ $dt }} text-sm font-bold leading-5 text-gray-500 dark:text-gray-400">
        {{ $key }}
    </dt>
    <dd class="{{ $dd }} mt-1 text-sm leading-5 text-gray-900 dark:text-gray-100 sm:mt-0">
        @if ($value === '')
            {{ $slot }}
        @else
            {{ $value }}
        @endif
    </dd>
</div>
