<a href="{{ $url }}" class="h-64 transition duration-150 ease-in-out bg-white dark:bg-gray-800 group hover:bg-green-500 hover:shadow">
    <div class="bg-center bg-cover h-2/3" style="background-image: url({{ $image }});">
        <img src="{{ $image }}" alt="{{ $title }}" class="sr-only">
    </div>
    <div class="px-4 py-2 mx-4 -mt-8 transition duration-150 ease-in-out bg-white dark:bg-gray-800 group-hover:bg-green-500">
        <p class="text-2xl text-gray-900 dark:text-gray-200 group-hover:text-gray-200">{{ $title }}</p>
        <p class="text-gray-700 dark:text-gray-400 group-hover:text-gray-300">{{ $location }}</p>
        <p class="text-sm text-gray-700 dark:text-gray-400 text-italic group-hover:text-gray-300">{{ $dates }}</p>
    </div>
</a>
