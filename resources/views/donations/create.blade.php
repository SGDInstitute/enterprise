@extends('layouts.video', ['title' => 'Donate Today'])

@section('content')
    <div class="flex w-full h-screen items-center justify-center">
        <div>
            <h1 class="text-center mb-8 text-white text-4xl">Donate to the Institute and our Programs</h1>
            <p class="text-center mb-8 text-white text-2xl">I want to...</p>

            <div class="container flex">
                <a href="/donations/create/institute" class="w-1/2 h-32 mx-4 bg-white rounded shadow flex items-center justify-center cursor-pointer p-4 hover:-mt-1 hover:bg-gray-200 hover:shadow-lg text-center text-xl leading-normal">
                    Setup a one-time or recurring donation now.
                </a>
                <a href="/donations/create/mblgtacc-2020" class="w-1/2 h-32 mx-4 bg-white rounded shadow flex items-center justify-center cursor-pointer p-4 hover:-mt-1 hover:bg-gray-200 hover:shadow-lg text-center text-xl leading-normal">
                    Purchase a sponsor package, vendor table, or program ad for MBLGTACC 2020.
                </a>
            </div>
        </div>
    </div>
@endsection