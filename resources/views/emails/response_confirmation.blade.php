@section('header-title')
    @if(isset($response->form->event->logo_dark))
        <img src="{{ $response->form->event->logo_dark }}" alt="{{ $response->form->event->title }} Logo"
             style="width: 50%; float: right;">
    @else
        <h4 class="card-title">{{ $response->form->event->title }}</h4>
    @endif
@endsection

@component('mail::message')
Hi!

Thank you for filling out {{ $response->form->name }}. Your responses are attached to this email for your records.

@if($response->form->event->end->lt(now()))
Thank you for coming,
@else
Looking forward to seeing you,
@endif
The {{ $response->form->event->title }} Team

@endcomponent