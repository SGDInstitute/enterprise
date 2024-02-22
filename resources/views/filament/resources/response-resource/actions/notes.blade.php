<div class="grid gap-4">
    @foreach ($reviews as $review)
        <div class="flex-auto rounded-md p-3 ring-1 ring-inset ring-gray-200 dark:ring-gray-700">
            <div class="flex justify-between gap-x-4">
                <div class="py-0.5 text-xs leading-5 text-gray-500 dark:text-gray-400">
                    <span class="font-medium text-gray-900 dark:text-gray-200">{{ $review->user->name }}</span>
                    wrote
                </div>
                <time
                    datetime="{{ $review->created_at }}"
                    class="flex-none py-0.5 text-xs leading-5 text-gray-500 dark:text-gray-400"
                >
                    {{ $review->created_at->diffForHumans() }}
                </time>
            </div>
            <p class="text-sm leading-6 text-gray-500 dark:text-gray-400">{{ $review->notes }}</p>
        </div>
    @endforeach
</div>
