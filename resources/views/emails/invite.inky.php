@extends('layouts.email')

@section('header')
<div class="text-right">
    @if(isset($ticket->order->event->logo_dark))
    <img src="{{ $ticket->order->event->logo_dark }}" alt="{{ $ticket->order->event->title }} Logo"
         style="width: 50%; float: right;">
    @else
    <h4 class="card-title">{{ $ticket->order->event->title }}</h4>
    @endif
</div>
@endsection

@section('content')
<h2>Hi!</h2>

<p>{{ $coordinator->name }} invited you to {{ $ticket->order->event->title }}!</p>

@if($note !== null)
<p>They said to pass this along:</p>

<callout class="primary">
    <p>{{ $note }}</p>
</callout>
@endif

<p>Click below to submit your personal information so you can receive your personalized name tag and a t-shirt at the conference!</p>

<button href="{{ $url }}" class="radius text-center">Set Your Account Password</button>

<p>Looking forward to seeing you,
    <br>
    The {{ $ticket->order->event->title }} Team
@endsection