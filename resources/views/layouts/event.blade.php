<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>event.name</title>
        <meta name="description" content="event.discription">
        <meta name="title" content="event.name">
        <meta name="author" content="MBLGTACC 2018, Midwest Institute for Sexuality and Gender Diversity">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicons/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicons/favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('favicons/manifest.json') }}">
        <link rel="mask-icon" color="#5bbad5" href="{{ asset('favicons/safari-pinned-tab.svg') }}">
        <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}">
        <meta name="msapplication-config" content="{{ asset('favicons/browserconfig.xml') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        @yield('styles')
    </head>
    <body>

        @include('components.header')

        @section('content')

        @include('components.footer')

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>
        @yield('scripts')

    </body>
</html>
