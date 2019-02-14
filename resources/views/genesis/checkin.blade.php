<!DOCTYPE html>
<html>
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
    <link href="{{ mix('css/checkin.css') }}" rel="stylesheet">

    <script>
        window.SGDInstitute = @json([
            'mblgtaccStripe' => getStripeKey('mblgtacc'),
            'instituteStripe' => getStripeKey('institute'),
        ]);
    </script>
</head>
<body>
<div id="app">
    <app></app>
</div>
</body>

<script src="https://checkout.stripe.com/checkout.js"></script>
<script src="{{ mix('js/checkin.js') }}"></script>
</html>
