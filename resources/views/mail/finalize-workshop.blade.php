@component('mail::message')
    Hi there, We're excited to have you present your workshop, "{{ $title }}," at {{ $event }}. We're currently
    finalizing the workshop schedule and content for the printed program. Please take a moment to confirm a few details
    about your session. The language you submit on this form will be the exact language we include in the printed
    program. This is also your chance to update who is presenting your session. As soon as you submit this form, you and
    any other presenters will be automatically registered to attend {{ $event }}. *This information is due by
    {{ $ends }}.*

    @component('mail::button', ['url' => $url])
        Submit Form
    @endcomponent

    Please [contact us](mailto:hello@sgdinstitute.org) if you have any questions. Thank you, {{ $event }} planning team
    and the Midwest Institute for Sexuality and Gender Diversity
@endcomponent
