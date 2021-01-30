@props(['icon', 'active', 'responsive'])

@php
if(isset($responsive)) {
    $linkClasses = ($active ?? false)
            ? 'flex items-center px-2 py-2 text-base font-medium text-gray-900 bg-gray-100 rounded-md dark:bg-gray-700 dark:text-gray-200 group'
            : 'flex items-center px-2 py-2 text-base font-medium text-gray-600 rounded-md dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-300 group';
} else {
    $linkClasses = ($active ?? false)
            ? 'flex items-center px-2 py-2 text-sm font-medium text-gray-900 bg-gray-100 rounded-md dark:bg-gray-700 dark:text-gray-200 group'
            : 'flex items-center px-2 py-2 text-sm font-medium text-gray-600 rounded-md dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-300 group';
}

$iconClasses = ($active ?? false)
            ? 'w-6 h-6 mr-4 text-gray-500 dark:text-gray-300'
            : 'w-6 h-6 mr-4 text-gray-400 group-hover:text-gray-500 dark:group-hover:text-gray-300';

@endphp

<!-- Current: "bg-gray-100 text-gray-900", Default: "text-gray-600 hover:bg-gray-50 hover:text-gray-900" -->
<a {{ $attributes->merge(['class' => $linkClasses]) }}>
    <!-- Current: "text-gray-500", Default: "text-gray-400 group-hover:text-gray-500" -->
    <x-dynamic-component :component="$icon" :class="$iconClasses" />
    {{ $slot }}
</a>
