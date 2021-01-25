@props(['disabled' => false])

<label for="{{ $attributes->get('id') }}" class="inline-flex items-center">
    <input {{ $disabled ? 'disabled' : '' }} type="checkbox" {!! $attributes->merge(['class' => 'text-indigo-600 border-gray-300 dark:border-gray-600 dark:bg-gray-800 rounded shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50']) !!}>
    <span class="ml-2 text-sm text-gray-600 dark:text-gray-200">{{ $slot }}</span>
</label>
