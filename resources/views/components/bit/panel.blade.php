@props([
    'title' => null,
    'footer' => null,
    'collapsable' => false,
    'collapsedDefault' => false,
])

@if($collapsable)
<div x-data="{collapsed: {{ $collapsedDefault }}}" {{ $attributes->merge(['class' => 'relative overflow-hidden bg-white dark:bg-gray-700 rounded-lg shadow' ]) }}>
@else
<div {{ $attributes->merge(['class' => 'relative bg-white dark:bg-gray-700 rounded-lg shadow' ]) }}>
@endif
    @if($collapsable)
    <div class="absolute top-0 right-0 mt-3 mr-4" x-cloak>
        <x-heroicon-o-plus-circle @click="collapsed = !collapsed" x-show="collapsed" class="w-6 h-6 dark:text-gray-200" />
        <x-heroicon-o-minus-circle @click="collapsed = !collapsed" x-show="!collapsed" class="w-6 h-6 dark:text-gray-200" />
    </div>
    @endif
    @if($title)
    <x-bit.panel.heading class="dark:text-gray-200">{{ $title }}</x-bit.panel.heading>
    @endif

    @if($collapsable)
    <div x-show="!collapsed" x-cloak>
        {{ $slot }}
    </div>
    @else
    {{ $slot }}
    @endif
</div>
