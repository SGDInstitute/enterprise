@extends('layouts.app', ['hide_nav' => true])

@section('content')

    <div class="max-w-lg mx-auto">
        @if(now() < $form->start)
            <h1 class="text-center">Sorry this form isn't open yet, check back later. 😟</h1>
        @elseif(now() > $form->end)
            <h1 class="text-center">Sorry this form is closed. 😟</h1>
        @else
            <dynamic-form :form="{{ $form }}"></dynamic-form>
        @endif
    </div>

@endsection
