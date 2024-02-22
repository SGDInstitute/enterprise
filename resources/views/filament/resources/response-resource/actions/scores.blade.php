<table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
    <thead>
        <tr class="divide-x divide-gray-200 dark:divide-gray-700">
            <th scope="col"></th>
            <th scope="col" class="origin-top-left translate-y-2 -rotate-[50deg] text-xs leading-none">Alignment</th>
            <th scope="col" class="origin-top-left translate-y-2 -rotate-[50deg] text-xs leading-none">
                Presenter
                <br />
                Experience
            </th>
            <th scope="col" class="origin-top-left translate-y-2 -rotate-[50deg] text-xs leading-none">Priority</th>
            <th scope="col" class="origin-top-left translate-y-2 -rotate-[50deg] text-xs leading-none">Track</th>
            <th scope="col" class="origin-top-left translate-y-2 -rotate-[50deg] text-xs leading-none">Score</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
        @foreach ($reviews as $review)
            <tr class="divide-x divide-gray-200 dark:divide-gray-700">
                <td class="whitespace-nowrap p-1 pl-0 text-sm font-medium text-gray-900 dark:text-gray-200">
                    {{ $review->user->name }}
                </td>
                <td class="whitespace-nowrap p-1 text-right text-sm text-gray-500 dark:text-gray-400">
                    {{ $review->alignment }}
                </td>
                <td class="whitespace-nowrap p-1 text-right text-sm text-gray-500 dark:text-gray-400">
                    {{ $review->experience }}
                </td>
                <td class="whitespace-nowrap p-1 text-right text-sm text-gray-500 dark:text-gray-400">
                    {{ $review->priority }}
                </td>
                <td class="whitespace-nowrap p-1 text-right text-sm text-gray-500 dark:text-gray-400">
                    {{ $review->track }}
                </td>
                <td class="whitespace-nowrap p-1 text-right text-sm text-gray-500 dark:text-gray-400">
                    {{ $review->score }}
                </td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr class="divide-x divide-gray-200 dark:divide-gray-700">
            <td class="whitespace-nowrap p-1 pl-0 text-right text-sm text-gray-900 dark:text-gray-200">Total</td>
            <td class="whitespace-nowrap p-1 text-right text-sm text-gray-900 dark:text-gray-200">
                {{ round($reviews->avg('alignment'), 2) }}
            </td>
            <td class="whitespace-nowrap p-1 text-right text-sm text-gray-900 dark:text-gray-200">
                {{ round($reviews->avg('experience'), 2) }}
            </td>
            <td class="whitespace-nowrap p-1 text-right text-sm text-gray-900 dark:text-gray-200">
                {{ round($reviews->avg('priority'), 2) }}
            </td>
            <td class="whitespace-nowrap p-1 text-right text-sm text-gray-900 dark:text-gray-200">
                {{ round($reviews->avg('track'), 2) }}
            </td>
            <td class="whitespace-nowrap p-1 text-right text-sm text-gray-900 dark:text-gray-200">
                {{ round($reviews->avg('score'), 2) }}
            </td>
        </tr>
    </tfoot>
</table>
