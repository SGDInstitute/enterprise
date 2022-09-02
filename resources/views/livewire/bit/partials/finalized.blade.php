<div class="relative flex items-start space-x-3">
    <div>
        <div class="relative px-1">
            <div class="flex items-center justify-center w-8 h-8 bg-gray-200 rounded-full dark:bg-gray-800 ring-8 ring-gray-100 dark:ring-gray-700">
                <x-heroicon-s-pencil class="w-5 h-5 text-gray-500" />
            </div>
        </div>
    </div>
    <div class="min-w-0 flex-1 py-1.5">
        <div class="text-sm text-gray-500 dark:text-gray-300">
            {{ $activity['properties']['comment']}}
            <span class="text-gray-400 whitespace-nowrap">{{ $activity->created_at->diffForHumans() }}</span>
        </div>
    </div>
</div>
