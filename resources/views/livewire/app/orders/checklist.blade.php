<fieldset class="px-8">
  <legend class="sr-only">Checklist</legend>
  <div class="space-y-4">
    @foreach ($checklist as $item)
    <div class="relative flex items-start">
      <div class="flex h-6 items-center">
        <input id="{{ $item['id'] }}" aria-describedby="{{ $item['id'] }}-description" name="{{ $item['id'] }}" type="checkbox" class="h-5 w-5 rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-green-600 focus:ring-green-600">
      </div>
      <div class="ml-3 leading-6">
        <label for="{{ $item['id'] }}" class="font-medium text-gray-900">{{ $item['label'] }}</label>
        @isset($item['description'])
        <p id="{{ $item['id'] }}-description" class="text-gray-500">{{ $item['description'] }}</p>
        @endif
      </div>
    </div>
    @endforeach
  </div>
</fieldset>
