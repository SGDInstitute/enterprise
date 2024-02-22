@props([
    'color' => 'gray',
])

@php
    $colors = [
        'gray' => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-400',
        'red' => 'bg-red-100 text-red-800',
        'yellow' => 'bg-yellow-100 text-yellow-800',
        'green' => 'bg-green-100 text-green-800',
        'blue' => 'bg-blue-100 text-blue-800',
        'indigo' => 'bg-indigo-100 text-indigo-800',
        'purple' => 'bg-purple-100 text-purple-800',
        'pink' => 'bg-pink-100 text-pink-800',
    ]
@endphp

<span
    {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {$colors[$color]}"]) }}
>
    {{ $slot }}
</span>
