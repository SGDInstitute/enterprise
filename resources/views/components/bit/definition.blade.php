@props(['borderless'])

<dl class="{{ isset($borderless) ? '' : 'divide-y divide-gray-200 dark:divide-gray-600' }}">
    {{ $slot }}
</dl>
