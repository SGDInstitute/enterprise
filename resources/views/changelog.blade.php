@extends('layouts.app', ['title' => 'Project Enterprise Changelog'])

@section('content')
<main role="main" class="mt-40">
    <div class="bg-mint-500 h-1/3 absolute top-0 w-full -z-1 overflow-hidden" style="background: #38AFAD; background: -webkit-linear-gradient(to left, #1a7796, #38AFAD); background: linear-gradient(to left, #1a7796, #38AFAD);">
    </div>

    <div class="px-4 md:px-0 lg:w-3/5 container mx-auto bg-transparent">
        <div class="my-16 w-full relative shadow bg-white rounded-lg overflow-hidden p-6 markdown">
            {!! $content !!}
        </div>
    </div>
</main>
@endsection