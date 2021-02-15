@props(['options'])

<div {{ $attributes }}>
  <div class="sm:hidden">
    <label for="tabs" class="sr-only">Select a tab</label>
    <select id="tabs" name="tabs" class="block w-full border-gray-300 rounded-md dark:border-gray-700 focus:ring-indigo-500 focus:border-indigo-500">
        @foreach($options as $option)
            <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
        @endforeach
    </select>
  </div>
  <div class="hidden sm:block">
    <div class="border-b border-gray-200 dark:border-gray-600">
      <nav class="flex -mb-px space-x-8" aria-label="Tabs">
        @foreach($options as $option)
        <a href="{{ $option['href'] }}" class="{{ $option['active'] ? 'border-indigo-500 dark:border-indigo-400 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300' }} inline-flex items-center px-1 py-4 text-sm font-medium border-b-2 group">
          @if($option['icon'])
          <x-dynamic-component :component="$option['icon']" class="{{ $option['active'] ? 'text-indigo-500 dark:text-indigo-400' : 'text-gray-400 group-hover:text-gray-500 dark:group-hover:text-gray-400' }} -ml-0.5 mr-2 h-5 w-5" />
          @endif
          <span>{{ $option['label'] }}</span>
        </a>
        @endforeach
      </nav>
    </div>
  </div>
</div>
