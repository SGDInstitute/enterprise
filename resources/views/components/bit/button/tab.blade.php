@props([
    'title' => null,
    'icon' => null,
    'id' => null,
    'active' => false,
    'badge' => null,
])

@if($active)
    <a {{ $attributes }} class="inline-flex items-center px-1 py-4 space-x-2 text-sm font-medium leading-5 border-b-2 text-blue-600 dark:text-blue-400 border-blue-500 dark:border-blue-400 focus:text-blue-800 dark:focus:text-blue-200 focus:border-blue-700 dark:focus:border-blue-400 group focus:outline-none" aria-current="page">
        <x-dynamic-component :component="$icon" class="-ml-0.5 h-5 w-5 text-blue-500 dark:text-blue-400 group-focus:text-blue-600 dark:group-focus:text-blue-400" />
        <span>{{ $title }}</span>
        @if($badge && $badge > 0)
        <x-bit.badge>{{ $badge }}</x-bit.badge>
        @endif
    </a>
@else
    <a {{ $attributes }} class="inline-flex items-center px-1 py-4 space-x-2 text-sm font-medium leading-5 text-gray-500 border-b-2 border-transparent dark:text-gray-400 group hover:text-gray-700 dark:hover:text-gray-200 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 dark:focus:text-gray-200">
        <x-dynamic-component :component="$icon" class="-ml-0.5 h-5 w-5 text-gray-400 group-hover:text-gray-500 dark:group-hover:text-gray-300 group-focus:text-gray-600 dark:group-focus:text-gray-400" />
        <span>{{ $title }}</span>
        @if($badge && $badge > 0)
        <x-bit.badge>{{ $badge }}</x-bit.badge>
        @endif
    </a>
@endif
