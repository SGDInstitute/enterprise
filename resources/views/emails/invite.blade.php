@section('header-title')
    @if(isset($ticket->order->event->logo_dark))
    <img src="{{ $ticket->order->event->logo_dark }}" alt="{{ $ticket->order->event->title }} Logo"
    style="width: 50%; float: right;">
    @else
    <p class="text-right">{{ $ticket->order->event->title }}</p>
    @endif
@endsection

@component('mail::message')

Hello!

{{ $coordinator->name }} invited you to {{ $ticket->order->event->title }}!

They said to pass this along:

{{ $note }}

Click below to submit your personal information so you can receive your personalized name tag and a t-shirt at the
conference!

@component('mail::button', ['url' => $url])
Set Your Account Password
@endcomponent

Looking forward to seeing you,<br>
The {{ $ticket->order->event->title }} Team
@endcomponent