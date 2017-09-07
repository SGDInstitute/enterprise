@extends('layouts.email')

@section('content')
<h1>Hi {{ $user->name }},</h1>
    <row>
        <columns class="btn-column">
            <button href="{{ $url }}" class="radius text-center">Login now!</button>
        </columns>
    </row>
@endsection