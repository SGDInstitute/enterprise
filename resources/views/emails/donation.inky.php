@extends('layouts.email')

@section('content')
<h1>{{ $donation->name }}</h1>

<p>
    Thank you for your generous donation of ${{ number_format($donation->amount/100, 2) }}
    on {{ $donation->created_at->toFormattedDateString() }}! No goods or services were provided in exchange for this
    contribution. The {{ config('institute.long_name') }} is an exempt organization as described in Section
    501(c)(3) of the Internal Revenue Code. EIN: {{ config('institute.ein') }}
</p>

<p>Your support means two important things.</p>

<p><strong>First</strong>, all of this work is possible. As a non-profit organization with an all-volunteer
    staff, all gifts to the Institute will go directly toward programming, resources, and operations that
    support students.</p>

<p><strong>Second</strong>, you are advancing our commitment to economic justice. We pledge to make our
    programs accessible to all students and young leaders regardless of their financial means. We'll limit costs
    for participation and materials, and make additional support available to those with limited access to
    resources. Your support turns this commitment into action.</p>

<button href="{{ $url }}" class="radius text-center">View Donation</button>
@endsection