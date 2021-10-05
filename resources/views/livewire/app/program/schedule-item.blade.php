<div class="container px-4 mx-auto space-y-4 md:px-0">
    @forelse ($item->children as $child)
        <div class="p-4 text-gray-200 bg-green-500 rounded">
            <h2>{{ $child->name }}</h2>
            <p>{{ $child->shortDescription }}</p>
        </div>
    @empty
    <div class="prose dark:prose-light">
        <h1>{{ $item->name }}</h1>
        <p>{{ $item->formattedDuration }}</p>
        <p>{{ $item->description }}</p>

        @if($isInSchedule)
        <x-bit.button.flat.secondary wire:click="remove">Remove from Schedule</x-bit.button.flat.secondary>
        @else
        <x-bit.button.flat.primary wire:click="add">Add to Schedule</x-bit.button.flat.primary>
        @endif
    </div>
    @endforelse
</div>
