@extends('layouts.app', ['title' => $event->title])

@section('hero')
    <section class="hero" style="background-image: linear-gradient(rgba(0, 0, 0, 0.55),rgba(0, 0, 0, 0.55)), url({{ $event->image }})">
        <div class="container">
            <div class="hero-titles">
                @if(isset($event->logo_light))
                    <img src="{{ Storage::url($event->logo_light) }}" alt="{{ $event->title }} Logo" style="min-width: 250px; width: 50%;">
                @else
                    <h1 class="display-3">{{ $event->title }}</h1>
                @endif
                <h2>{{ ucfirst($policy) }} Policy</h2>
            </div>
        </div>
        <div class="hero-bar clearfix">
            <div class="container">
                <div class="pull-left">
                    {{ $event->formatted_start }}
                    <br/>
                    {{ $event->formatted_end }}
                </div>
                <div class="pull-right text-right">
                    {{ $event->place }}<br/>{{ $event->location }}
                </div>
            </div>
        </div>
    </section>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-6 mx-auto text-center">
                <h2>{{ ucfirst($policy) }} Policy</h2>

                {!! $event->$attribute !!}
            </div>
        </div>
    </div>
@endsection
