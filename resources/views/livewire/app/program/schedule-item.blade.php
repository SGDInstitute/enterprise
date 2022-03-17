<div class="container px-4 pb-12 mx-auto space-y-4 md:px-0">
    @if ($item->children->count() > 0)
        <div class="prose dark:prose-light">
            <h1>{{ $item->name }}</h1>
            <p>{{ $item->formattedDuration }}</p>
        </div>

        @foreach ($item->children as $child)
            <a href="{{ route('app.program.schedule-item', [$event, $child]) }}" class="block p-4 border border-gray-500 rounded hover:bg-gray-100 dark:hover:bg-gray-900 dark:border-gray-600">
                <h2 class="text-lg font-semibold dark:text-gray-200">{{ $child->name }}</h2>
                <p class="text-gray-700 dark:text-gray-400">{{ $child->location }}</p>
                <p>{{ $child->shortDescription }}</p>
            </a>
        @endforeach
    @else
        <div class="prose dark:prose-light">
            <h1>{{ $item->name }}</h1>
            <p>{{ $item->formattedDuration }}</p>
            <p>{{ $item->location }}</p>
            <p>{!! markdown($item->description) !!}</p>

            @if ($isInSchedule)
            <x-bit.button.flat.secondary wire:click="remove">Remove from Schedule</x-bit.button.flat.secondary>
            @else
            <x-bit.button.flat.primary wire:click="add">Add to Schedule</x-bit.button.flat.primary>
            @endif
        </div>
    @endif
</div>
