@extends('layouts.email')

@section('content')
<h2>Hi!</h2>

<p>{{ $coordinator->name }} invited you to {{ $ticket->order->event->title }}!</p>

@if($note)
<p>They said to pass this along:</p>

<p>{{ $note }}</p>
@endif

<a href="{{ $url }}">Set Your Account Password</a>
@endsection