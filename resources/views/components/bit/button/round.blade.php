@props(['size' => 'default', 'block' => false, 'color' => 'bg-indigo-600 text-white hover:bg-indigo-700'])

@php
    $sizes = [
        'xs' => 'rounded px-2.5 py-1.5 text-xs',
        'sm' => 'rounded-md px-3 py-2 text-sm',
        'small' => 'rounded-md px-3 py-2 text-sm',
        'default' => 'rounded-md px-4 py-2 text-sm',
        'regular' => 'rounded-md px-4 py-2 text-sm',
        'lg' => 'rounded-md px-4 py-2 text-base',
        'large' => 'rounded-md px-4 py-2 text-base',
        'xl' => 'rounded-md px-6 py-3 text-base',
    ];
    $class = "inline-flex items-center {$sizes[$size]} font-medium shadow-sm border border-transparent {$color} focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500";

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
