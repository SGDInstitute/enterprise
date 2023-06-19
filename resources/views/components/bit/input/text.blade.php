@props([
    'leadingAddOn' => null,
    'trailingAddOn' => null,
    'group' => false
])

@if ($leadingAddOn || $trailingAddOn)
<div class="flex mt-1 rounded-md shadow-sm">
    @if ($leadingAddOn)
        <span class="inline-flex items-center px-3 text-gray-500 border border-r-0 border-gray-300 dark:text-gray-200 dark:bg-gray-800 dark:border-gray-600 rounded-l-md bg-gray-50 sm:text-sm">
            {{ $leadingAddOn }}
        </span>
    @endif

    <input {{ $attributes->merge(['type' => 'text', 'class' => 'flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md text-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 ' . ($attributes->get('disabled') ? ' opacity-75 cursor-not-allowed' : '')]) }}/>

    @if ($trailingAddOn)
        <span class="inline-flex items-center px-3 text-gray-500 border border-r-0 border-gray-300 rounded-l-md bg-gray-50 sm:text-sm">
            {{ $trailingAddOn }}
        </span>
    @endif
</div>
@else
<input {{ $attributes->merge(['type' => 'text', 'class' => 'border-gray-300 rounded-md shadow-sm text-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600 focus:ring-green-500 focus:border-green-500 sm:text-sm' . ($attributes->get('disabled') ? ' opacity-75 cursor-not-allowed' : '')]) }}/>
@endif
