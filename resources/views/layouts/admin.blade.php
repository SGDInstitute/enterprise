<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('favicons/favicon-32x32.png') }}" sizes="32x32">
    <link rel="icon" type="image/png" href="{{ asset('favicons/favicon-16x16.png') }}" sizes="16x16">
    <link rel="manifest" href="{{ asset('favicons/manifest.json') }}">
    <link rel="mask-icon" href="{{ asset('favicons/manifest.json') }}" color="#38afad">
    <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}">
    <meta name="msapplication-config" content="{{ asset('favicons/browserconfig.xml') }}">
    <meta name="theme-color" content="#ffffff">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/admin.css') }}" rel="stylesheet">

    <script>
        window.Spark = {};

        window.SGDInstitute = {
            mblgtaccStripe: "{{ getStripeKey('mblgtacc') }}",
            instituteStripe: "{{ getStripeKey('institute') }}"
        };
    </script>
</head>
<body>
    <div id="wrapper">

        @include("layouts.partials.admin.nav")

        <div id="page-wrapper" class="gray-bg">
            @include("layouts.partials.admin.topnav")

            @yield('header')

            <div class="wrapper wrapper-content">
                @include('flash::message')

                @yield("content")
            </div>
            @include("layouts.partials.admin.footer")

        </div>
    </div>

    <script src="{{ mix('js/admin.js') }}"></script>

</body>
</html>
