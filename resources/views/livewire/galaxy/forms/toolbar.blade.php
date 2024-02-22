<div class="flex items-center space-x-6">
    <div class="flex space-x-2">
        @if ($openIndex === $index)
            <button wire:click="setOpenIndex(null)" class="text-gray-500">
                <x-heroicon-o-minus class="h-4 w-4" />
            </button>
        @else
            <button wire:click="setOpenIndex({{ $index }})" class="text-gray-500">
                <x-heroicon-o-plus class="h-4 w-4" />
            </button>
        @endif
    </div>
    <div class="flex space-x-2">
        @if ($loop->first)
            <button disabled class="cursor-not-allowed text-gray-500 opacity-75">
                <x-heroicon-o-chevron-up class="h-4 w-4" />
            </button>
        @else
            <button wire:click="moveUp({{ $index }})" class="text-gray-500 hover:text-green-500">
                <x-heroicon-o-chevron-up class="h-4 w-4" />
            </button>
        @endif

        @if ($loop->last)
            <button disabled class="cursor-not-allowed text-gray-500 opacity-75">
                <x-heroicon-o-chevron-down class="h-4 w-4" />
            </button>
        @else
            <button wire:click="moveDown({{ $index }})" class="text-gray-500 hover:text-green-500">
                <x-heroicon-o-chevron-down class="h-4 w-4" />
            </button>
        @endif
        <button wire:click="duplicate({{ $index }})" class="text-gray-500 hover:text-green-500">
            <x-heroicon-o-document-duplicate class="h-4 w-4" />
        </button>
        <button
            wire:click="delete({{ $index }})"
            onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
            class="text-gray-500 hover:text-green-500"
        >
            <x-heroicon-o-trash class="h-4 w-4" />
        </button>
    </div>
</div>
