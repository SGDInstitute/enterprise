@component('mail::message')
# {{ $donation->name }}

Thank you for your generous donation of ${{ number_format($donation->amount/100, 2) }}
on {{ $donation->created_at->toFormattedDateString() }}! No goods or services were provided in exchange for this
contribution. The {{ config('institute.long_name') }} is an exempt organization as described in Section
501(c)(3) of the Internal Revenue Code. EIN: {{ config('institute.ein') }}

Your support means two important things.

**First**, all of this work is possible. As a non-profit organization with an all-volunteer
staff, all gifts to the Institute will go directly toward programming, resources, and operations that
support students.

**Second**, you are advancing our commitment to economic justice. We pledge to make our
programs accessible to all students and young leaders regardless of their financial means. We'll limit costs
for participation and materials, and make additional support available to those with limited access to
resources. Your support turns this commitment into action.

@component('mail::button', ['url' => $url])
    View Donation
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent