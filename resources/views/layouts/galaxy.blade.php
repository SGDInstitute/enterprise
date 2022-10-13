<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }} | {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=lato:400,400i,700,700i,900,900i|news-cycle:400,700|raleway:700" rel="stylesheet" />

    <!-- Privacy First Analytics -->
    <script src="https://station-to-station-famous.sgdinstitute.org/script.js" data-site="LVDVCGSU" defer></script>

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@1.2.3/dist/trix.css">
    <link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    @vite('resources/css/app.css')
    <livewire:styles />
    @stack('styles')

    <!-- Scripts -->
    <livewire:scripts />
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://unpkg.com/trix@1.2.3/dist/trix.js" defer></script>
    <script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

    @stack('scripts')
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-800">
    <livewire:notifications />

    <div class="flex h-screen overflow-hidden bg-gray-100 dark:bg-gray-900" x-data="{ sidebarOpen: false }" @keydown.window.escape="sidebarOpen = false">
        @include('layouts.galaxy.mobile')
        <!-- Static sidebar for desktop -->
        @include('layouts.galaxy.sidebar')

        <div class="flex flex-col flex-1 w-0 overflow-hidden">
            @include('layouts.galaxy.topbar')

            <main class="relative flex-1 overflow-y-auto focus:outline-none" tabindex="0" x-data="" x-init="$el.focus()">
                <div class="py-6">
                    <div class="flex items-center justify-between px-4 mx-auto space-x-1 max-w-7xl sm:px-6 md:px-8">
                        <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-200">{{ $title }}</h1>
                        @isset ($action)
                        <x-bit.button.round.primary wire:click="{{ $action['method'] }}">{{ $action['label'] }}</x-bit.button.round.primary>
                        @endif
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
