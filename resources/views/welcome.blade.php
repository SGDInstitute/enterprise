@extends('layouts.app')

@section('title', 'Events')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="text-center mb-8">Upcoming Events</h2>

                <div class="row mb-8">
                    @foreach($upcomingEvents as $upcoming)
                        <div class="col-md-6">
                            @include("components.app.event", ['event' => $upcoming])
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
