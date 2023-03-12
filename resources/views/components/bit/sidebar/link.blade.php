@props(['route', 'icon', 'mobile'])

@if (isset($mobile))
@if (isRouteActive($route))
<a href="{{ route($route) }}" class="flex items-center px-2 py-2 text-base font-medium leading-6 text-gray-900 transition duration-150 ease-in-out bg-gray-100 rounded-md group dark:text-gray-100 dark:bg-gray-600 focus:outline-none focus:bg-gray-200 dark:focus:bg-gray-500">
    @isset($icon)
    <x-dynamic-component :component="$icon" class="w-6 h-6 mr-4 text-gray-500 transition duration-150 ease-in-out dark:text-gray-300 group-hover:text-gray-500 dark:group-hover:text-gray-300 group-focus:text-gray-600 dark:group-focus:text-gray-400" />
    @endif
    {{ $slot }}
</a>
@else
<a href="{{ route($route) }}" class="flex items-center px-2 py-2 text-base font-medium leading-6 text-gray-600 transition duration-150 ease-in-out rounded-md group dark:text-gray-200 hover:text-gray-900 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:text-gray-900 dark:focus:text-gray-100 focus:bg-gray-100 dark:focus:bg-gray-700">
    @isset($icon)
    <x-dynamic-component :component="$icon" class="w-6 h-6 mr-4 text-gray-400 transition duration-150 ease-in-out group-hover:text-gray-500 dark:group-hover:text-gray-400 group-focus:text-gray-500 dark:group-focus:text-gray-400" />
    @endif
    {{ $slot }}
</a>
@endif
@else
@if (isRouteActive($route))
<a href="{{ route($route) }}" class="flex items-center px-2 py-2 text-sm font-medium leading-5 text-gray-900 transition duration-150 ease-in-out bg-gray-100 rounded-md dark:text-gray-100 dark:bg-gray-600 group hover:text-gray-900 dark:hover:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-500 focus:outline-none focus:bg-gray-200 dark:focus:bg-gray-500">
    @isset($icon)
    <x-dynamic-component :component="$icon" class="w-6 h-6 mr-3 text-gray-500 transition duration-150 ease-in-out dark:text-gray-300 group-hover:text-gray-500 dark:group-hover:text-gray-300 group-focus:text-gray-600 dark:group-focus:text-gray-400" />
    @endif
    {{ $slot }}
</a>
@else
<a href="{{ route($route) }}" class="flex items-center px-2 py-2 text-sm font-medium leading-5 text-gray-600 transition duration-150 ease-in-out rounded-md dark:text-gray-200 group hover:text-gray-900 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:text-gray-900 dark:focus:text-gray-100 focus:bg-gray-100 dark:focus:bg-gray-700">
    @isset($icon)
    <x-dynamic-component :component="$icon" class="w-6 h-6 mr-3 text-gray-400 transition duration-150 ease-in-out group-hover:text-gray-500 dark:group-hover:text-gray-400 group-focus:text-gray-500 dark:group-focus:text-gray-400" />
    @endif
    {{ $slot }}
</a>
@endif
@endif
