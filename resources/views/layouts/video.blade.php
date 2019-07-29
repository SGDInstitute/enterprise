<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ $title }} | Midwest Institute for Sexuality and Gender Diversity</title>
    <meta name="description" content="event.discription">
    <meta name="title" content="event.name">
    <meta name="author" content="MBLGTACC, Midwest Institute for Sexuality and Gender Diversity">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('favicons/favicon-32x32.png') }}" sizes="32x32">
    <link rel="icon" type="image/png" href="{{ asset('favicons/favicon-16x16.png') }}" sizes="16x16">
    <link rel="manifest" href="{{ asset('favicons/manifest.json') }}">
    <link rel="mask-icon" href="{{ asset('favicons/manifest.json') }}" color="#38afad">
    <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}">
    <meta name="msapplication-config" content="{{ asset('favicons/browserconfig.xml') }}">
    <meta name="theme-color" content="#ffffff">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @yield('styles')

    <script defer src="https://pro.fontawesome.com/releases/v5.3.1/js/all.js"
            integrity="sha384-eAVkiER0fL/ySiqS7dXu8TLpoR8d9KRzIYtG0Tz7pi24qgQIIupp0fn2XA1H90fP"
            crossorigin="anonymous"></script>

    <script>
        window.Spark = {};

        window.SGDInstitute = @json([
            'mblgtaccStripe' => getStripeKey('mblgtacc'),
            'instituteStripe' => getStripeKey('institute'),
            'user' => Auth::user()
        ]);
    </script>
</head>
<body class="bg-mint-800">
<div id="app">
    <div class="top-0 fixed py-8 px-16 md:flex md:justify-between w-full">
        <a href="https://sgdinstitute.org/"><img src="{{ asset('images/sgdinstitute-logo-white.png') }}" alt="Logo White" class="w-40 mb-8 mx-auto md:mb-0 block"></a>
        <div class="text-center">
            <a class="text-gray-200 hover:text-white hover:underline mr-4" href="/donations/create">Donate</a>
            <a class="text-gray-200 hover:text-white hover:underline mr-4" href="/login">Login</a>
            <a class="text-gray-200 hover:text-white hover:underline" href="/register">Create an Account</a>
        </div>
    </div>
    <div class="fullscreen-video">
        <div class="overlay"></div>
        <video autoplay loop muted id="backgroundVideo">
            <source src="{{ asset('video/background.mp4') }}" type="video/mp4">
        </video>
    </div>

    @yield('content')

</div>

<script src="{{ mix('js/app.js') }}"></script>

</body>
</html>
