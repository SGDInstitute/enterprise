@props([
    'leadingAddOn' => null,
    'trailingAddOn' => null,
    'group' => false
])

<div class="flex rounded-md shadow-sm {{ $group ? 'rounded-r-none' : '' }}">
    @if ($leadingAddOn)
        <span class="inline-flex items-center px-3 text-gray-500 border border-r-0 border-gray-300 dark:text-gray-300 dark:bg-gray-600 dark:border-gray-400 rounded-l-md bg-cool-gray-50 sm:text-sm">
            {{ $leadingAddOn }}
        </span>
    @endif

    <input {{ $attributes->merge(['class' => 'flex-1 form-input dark:bg-gray-500 dark:border-gray-400 dark:text-gray-200 border-gray-300 block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5' . ($group ? ' rounded-r-none' : '') . ($leadingAddOn && !$group ? ' rounded-none rounded-r-md' : '') . ($leadingAddOn && $group ? ' rounded-none' : '') . ($trailingAddOn ? ' rounded-none rounded-l-md' : '') . ($attributes->get('disabled') ? ' opacity-75 cursor-not-allowed' : '')]) }}/>

    @if ($trailingAddOn)
        <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium leading-5 text-gray-700 border border-gray-300 dark:text-gray-300 dark:bg-gray-600 dark:border-gray-400 rounded-r-md bg-cool-gray-50">
            {{ $trailingAddOn }}
        </span>
    @endif
</div>
