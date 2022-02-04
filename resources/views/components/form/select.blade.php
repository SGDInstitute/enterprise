@props([
    'options' => false,
    'placeholder' => false,
])

<select {{ $attributes->merge(['class' => 'mt-1 block dark:text-gray-200 dark:focus:bg-gray-800 focus:ring-indigo-500 focus:border-indigo-500 w-full shadow-sm bg-transparent border-gray-300 dark:border-gray-700 rounded-md']) }} >
    @if($placeholder)
    <option value="">{{ $placeholder }}</option>
    @endif

    {{ $slot }}

    @if($options)
        @foreach($options as $option)
        <option value="{{ $option->id }}">{{ $option->name }}</option>
        @endforeach
    @endif
</select>
