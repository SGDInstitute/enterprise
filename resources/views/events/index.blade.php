@extends('layouts.app')

@section('title', $event->title)

@section('content')
    <div class="container">
        <div class="row">
            <p>{{ $event->title }}</p>
            <p>{{ $event->subtitle }}</p>
            <p>{{ $event->formatted_start }}</p>
            <p>{{ $event->formatted_end }}</p>
            <p>{{ $event->place }}</p>
            <p>{{ $event->location }}</p>
            <p>{{ $event->duration }}</p>
            @foreach($event->links as $icon => $link)
                <a href="{{ $link }}" target="_blank"><i class="fa fa-{{ $icon  }}" aria-label="{{ $icon }}"></i></a>
            @endforeach
        </div>
    </div>
@endsection
