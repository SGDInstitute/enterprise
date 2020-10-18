@extends('layouts.app', ['title' => 'Donate Today'])

@section('content')
<main role="main" class="mt-40">
    <div class="absolute top-0 w-full overflow-hidden hue bg-mint-500 h-80 -z-1" style="background: #38AFAD; background: -webkit-linear-gradient(to left, #1a7796, #38AFAD); background: linear-gradient(to left, #1a7796, #38AFAD);">
    </div>
    <div class="container mt-12 mb-16">
        @include('flash::message')


        <div class="md:flex md:-mx-4">
            <div class="mx-4 mx-auto md:w-7/12">
                <h1 class="mb-4 text-3xl font-semibold text-white">Support the Institute Today</h1>
                <div class="p-6 bg-white rounded shadow">
                    <donation-form :user="{{ Auth::user() === null ? json_encode(null) : Auth::user() }}" group="institute"></donation-form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
