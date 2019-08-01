@extends('layouts.app', ['title' => 'Donate Today'])

@section('content')
    <main role="main" class="mt-40">
        <div class="bg-mint-500 h-80 absolute top-0 w-full -z-1 overflow-hidden"
             style="background: #38AFAD; background: -webkit-linear-gradient(to left, #1a7796, #38AFAD); background: linear-gradient(to left, #1a7796, #38AFAD);">
        </div>
        <div class="mt-12 container">
            @include('flash::message')

            <h1 class="text-white text-3xl font-semibold mb-4">Support {{ $event->title }} Today</h1>

            <div class="md:flex md:-mx-4">
                <div class="md:w-7/12 mx-4">
                    <div class="p-6 bg-white rounded shadow">

                    </div>
                </div>
                <div class="md:w-5/12 mx-4">
                    <div class="p-6 bg-white rounded shadow">

                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('beforeScripts')
    <script src="https://checkout.stripe.com/checkout.js"></script>
@endsection