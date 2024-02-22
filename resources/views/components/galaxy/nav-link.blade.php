@props([
    'icon',
    'active',
    'responsive',
])

@php
    if (isset($responsive)) {
        $linkClasses =
            $active ?? false
                ? 'group flex items-center rounded-md bg-gray-100 px-2 py-2 text-base font-medium text-gray-900 dark:bg-gray-700 dark:text-gray-200'
                : 'group flex items-center rounded-md px-2 py-2 text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-gray-300';
    } else {
        $linkClasses =
            $active ?? false
                ? 'group flex items-center rounded-md bg-gray-100 px-2 py-2 text-sm font-medium text-gray-900 dark:bg-gray-700 dark:text-gray-200'
                : 'group flex items-center rounded-md px-2 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-gray-300';
    }

    $iconClasses = $active ?? false ? 'mr-4 h-6 w-6 text-gray-500 dark:text-gray-300' : 'mr-4 h-6 w-6 text-gray-400 group-hover:text-gray-500 dark:group-hover:text-gray-300';
@endphp

<!-- Current: "bg-gray-100 text-gray-900", Default: "text-gray-600 hover:bg-gray-50 hover:text-gray-900" -->
<a {{ $attributes->merge(['class' => $linkClasses]) }}>
    <!-- Current: "text-gray-500", Default: "text-gray-400 group-hover:text-gray-500" -->
    <x-dynamic-component :component="$icon" :class="$iconClasses" />
    {{ $slot }}
</a>
