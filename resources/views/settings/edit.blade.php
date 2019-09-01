@extends('layouts.app', ['title' => 'Settings'])

@section('content')
<main role="main" class="mt-40">
    <div class="bg-mint-500 h-1/3 absolute top-0 w-full -z-1 overflow-hidden" style="background: #38AFAD; background: -webkit-linear-gradient(to left, #1a7796, #38AFAD); background: linear-gradient(to left, #1a7796, #38AFAD);">
    </div>
    <div class="container mb-16">
        @include('home.partials.settings')
    </div>
</main>
@endsection