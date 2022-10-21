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
                <p class="text-gray-700 dark:text-gray-400">{{ $child->shortDescription }}</p>
            </a>
        @endforeach
    @else
        <div class="mt-8 prose dark:prose-light">
            <h1>{{ $item->name }}</h1>

            <div class="space-y-2">
                <x-ui.feed.item icon="heroicon-o-calendar" title="When" iconClass="bg-green-500 rounded-md">{{ $item->formattedDuration }}</x-ui.feed.item>
                <x-ui.feed.item icon="heroicon-o-location-marker" title="Location" iconClass="bg-green-500 rounded-md">{{ $item->location }}</x-ui.feed.item>
                @if ($item->speaker)
                <x-ui.feed.item icon="heroicon-o-users" title="Speakers" iconClass="bg-green-500 rounded-md">{{ $item->speaker }}</x-ui.feed.item>
                @endif
                @if ($item->tracks)
                <x-ui.feed.item icon="heroicon-o-collection" title="Tracks" iconClass="bg-green-500 rounded-md">{{ $item->tracks }}</x-ui.feed.item>
                @endif
                @if ($item->warnings)
                <x-ui.feed.item icon="heroicon-o-exclamation" title="Content Warnings" iconClass="bg-green-500 rounded-md">{{ $item->warnings }}</x-ui.feed.item>
                @endif
            </div>

            <p>{!! markdown($item->description) !!}</p>

            @if ($isInSchedule)
            <x-bit.button.flat.secondary wire:click="remove">Remove from Schedule</x-bit.button.flat.secondary>
            @else
            <x-bit.button.flat.primary wire:click="add">Add to Schedule</x-bit.button.flat.primary>
            @endif
        </div>
    @endif
</div>
