@props(['label', 'id', 'name'])

@isset ($label)
<div class="flex items-center">
    <input id="{{ $id }}" name="{{ $name }}" {{ $attributes }} type="radio" class="w-4 h-4 text-green-600 border-gray-300 dark:bg-gray-800 dark:border-gray-700 focus:ring-green-500">
    <label for="{{ $id }}" class="ml-3 font-medium text-gray-700 dark:text-gray-200">{{ $label }}</label>
</div>
@else
    <input id="{{ $id }}" {{ $attributes }} type="radio" class="w-5 h-5 text-green-600 border-gray-300 rounded dark:border-gray-700 dark:bg-gray-800 focus:ring-green-500">
@endif
