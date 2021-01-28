@if($attributes->get('href'))
<span class="inline-flex rounded-md shadow-sm">
    <a
        {{ $attributes->merge([
            'class' => 'inline-flex bg-white dark:border-gray-400 dark:text-gray-300 dark:bg-gray-500 dark:hover:bg-gray-600 py-2 px-4 border rounded-md text-sm leading-5 font-medium focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition duration-150 ease-in-out' . ($attributes->get('disabled') ? ' opacity-75 cursor-not-allowed' : ''),
        ]) }}
    >
        {{ $slot }}
    </a>
</span>
@else
<span class="inline-flex rounded-md shadow-sm">
    <button
        {{ $attributes->merge([
            'type' => 'button',
            'class' => 'inline-flex bg-white dark:border-gray-400 dark:text-gray-300 dark:bg-gray-500 dark:hover:bg-gray-600 py-2 px-4 border rounded-md text-sm leading-5 font-medium focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition duration-150 ease-in-out' . ($attributes->get('disabled') ? ' opacity-75 cursor-not-allowed' : ''),
        ]) }}
    >
        {{ $slot }}
    </button>
</span>
@endif
