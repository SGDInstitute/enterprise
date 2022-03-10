@props(['label', 'id'])

@isset($label)
<div class="relative flex items-start">
    <div class="flex items-center h-6">
        <input id="{{ $id }}" name="{{ $label }}" {{ $attributes }} type="checkbox" class="w-5 h-5 text-green-600 border-gray-300 rounded dark:border-gray-700 dark:bg-gray-800 focus:ring-green-500">
    </div>
    <div class="ml-2">
        <label for="{{ $label }}" class="font-medium text-gray-700 dark:text-gray-200">{{ $label }}</label>
    </div>
</div>
@else
    <input id="{{ $id }}" {{ $attributes }} type="checkbox" class="w-5 h-5 text-green-600 border-gray-300 rounded dark:border-gray-700 dark:bg-gray-800 focus:ring-green-500">
@endif
