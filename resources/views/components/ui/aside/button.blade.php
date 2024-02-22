@props([
    'tab',
    'icon',
])

<button
    @click="tab = '{{ $tab }}'"
    type="button"
    class="group flex w-full items-center rounded-md px-3 py-2 text-sm font-medium"
    aria-current="page"
    :class="tab === '{{ $tab }}' ? 'bg-gray-50 dark:bg-gray-850 text-green-700 dark:text-green-400 hover:text-green-700 dark:hover:text-green-400 hover:bg-white dark:hover:bg-gray-800' : 'text-gray-900 dark:text-gray-200 hover:text-gray-900 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-850'"
>
    <x-dynamic-component
        :component="$icon"
        class="-ml-1 mr-3 h-6 w-6 flex-shrink-0"
        x-bind:class="tab === '{{ $tab }}' ? 'text-green-500 group-hover:text-green-500' : 'text-gray-400 group-hover:text-gray-500'"
    />
    <span class="truncate">{{ $slot }}</span>
</button>
