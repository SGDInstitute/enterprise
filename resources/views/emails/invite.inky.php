@extends('layouts.email')

@section('content')
<h2>Hi!</h2>

{{ $coordinator->name }} invited you to {{ $ticket->order->event->title }}!

<a href="{{ $url }}">Set Your Account Password</a>
@endsection