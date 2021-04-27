<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&amp;family=News+Cycle:wght@400;700&amp;family=Raleway:wght@700&amp;display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <livewire:styles />


    </head>
    <body class="font-sans antialiased dark:bg-gray-800">
        @include('layouts.app.nav')
        <livewire:notifications />

        <main>
            {{ $slot }}
        </main>

        @include('layouts.app.footer')

        <!-- Scripts -->
        <livewire:scripts />
        <script src="https://js.stripe.com/v3/"></script>
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    </body>
</html>
