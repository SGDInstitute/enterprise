<div wire:ignore
    class="flex mt-1 rounded-md shadow-sm">
    <span class="inline-flex items-center px-3 text-sm text-gray-500 border border-r-0 border-gray-300 rounded-l-md bg-gray-50 dark:bg-gray-900 dark:text-gray-400 dark:border-gray-600">
        $
    </span>
    <input class="flex-1 block w-full border-gray-300 rounded-none dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 rounded-r-md sm:text-sm"
        {{ $attributes }}
    />
</div>
