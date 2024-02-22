<!-- This example requires Tailwind CSS v2.0+ -->
<div class="relative inline-block text-left" x-data="{ open: false }">
    <div>
        <button
            @click="open = !open"
            class="{{ $option['active'] ? 'border-green-500 text-green-600 dark:border-green-400 dark:text-green-400' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:hover:text-gray-300' }} group inline-flex items-center border-b-2 px-1 py-4 text-sm font-medium"
        >
            @if ($option['icon'])
                <x-dynamic-component
                    :component="$option['icon']"
                    class="{{ $option['active'] ? 'text-green-500 dark:text-green-400' : 'text-gray-400 group-hover:text-gray-500 dark:group-hover:text-gray-400' }} -ml-0.5 mr-2 h-5 w-5"
                />
            @endif

            <span>{{ $option['label'] }}</span>
            <x-heroicon-s-chevron-down class="-mr-1 ml-2 h-5 w-5" />
        </button>
    </div>

    <div
        x-show="open"
        x-cloak
        class="absolute right-0 z-50 mt-2 w-56 origin-top-right overflow-hidden rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
        role="menu"
        aria-orientation="vertical"
        aria-labelledby="menu-button"
        tabindex="-1"
    >
        @foreach ($option['children'] as $child)
            <a
                href="{{ $child['href'] }}"
                class="{{ $child['active'] ? 'bg-gray-100 text-gray-900' : 'text-gray-700' }} group flex items-center px-4 py-2 text-sm"
            >
                @if ($child['icon'])
                    <x-dynamic-component
                        :component="$child['icon']"
                        class="{{ $child['active'] ? 'text-green-500 dark:text-green-400' : 'text-gray-400 group-hover:text-gray-500 dark:group-hover:text-gray-400' }} -ml-0.5 mr-2 h-5 w-5"
                    />
                @endif

                <span>{{ $child['label'] }}</span>
            </a>
        @endforeach
    </div>
</div>
