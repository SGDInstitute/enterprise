<x-app-layout title="Unauthorized">
    <x-http-error code="401" title="Unauthorized">
        <p>
            You are not authorized to access this resource. Please
            <a href="/login" class="font-bold text-green-500 underline dark:text-green-400">Login</a>
            or
            <a href="/register" class="font-bold text-green-500 underline dark:text-green-400">Create an Account</a>
            to continue.
        </p>
    </x-http-error>
</x-app-layout>
