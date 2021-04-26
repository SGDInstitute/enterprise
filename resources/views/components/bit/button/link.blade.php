@props([
    'href' => null
])

@if($href)
<a
    href="{{ $href }}"
    {{ $attributes->merge([
        'class' => 'inline-flex rounded-md ' . ($attributes->get('size') ? $attributes->get('size') : 'py-2 px-4') . ' text-gray-700 dark:text-gray-200 text-sm leading-5 font-medium hover:bg-cool-gray-100 dark:hover:bg-cool-gray-700 focus:outline-none focus:text-gray-800 dark:focus:text-gray-200 dark:focus:bg-cool-gray-700 focus:underline transition duration-150 ease-in-out' . ($attributes->get('disabled') ? ' opacity-75 cursor-not-allowed' : ''),
    ]) }}
>
    {{ $slot }}
</a>
@else
<button
    {{ $attributes->merge([
        'type' => 'button',
        'class' => 'rounded-md ' . ($attributes->get('size') ? $attributes->get('size') : 'py-2 px-4') . ' text-gray-700 dark:text-gray-200 text-sm leading-5 font-medium hover:bg-cool-gray-100  dark:hover:bg-cool-gray-700 focus:outline-none focus:text-gray-800 dark:focus:text-gray-200 dark:focus:bg-cool-gray-700 focus:underline transition duration-150 ease-in-out' . ($attributes->get('disabled') ? ' opacity-75 cursor-not-allowed' : ''),
    ]) }}
>
    {{ $slot }}
</button>
@endif
