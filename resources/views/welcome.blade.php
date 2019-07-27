@extends('layouts.video', ['title' => 'Events'])

@section('content')
    <div class="flex h-screen items-center justify-center">
        <div>
            <h1 class="text-center mb-8 text-white text-4xl">Upcoming Events</h1>

            @foreach($upcomingEvents as $upcoming)
                @include("components.app.event", ['event' => $upcoming])
            @endforeach
        </div>
    </div>
@endsection
