@props(['icon', 'title', 'button'])

<x-tooltip>
    @isset($button)
    <x-bit.button.link size="py-1 px-2">
        <x-dynamic-component :component="$icon" class="w-4 h-4 text-gray-500 dark:text-gray-300" />
    </x-bit.button.link>
    @else
        <x-dynamic-component :component="$icon" class="w-4 h-4" />
    @endif

    <x-slot name="tip">
        {{ $title }}
    </x-slot>
</x-tooltip>
