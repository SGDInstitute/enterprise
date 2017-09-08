@extends('layouts.email')

@section('content')
<h2>Hi!</h2>

{{ $coordinator->name }} invited you to [event]!

<a href="{{ $url }}">Set Your Account Password</a>
@endsection