@props(['size' => 'default', 'block' => false, 'color' => 'text-white bg-indigo-600 hover:bg-indigo-700'])

@php
$sizes = [
    'xs' => 'px-2.5 py-1.5 text-xs rounded',
    'sm' => 'px-3 py-2 text-sm rounded-md',
    'small' => 'px-3 py-2 text-sm rounded-md',
    'default' => 'px-4 py-2 text-sm rounded-md',
    'regular' => 'px-4 py-2 text-sm rounded-md',
    'lg' => 'px-4 py-2 text-base rounded-md',
    'large' => 'px-4 py-2 text-base rounded-md',
    'xl' => 'px-6 py-3 text-base rounded-md',
];
$class = "inline-flex items-center {$sizes[$size]} font-medium shadow-sm border border-transparent {$color} focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500";

if($attributes->get('disabled')) {
    $class .= ' opacity-75 cursor-not-allowed';
}
if($block) {
    $class .= " w-full block text-center justify-center";
}
@endphp

@if ($attributes->get('href'))
<a {{ $attributes->merge(['class' => $class]) }}>{{ $slot }}</a>
@else
<button {{ $attributes->merge(['type' => 'button', 'class' => $class]) }}>{{ $slot }}</button>
@endif
