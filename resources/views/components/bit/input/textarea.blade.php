<textarea
    {{ $attributes->merge(['class' => 'block w-full dark:text-gray-200 border-gray-300 dark:bg-gray-800 dark:border-gray-600 border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm' . ($attributes->get('disabled') ? ' opacity-75 cursor-not-allowed' : '')]) }}
    rows="3"
></textarea>
