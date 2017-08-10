<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>
<body>
    <div id="wrapper app">

        @include("layouts.partials.admin.nav")

        <div id="page-wrapper" class="gray-bg">
            @include("layouts.partials.admin.topnav")
            <div class="wrapper wrapper-content">
                @yield("content")
            </div>
            @include("layouts.partials.admin.footer")

        </div>
    </div>

    <script src="{{ asset('js/admin.js') }}"></script>

</body>
</html>
