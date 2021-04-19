<select {{ $attributes->merge(['class' => 'py-2 pl-3 pr-10 text-base border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm' . ($attributes->get('disabled') ? ' opacity-75 cursor-not-allowed' : '')]) }}>
    {{ $slot }}
</select>
