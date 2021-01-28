@props(['icon', 'title', 'value', 'color', 'route'])

<div class="flex flex-col justify-between overflow-hidden bg-white rounded-lg shadow dark:bg-gray-700">
    <div class="px-4 py-5 sm:p-6">
        <div class="flex items-center">
            @isset($icon)
            <div class="flex-shrink-0 p-3 bg-{{ $color }}-500 rounded-md">
                <x-dynamic-component :component="$icon" class="w-6 h-6 text-white" />
            </div>
            @endif
            <div class="flex-1 w-0 {{ isset($icon) ? 'ml-5' : ''}}">
                <dl>
                    <dt class="text-sm font-medium leading-5 text-gray-500 truncate dark:text-gray-200 dark:text-gray-300 glacial">
                        {{ $title }}
                    </dt>
                    <dd class="flex items-baseline">
                        <div class="text-2xl font-semibold leading-8 text-gray-900 dark:text-gray-100">
                            {{ $value ?? $slot }}
                        </div>
                    </dd>
                </dl>
            </div>
        </div>
    </div>
    @isset($route)
    <div class="px-4 py-4 bg-gray-100 dark:bg-gray-500 sm:px-6">
        <div class="text-sm leading-5">
            <a href="{{ route($route) }}" class="font-medium text-{{ $color }}-600 dark:text-{{ $color }}-300 transition duration-150 ease-in-out hover:text-{{ $color }}-500 dark:hover:text-{{ $color }}-200">
                View all
            </a>
        </div>
    </div>
    @endif
</div>
