<div class="flex items-center space-x-4">
    <div>
        <span title="{{ $title }}" class="flex items-center justify-center w-12 h-12 {{ $iconClass }}">
            @if ($icon)
            <x-dynamic-component :component="$icon" class="w-6 h-6 text-white" x-description="{{ $title }}" />
            @else
                {{ $iconSlot }}
            @endif
        </span>
    </div>
    <div class="text-lg">{{ $slot }}</div>
</div>
