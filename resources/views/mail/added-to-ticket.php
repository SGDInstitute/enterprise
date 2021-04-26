@component('mail::message')
# Hello!

We wanted to let you know that {{ $causer }} added you to a ticket for {{ $ticket->order->event->name }}

@if($newUser)
Since you are a new user, we generated a password for you.
You can reset it by following the link below.

@component('mail::button', ['url' => route('password.request')])
Reset Password
@endcomponent

@else
You can view your ticket and adjust your information (i.e. pronouns, accessibility) by logging into your account:

@component('mail::button', ['url' => url('/home')])
Login
@endcomponent

Not quite sure what your password is? No worries! You can reset it by following the link below.

@component('mail::button', ['url' => route('password.request')])
Reset Password
@endcomponent

@endif
