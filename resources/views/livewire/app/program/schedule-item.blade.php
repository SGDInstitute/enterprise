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
                <div class="flex items-center space-x-4">
                    <div>
                        <span title="When" class="flex items-center justify-center w-12 h-12 bg-green-500 rounded-md bg-opacity-10">
                            <x-heroicon-o-calendar class="w-6 h-6 text-white" x-description="When" />
                        </span>
                    </div>
                    <div class="text-lg">{{ $item->formattedDuration }}</div>
                </div>
                <div class="flex items-center space-x-4">
                    <div>
                        <span title="Location" class="flex items-center justify-center w-12 h-12 bg-green-500 rounded-md bg-opacity-10">
                            <x-heroicon-o-location-marker class="w-6 h-6 text-white" x-description="Location" />
                        </span>
                    </div>
                    <div class="text-lg">{{ $item->location }}</div>
                </div>
                <div class="flex items-center space-x-4">
                    <div>
                        <span title="Speakers" class="flex items-center justify-center w-12 h-12 bg-green-500 rounded-md bg-opacity-10">
                            <x-heroicon-o-users class="w-6 h-6 text-white" x-description="Speakers" />
                        </span>
                    </div>
                    <div class="text-lg">{{ $item->speakers }}</div>
                </div>
                <div class="flex items-center space-x-4">
                    <div>
                        <span title="Tracks" class="flex items-center justify-center w-12 h-12 bg-green-500 rounded-md bg-opacity-10">
                            <x-heroicon-o-collection class="w-6 h-6 text-white" x-description="Tracks" />
                        </span>
                    </div>
                    <div class="text-lg">{{ $item->tracks }}</div>
                </div>
                <div class="flex items-center space-x-4">
                    <div>
                        <span title="Content Warnings" class="flex items-center justify-center w-12 h-12 bg-green-500 rounded-md bg-opacity-10">
                            <x-heroicon-o-exclamation class="w-6 h-6 text-white" x-description="Content Warnings" />
                        </span>
                    </div>
                    <div class="text-lg">{{ $item->warnings }}</div>
                </div>
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
