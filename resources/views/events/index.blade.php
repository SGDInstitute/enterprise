@extends('layouts.app')

@section('title', $event->title)

@section('content')
    <div class="container">
        <div class="row">
            <p>{{ $event->subtitle }}</p>
            <p>{{ $event->start->format('D, M j') }}</p>
            <p>{{ $event->end->format('D, M j') }}</p>
            <p>{{ $event->place }}</p>
            <p>{{ $event->location }}</p>
            <p>{{ $event->start->timezone($event->timezone)->format('l F j, Y g:i A') }} to {{ $event->end->timezone($event->timezone)->format('l F j, Y g:i A T') }}</p>
            @foreach($event->links as $icon => $link)
                <a href="{{ $link }}" target="_blank"><i class="fa fa-{{ $icon  }}" aria-label="{{ $icon }}"></i></a>
            @endforeach
        </div>
    </div>
@endsection
