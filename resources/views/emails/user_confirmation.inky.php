@extends('layouts.email')

@section('content')
<h1>Hi {{ $user->name }},</h1>
    <row>
        <columns class="btn-column">
            <button href="{{ $url }}" class="radius text-center">Confirm this is your email!</button>
        </columns>
    </row>
@endsection