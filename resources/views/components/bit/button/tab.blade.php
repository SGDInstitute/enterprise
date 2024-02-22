@props([
    'title' => null,
    'icon' => null,
    'id' => null,
    'active' => false,
    'badge' => null,
])

@if ($active)
    <a
        {{ $attributes }}
        class="group inline-flex items-center space-x-2 border-b-2 border-blue-500 px-1 py-4 text-sm font-medium leading-5 text-blue-600 focus:border-blue-700 focus:text-blue-800 focus:outline-none dark:border-blue-400 dark:text-blue-400 dark:focus:border-blue-400 dark:focus:text-blue-200"
        aria-current="page"
    >
        <x-dynamic-component
            :component="$icon"
            class="-ml-0.5 h-5 w-5 text-blue-500 group-focus:text-blue-600 dark:text-blue-400 dark:group-focus:text-blue-400"
        />
        <span>{{ $title }}</span>
        @if ($badge && $badge > 0)
            <x-bit.badge>{{ $badge }}</x-bit.badge>
        @endif
    </a>
@else
    <a
        {{ $attributes }}
        class="group inline-flex items-center space-x-2 border-b-2 border-transparent px-1 py-4 text-sm font-medium leading-5 text-gray-500 hover:border-gray-300 hover:text-gray-700 focus:border-gray-300 focus:text-gray-700 focus:outline-none dark:text-gray-400 dark:hover:text-gray-200 dark:focus:text-gray-200"
    >
        <x-dynamic-component
            :component="$icon"
            class="-ml-0.5 h-5 w-5 text-gray-400 group-hover:text-gray-500 group-focus:text-gray-600 dark:group-hover:text-gray-300 dark:group-focus:text-gray-400"
        />
        <span>{{ $title }}</span>
        @if ($badge && $badge > 0)
            <x-bit.badge>{{ $badge }}</x-bit.badge>
        @endif
    </a>
@endif
