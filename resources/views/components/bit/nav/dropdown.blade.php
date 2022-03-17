<!-- This example requires Tailwind CSS v2.0+ -->
<div class="relative inline-block text-left" x-data="{open: false}">
    <div>
        <button @click="open = !open" class="{{ $option['active'] ? 'border-green-500 dark:border-green-400 text-green-600 dark:text-green-400' : 'border-transparent text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300' }} inline-flex items-center px-1 py-4 text-sm font-medium border-b-2 group">
            @if ($option['icon'])
            <x-dynamic-component :component="$option['icon']" class="{{ $option['active'] ? 'text-green-500 dark:text-green-400' : 'text-gray-400 group-hover:text-gray-500 dark:group-hover:text-gray-400' }} -ml-0.5 mr-2 h-5 w-5" />
            @endif
            <span>{{ $option['label'] }}</span>
            <x-heroicon-s-chevron-down class="w-5 h-5 ml-2 -mr-1" />
        </button>
    </div>

    <div x-show="open" x-cloak class="absolute right-0 z-50 w-56 mt-2 overflow-hidden origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
        @foreach ($option['children'] as $child)
        <a href="{{ $child['href'] }}" class="{{ $child['active'] ? 'bg-gray-100 text-gray-900' : 'text-gray-700' }} flex items-center px-4 py-2 text-sm group">
            @if ($child['icon'])
            <x-dynamic-component :component="$child['icon']" class="{{ $child['active'] ? 'text-green-500 dark:text-green-400' : 'text-gray-400 group-hover:text-gray-500 dark:group-hover:text-gray-400' }} -ml-0.5 mr-2 h-5 w-5" />
            @endif
            <span>{{ $child['label'] }}</span>
        </a>
        @endforeach
    </div>
</div>
