<div class="flex items-center space-x-4">
    <div>
        <span title="{{ $title }}" class="{{ $iconClass }} flex h-12 w-12 items-center justify-center">
            @if ($icon)
                <x-dynamic-component :component="$icon" class="h-6 w-6 text-white" x-description="{{ $title }}" />
            @else
                {{ $iconSlot }}
            @endif
        </span>
    </div>
    <div class="text-lg">{{ $slot }}</div>
</div>
