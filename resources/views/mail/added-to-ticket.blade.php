@component('mail::message')
# Hello!

We wanted to let you know that {{ $causer }} added you to a ticket for {{ $event }}.

@if ($newUser)

We noticed you are a new user so we created an account for you. Click the link below to set your password and add your information (e.g. pronouns, accessibility requests) to the ticket.

@component('mail::button', ['url' => $resetUrl])
Password Reset
@endcomponent

@else

You can view your ticket and adjust your information (e.g., pronouns, accessibility requests) by logging into your account:

@component('mail::button', ['url' => $homeUrl])
Login
@endcomponent

Not quite sure what your password is? No worries! You can reset it by following the link below:

@component('mail::button', ['url' => $resetUrl])
Password Reset
@endcomponent

@endif

@endcomponent
