@props(['size' => 'default', 'block' => false, 'color' => 'border-indigo-600 text-indigo-600 hover:bg-indigo-600 hover:text-white'])

@php
    $sizes = [
        'xs' => 'border-2 px-2.5 py-1.5 text-xs',
        'sm' => 'border-2 px-3 py-2 text-sm',
        'small' => 'border-2 px-3 py-2 text-sm',
        'default' => 'border-2 px-4 py-2 text-base',
        'regular' => 'border-2 px-4 py-2 text-base',
        'lg' => 'border-4 px-4 py-2 text-lg',
        'large' => 'border-4 px-4 py-2 text-lg',
        'xl' => 'border-4 px-6 py-3 text-lg',
    ];
    $class = "inline-flex items-center uppercase font-bold {$sizes[$size]} {$color} focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500";

    if ($attributes->get('disabled')) {
        $class .= ' opacity-75 cursor-not-allowed';
    }
    if ($block) {
        $class .= ' w-full block text-center justify-center';
    }
@endphp

@if ($attributes->get('href'))
    <a {{ $attributes->merge(['class' => $class]) }}>{{ $slot }}</a>
@else
    <button {{ $attributes->merge(['type' => 'button', 'class' => $class]) }}>{{ $slot }}</button>
@endif
