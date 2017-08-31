@extends('layouts.app')

@section('title', 'Events')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="text-center">Upcoming Events</h2>

                <div class="row">
                    @foreach($upcomingEvents as $upcoming)
                        @include("components.app.event", ['event' => $upcoming])
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
