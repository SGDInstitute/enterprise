<table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
    <thead>
        <tr class="divide-x divide-gray-200 dark:divide-gray-700">
            <th scope="col"></th>
            <th scope="col" class="text-xs -rotate-[50deg] origin-top-left leading-none translate-y-2">Alignment</th>
            <th scope="col" class="text-xs -rotate-[50deg] origin-top-left leading-none translate-y-2">Presenter <br>Experience</th>
            <th scope="col" class="text-xs -rotate-[50deg] origin-top-left leading-none translate-y-2">Priority</th>
            <th scope="col" class="text-xs -rotate-[50deg] origin-top-left leading-none translate-y-2">Track</th>
            <th scope="col" class="text-xs -rotate-[50deg] origin-top-left leading-none translate-y-2">Score</th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
        @foreach ($reviews as $review)
        <tr class="divide-x divide-gray-200 dark:divide-gray-700">
            <td class="p-1 pl-0 text-sm font-medium text-gray-900 dark:text-gray-200 whitespace-nowrap">{{ $review->user->name }}</td>
            <td class="p-1 text-sm text-right text-gray-500 dark:text-gray-400 whitespace-nowrap">{{ $review->alignment }}</td>
            <td class="p-1 text-sm text-right text-gray-500 dark:text-gray-400 whitespace-nowrap">{{ $review->experience }}</td>
            <td class="p-1 text-sm text-right text-gray-500 dark:text-gray-400 whitespace-nowrap">{{ $review->priority }}</td>
            <td class="p-1 text-sm text-right text-gray-500 dark:text-gray-400 whitespace-nowrap">{{ $review->track }}</td>
            <td class="p-1 text-sm text-right text-gray-500 dark:text-gray-400 whitespace-nowrap">{{ $review->score }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr class="divide-x divide-gray-200 dark:divide-gray-700">
            <td class="p-1 pl-0 text-sm text-right text-gray-900 dark:text-gray-200 whitespace-nowrap">Total</td>
            <td class="p-1 text-sm text-right text-gray-900 dark:text-gray-200 whitespace-nowrap">{{ $reviews->avg('alignment') }}</td>
            <td class="p-1 text-sm text-right text-gray-900 dark:text-gray-200 whitespace-nowrap">{{ $reviews->avg('experience') }}</td>
            <td class="p-1 text-sm text-right text-gray-900 dark:text-gray-200 whitespace-nowrap">{{ $reviews->avg('priority') }}</td>
            <td class="p-1 text-sm text-right text-gray-900 dark:text-gray-200 whitespace-nowrap">{{ $reviews->avg('track') }}</td>
            <td class="p-1 text-sm text-right text-gray-900 dark:text-gray-200 whitespace-nowrap">{{ $reviews->avg('score') }}</td>
        </tr>
    </tfoot>
</table>