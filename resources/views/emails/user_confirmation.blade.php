@component('mail::message')

Hi {{ $user->name }},

@component('mail::button', ['url' => $url])
    Confirm this is your email!
@endcomponent

@endcomponent