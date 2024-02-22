@props([
    'icon',
    'title',
    'value',
    'color',
    'route',
    'subtitle' => null,
])

<div class="flex flex-col justify-between overflow-hidden rounded-lg bg-white shadow dark:bg-gray-700">
    <div class="px-4 py-5 sm:p-6">
        <div class="flex items-center">
            @isset($icon)
                <div class="bg-{{ $color }}-500 flex-shrink-0 rounded-md p-3">
                    <x-dynamic-component :component="$icon" class="h-6 w-6 text-white" />
                </div>
            @endif

            <div class="{{ isset($icon) ? 'ml-5' : '' }} w-0 flex-1">
                <dl>
                    <dt class="text-sm font-medium leading-5 text-gray-500 dark:text-gray-300">
                        <span class="truncate">{{ $title }}</span>
                        <span class="block text-xs">{{ $subtitle }}</span>
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
        <div class="bg-gray-100 px-4 py-4 dark:bg-gray-500 sm:px-6">
            <div class="text-sm leading-5">
                <a
                    href="{{ route($route) }}"
                    class="text-{{ $color }}-600 dark:text-{{ $color }}-300 hover:text-{{ $color }}-500 dark:hover:text-{{ $color }}-200 font-medium transition duration-150 ease-in-out"
                >
                    View all
                </a>
            </div>
        </div>
    @endif
</div>
