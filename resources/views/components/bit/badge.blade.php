@props([
    'color' => 'gray'
])

@php
$colors = [
    'gray' => 'bg-cool-gray-200 text-cool-gray-800 dark:bg-cool-gray-800 dark:text-cool-gray-300',
    'red' => 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100',
    'orange' => 'bg-orange-100 text-orange-800 dark:bg-orange-800 dark:text-orange-100',
    'yellow' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100',
    'green' => 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100',
    'teal' => 'bg-teal-100 text-teal-800 dark:bg-teal-800 dark:text-teal-100',
    'blue' => 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100',
    'purple' => 'bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100',
    'pink' => 'bg-pink-100 text-pink-800 dark:bg-pink-800 dark:text-pink-100',
]
@endphp

<span {{ $attributes->merge(['class' => "glacial inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 {$colors[$color]}"]) }}>
  {{ $slot}}
</span>
