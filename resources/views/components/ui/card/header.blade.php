@props(['title' => 'Define a title'])

<div
    class="flex items-center justify-between space-x-4 border-b border-gray-200 bg-white px-4 py-5 dark:border-gray-700 dark:bg-gray-800 sm:px-6"
>
    <h2 class="text-xl font-medium leading-6 text-gray-900 dark:text-gray-200">{{ $title }}</h2>

    <div>
        {{ $slot }}
    </div>
</div>
