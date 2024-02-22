<x-app-layout title="Forbidden">
    <x-http-error code="403" title="Forbidden">
        <p>{{ $exception->getMessage() ?: 'Forbidden' }}</p>
    </x-http-error>
</x-app-layout>
