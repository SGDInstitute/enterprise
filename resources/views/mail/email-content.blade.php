@component('mail::message')
    {{ $content }}

    Thanks,
    <br />
    {{ config('app.name') }}
@endcomponent
