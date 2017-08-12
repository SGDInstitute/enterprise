@extends('layouts.app')

@section('title', $event->title)

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <p>{{ $event->title }}</p>
                <p>{{ $event->subtitle }}</p>
                <p>{{ $event->formatted_start }}</p>
                <p>{{ $event->formatted_end }}</p>
                <p>{{ $event->place }}</p>
                <p>{{ $event->location }}</p>
                <p>{{ $event->duration }}</p>
                @if($event->links)
                    @foreach($event->links as $icon => $link)
                        <a href="{{ $link }}" target="_blank"><i class="fa fa-{{ $icon  }}" aria-label="{{ $icon }}"></i></a>
                    @endforeach
                @endif
            </div>
            <div class="col-md-4">
                @foreach($event->ticket_types as $ticket)
                    <p>${{ number_format($ticket->cost/100, 2) }}</p>
                    <p>{{ $ticket->name }}</p>
                    @if($ticket->description)
                        <p>{{ $ticket->description }}</p>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection
