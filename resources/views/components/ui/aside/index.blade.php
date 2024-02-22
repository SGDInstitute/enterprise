@props(['colspan' => 'lg:col-span-3'])

<aside class="{{ $colspan }} px-2 py-6 sm:px-6 lg:px-0 lg:py-0">
    <nav class="space-y-1">
        {{ $slot }}
    </nav>
</aside>
