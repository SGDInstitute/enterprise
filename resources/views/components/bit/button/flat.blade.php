@props(['size' => 'default', 'block' => false, 'color' => 'text-indigo-600 border-indigo-600 hover:bg-indigo-600 hover:text-white'])

@php
$sizes = [
    'xs' => 'px-2.5 py-1.5 text-xs border-2',
    'sm' => 'px-3 py-2 text-sm border-2',
    'small' => 'px-3 py-2 text-sm border-2',
    'default' => 'px-4 py-2 text-base border-2',
    'regular' => 'px-4 py-2 text-base border-2',
    'lg' => 'px-4 py-2 text-lg border-4',
    'large' => 'px-4 py-2 text-lg border-4',
    'xl' => 'px-6 py-3 text-lg border-4',
];
$class = "inline-flex items-center uppercase font-bold {$sizes[$size]} {$color} focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500";

if($attributes->get('disabled')) {
    $class .= ' opacity-75 cursor-not-allowed';
}
if($block) {
    $class .= " w-full block text-center justify-center";
}
@endphp

@if($attributes->get('href'))
<a {{ $attributes->merge(['class' => $class]) }}>{{ $slot }}</a>
@else
<button {{ $attributes->merge(['type' => 'button', 'class' => $class]) }}>{{ $slot }}</button>
@endif
