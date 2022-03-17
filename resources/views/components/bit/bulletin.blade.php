<div class="relative p-4 space-y-2 prose bg-gray-100 rounded shadow dark:bg-gray-700 dark:prose-light">
    @if (!$bulletin->isPublished)
    <div title="Scheduled" class="absolute top-0 left-0 z-30 p-2 -ml-4 bg-green-500 rounded-full">
        <x-heroicon-o-clock class="w-4 h-4 text-white" />
    </div>
    @else
    <div></div>
    @endif
    <h2>{{ $bulletin->title }}</h2>
    <p>{!! markdown($bulletin->content) !!}</p>
    <span class="text-sm text-gray-700 dark:text-gray-400">{{ $bulletin->formattedPublishedAt }}</span>
</div>
