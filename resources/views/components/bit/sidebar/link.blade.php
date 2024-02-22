@props([
    'route',
    'icon',
    'mobile',
])

@if (isset($mobile))
    @if (isRouteActive($route))
        <a
            href="{{ route($route) }}"
            class="group flex items-center rounded-md bg-gray-100 px-2 py-2 text-base font-medium leading-6 text-gray-900 transition duration-150 ease-in-out focus:bg-gray-200 focus:outline-none dark:bg-gray-600 dark:text-gray-100 dark:focus:bg-gray-500"
        >
            @isset($icon)
                <x-dynamic-component
                    :component="$icon"
                    class="mr-4 h-6 w-6 text-gray-500 transition duration-150 ease-in-out group-hover:text-gray-500 group-focus:text-gray-600 dark:text-gray-300 dark:group-hover:text-gray-300 dark:group-focus:text-gray-400"
                />
            @endif

            {{ $slot }}
        </a>
    @else
        <a
            href="{{ route($route) }}"
            class="group flex items-center rounded-md px-2 py-2 text-base font-medium leading-6 text-gray-600 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-900 focus:bg-gray-100 focus:text-gray-900 focus:outline-none dark:text-gray-200 dark:hover:bg-gray-700 dark:hover:text-gray-200 dark:focus:bg-gray-700 dark:focus:text-gray-100"
        >
            @isset($icon)
                <x-dynamic-component
                    :component="$icon"
                    class="mr-4 h-6 w-6 text-gray-400 transition duration-150 ease-in-out group-hover:text-gray-500 group-focus:text-gray-500 dark:group-hover:text-gray-400 dark:group-focus:text-gray-400"
                />
            @endif

            {{ $slot }}
        </a>
    @endif
@else
    @if (isRouteActive($route))
        <a
            href="{{ route($route) }}"
            class="group flex items-center rounded-md bg-gray-100 px-2 py-2 text-sm font-medium leading-5 text-gray-900 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-900 focus:bg-gray-200 focus:outline-none dark:bg-gray-600 dark:text-gray-100 dark:hover:bg-gray-500 dark:hover:text-gray-100 dark:focus:bg-gray-500"
        >
            @isset($icon)
                <x-dynamic-component
                    :component="$icon"
                    class="mr-3 h-6 w-6 text-gray-500 transition duration-150 ease-in-out group-hover:text-gray-500 group-focus:text-gray-600 dark:text-gray-300 dark:group-hover:text-gray-300 dark:group-focus:text-gray-400"
                />
            @endif

            {{ $slot }}
        </a>
    @else
        <a
            href="{{ route($route) }}"
            class="group flex items-center rounded-md px-2 py-2 text-sm font-medium leading-5 text-gray-600 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-900 focus:bg-gray-100 focus:text-gray-900 focus:outline-none dark:text-gray-200 dark:hover:bg-gray-700 dark:hover:text-gray-200 dark:focus:bg-gray-700 dark:focus:text-gray-100"
        >
            @isset($icon)
                <x-dynamic-component
                    :component="$icon"
                    class="mr-3 h-6 w-6 text-gray-400 transition duration-150 ease-in-out group-hover:text-gray-500 group-focus:text-gray-500 dark:group-hover:text-gray-400 dark:group-focus:text-gray-400"
                />
            @endif

            {{ $slot }}
        </a>
    @endif
@endif
