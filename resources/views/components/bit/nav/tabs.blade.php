@props(['options', 'action' => false])

<div {{ $attributes }}>
    <div class="sm:hidden">
        <label for="tabs" class="sr-only">Select a tab</label>
        <select id="tabs" name="tabs" class="block w-full border-gray-300 rounded-md dark:border-gray-700 focus:ring-green-500 focus:border-green-500">
            @foreach($options as $option)
                @isset($option['children'])
                    <option value="{{ $option['value'] }}" disabled>{{ $option['label'] }}</option>

                    @foreach($option['children'] as $child)
                    <option value="{{ $child['value'] }}">{{ $child['label'] }}</option>
                    @endforeach
                @else
                    <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                @endisset
            @endforeach
        </select>
    </div>
    <div class="hidden sm:block">
        <div class="flex items-center justify-between border-b border-gray-200 dark:border-gray-600">
            <nav class="flex -mb-px space-x-4" aria-label="Tabs">
                @foreach($options as $option)
                    @isset($option['children'])
                        @include('components.bit.nav.dropdown')
                    @else
                    <a href="{{ $option['href'] }}" class="{{ $option['active'] ? 'border-green-500 dark:border-green-400 text-green-600 dark:text-green-400' : 'border-transparent text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300' }} inline-flex items-center px-1 py-4 text-sm font-medium border-b-2 group">
                        @if($option['icon'])
                        <x-dynamic-component :component="$option['icon']" class="{{ $option['active'] ? 'text-green-500 dark:text-green-400' : 'text-gray-400 group-hover:text-gray-500 dark:group-hover:text-gray-400' }} -ml-0.5 mr-2 h-5 w-5" />
                        @endif
                        <span>{{ $option['label'] }}</span>
                    </a>
                    @endisset
                @endforeach
            </nav>
            @if($action)
            <x-bit.button.round.secondary size="sm" :href="$action['href']">{{ $action['label'] }}</x-bit.button.round.secondary>
            @endif
        </div>
    </div>
</div>
