<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title') | Midwest Institute for Sexuality and Gender Diversity</title>
    <meta name="description" content="event.discription">
    <meta name="title" content="event.name">
    <meta name="author" content="MBLGTACC 2018, Midwest Institute for Sexuality and Gender Diversity">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

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

    <script>
        window.Spark = {}
    </script>
</head>
<body>
<div id="app">
    @include('layouts.partials.app.header')

    @yield('hero')

    <section class="content">
        @yield('content')
    </section>

    @include('layouts.partials.app.footer')

    <login-or-register v-on:></login-or-register>
</div>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
@yield('scripts')

</body>
</html>
