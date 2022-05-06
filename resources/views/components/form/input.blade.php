@props([
    'leading' => false,
    'trailing' => false,
])

@if ($leading && $trailing)
<div class="flex mt-1 rounded-md shadow-sm">
    <span class="inline-flex items-center px-3 text-gray-500 border border-r-0 border-gray-300 rounded-l-md dark:border-gray-700 dark:bg-gray-800 bg-gray-50 dark:text-gray-400">
        {{ $leading }}
    </span>
    <input {{ $attributes->merge(['type' => 'text', 'class' => 'dark:text-gray-200 dark:focus:bg-gray-800 bg-transparent flex-1 focus:ring-green-500 focus:border-green-500 block w-full min-w-0 rounded-none border-gray-300 dark:border-gray-700 disabled:cursor-not-allowed']) }} >
    <span class="inline-flex items-center px-3 text-gray-500 border border-l-0 border-gray-300 rounded-r-md dark:border-gray-700 dark:bg-gray-800 bg-gray-50 dark:text-gray-400">
        {{ $trailing }}
    </span>
</div>
@elseif ($leading)
<div class="flex mt-1 rounded-md shadow-sm">
    <span class="inline-flex items-center px-3 text-gray-500 border border-r-0 border-gray-300 rounded-l-md dark:border-gray-700 dark:bg-gray-800 bg-gray-50 dark:text-gray-400">
        {{ $leading }}
    </span>
    <input {{ $attributes->merge(['type' => 'text', 'class' => 'dark:text-gray-200 dark:focus:bg-gray-800 bg-transparent flex-1 focus:ring-green-500 focus:border-green-500 block w-full min-w-0 rounded-none rounded-r-md border-gray-300 dark:border-gray-700 disabled:cursor-not-allowed']) }} >
</div>
@elseif ($trailing)
<div class="flex mt-1 rounded-md shadow-sm">
    <input {{ $attributes->merge(['type' => 'text', 'class' => 'dark:text-gray-200 dark:focus:bg-gray-800 bg-transparent flex-1 focus:ring-green-500 focus:border-green-500 block w-full min-w-0 rounded-none rounded-l-md border-gray-300 dark:border-gray-700 disabled:cursor-not-allowed']) }} >
    <span class="inline-flex items-center px-3 text-gray-500 border border-l-0 border-gray-300 rounded-r-md dark:border-gray-700 dark:bg-gray-800 bg-gray-50 dark:text-gray-400">
        {{ $trailing }}
    </span>
</div>
@else
<input {{ $attributes->merge(['type' => 'text', 'class' => 'dark:text-gray-200 dark:focus:bg-gray-800 mt-1 shadow-sm bg-transparent focus:ring-green-500 focus:border-green-500 block w-full border-gray-300 dark:border-gray-700 rounded-md disabled:cursor-not-allowed']) }} >
@endif
