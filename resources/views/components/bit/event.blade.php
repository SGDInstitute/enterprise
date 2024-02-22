<a
    href="{{ $url }}"
    class="group block h-64 bg-white transition duration-150 ease-in-out hover:bg-green-500 hover:shadow dark:bg-gray-800"
>
    <div class="h-2/3 bg-cover bg-center" style="background-image: url({{ $image }})">
        <img src="{{ $image }}" alt="{{ $title }}" class="sr-only" />
    </div>
    <div
        class="mx-4 -mt-8 bg-white px-4 py-2 transition duration-150 ease-in-out group-hover:bg-green-500 dark:bg-gray-800"
    >
        <p class="text-2xl text-gray-900 group-hover:text-gray-200 dark:text-gray-200">{{ $title }}</p>
        @isset($subtitle)
            <p class="text-italic text-sm text-gray-700 group-hover:text-gray-300 dark:text-gray-400">
                {{ $subtitle }}
            </p>
        @endif

        <p class="text-italic text-sm text-gray-700 group-hover:text-gray-300 dark:text-gray-400">{{ $dates }}</p>
    </div>
</a>
