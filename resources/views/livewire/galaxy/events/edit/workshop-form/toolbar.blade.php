<div class="flex space-x-2">
    @if($loop->first)
    <button disabled class="text-gray-500 opacity-75 cursor-not-allowed">
        <x-heroicon-o-chevron-up class="w-4 h-4" />
    </button>
    @else
    <button wire:click="moveUp({{ $index }})" class="text-gray-500 hover:text-green-500">
        <x-heroicon-o-chevron-up class="w-4 h-4" />
    </button>
    @endif

    @if($loop->last)
    <button disabled class="text-gray-500 opacity-75 cursor-not-allowed">
        <x-heroicon-o-chevron-down class="w-4 h-4" />
    </button>
    @else
    <button wire:click="moveDown({{ $index }})" class="text-gray-500 hover:text-green-500">
        <x-heroicon-o-chevron-down class="w-4 h-4" />
    </button>
    @endif
    <button wire:click="duplicate({{ $index }})" class="text-gray-500 hover:text-green-500">
        <x-heroicon-o-duplicate class="w-4 h-4" />
    </button>
    <button wire:click="delete({{ $index }})" onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" class="text-gray-500 hover:text-green-500">
        <x-heroicon-o-trash class="w-4 h-4" />
    </button>
</div>
