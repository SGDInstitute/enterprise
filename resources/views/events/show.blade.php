@extends('layouts.app')

@section('title', $event->title)

@section('hero')
    <section class="hero">
        <div class="container">
            <div class="hero-titles">
                <h1 class="display-3">{{ $event->title }}</h1>
                <h2>{{ $event->subtitle }}</h2>
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
            <div class="col-md-8">
                <h3 class="description-title">Event Description</h3>
                <ul class="fa-ul">
                    <li><i class="fa-li fa fa-clock-o" aria-hidden="true"></i>{{ $event->duration }}</li>
                    <li><i class="fa-li fa fa-map-marker"
                           aria-hidden="true"></i>{{ $event->place }} {{ $event->location }}</li>
                </ul>
                @if($event->description)
                    <div class="description-content">
                        {{ $event->description }}
                    </div>
                @endif

                @component('components.app.links', ['links' => $event->links])
                @endcomponent
            </div>
            <div class="col-md-4">
                <div class="tickets card-list rounded mt-sm-4 mt-xs-4">
                    <start-order :ticket_types="{{ $event->ticket_types }}" :event="{{ $event }}" :user="{{ json_encode(Auth::user()) }}"></start-order>
                </div>
            </div>
        </div>
    </div>
@endsection
