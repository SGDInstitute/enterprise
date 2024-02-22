<div class="prose relative space-y-2 rounded bg-gray-100 p-4 shadow dark:prose-light dark:bg-gray-700">
    @if (! $bulletin->isPublished)
        <div title="Scheduled" class="absolute left-0 top-0 z-30 -ml-4 rounded-full bg-green-500 p-2">
            <x-heroicon-o-clock class="h-4 w-4 text-white" />
        </div>
    @else
        <div></div>
    @endif
    <h2>{{ $bulletin->title }}</h2>
    <p>{!! markdown($bulletin->content) !!}</p>
    <span class="text-sm text-gray-700 dark:text-gray-400">{{ $bulletin->formattedPublishedAt }}</span>
</div>
