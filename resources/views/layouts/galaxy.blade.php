<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }} | {{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-800">
    <div class="flex h-screen overflow-hidden bg-gray-100 dark:bg-gray-800" x-data="{ sidebarOpen: false }" @keydown.window.escape="sidebarOpen = false">
        @include('layouts.galaxy.mobile')
        <!-- Static sidebar for desktop -->
        @include('layouts.galaxy.sidebar')

        <div class="flex flex-col flex-1 w-0 overflow-hidden">
            @include('layouts.galaxy.topbar')

            <main class="relative flex-1 overflow-y-auto focus:outline-none" tabindex="0" x-data="" x-init="$el.focus()">
                <div class="py-6">
                    <div class="px-4 mx-auto max-w-7xl sm:px-6 md:px-8">
                        <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-200">{{ $title }}</h1>
                    </div>
                    <div class="px-4 mx-auto mt-8 max-w-7xl sm:px-6 md:px-8">
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>
    </div>

</body>

</html>
