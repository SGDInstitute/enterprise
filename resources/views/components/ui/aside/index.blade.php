@props(['colspan' => 'lg:col-span-3'])

<aside class="px-2 py-6 sm:px-6 lg:py-0 lg:px-0 {{ $colspan }}">
    <nav class="space-y-1">
        {{ $slot }}
    </nav>
</aside>
