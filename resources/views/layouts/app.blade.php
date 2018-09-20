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
<body>
<div id="app">
    @include('layouts.partials.app.header')

    @yield('hero')

    <section class="content">
        @if(Auth::user() && !Auth::user()->isConfirmed())
            <div class="container">
                <div class="alert alert-danger">
                    Please confirm your email. Didn't get the confirmation email? <a href="/register/email">Lets try again!</a>
                </div>
            </div>
        @endif

        @yield('content')
    </section>

    @include('layouts.partials.app.footer')

    <login-or-register v-on:></login-or-register>
</div>
<!-- Scripts -->
@yield('beforeScripts')
<script src="{{ mix('js/app.js') }}"></script>
@yield('scripts')

</body>
</html>
