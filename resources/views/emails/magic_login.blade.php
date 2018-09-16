@component('mail::message')

Hi {{ $user->name }},

@component('mail::button', ['url' => $url])
    Login Now!
@endcomponent

@endcomponent