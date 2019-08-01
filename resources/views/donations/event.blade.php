@extends('layouts.app', ['title' => 'Donate Today'])

@section('content')
    <main role="main" class="mt-40">
        <div class="bg-mint-500 h-80 absolute top-0 w-full -z-1 overflow-hidden"
             style="background: #38AFAD; background: -webkit-linear-gradient(to left, #1a7796, #38AFAD); background: linear-gradient(to left, #1a7796, #38AFAD);">
        </div>
        <div class="mt-12 container">
            @include('flash::message')

            <h1 class="text-white text-3xl font-semibold mb-4">Support the MBLGTACC 2020 Today</h1>

            <div class="md:flex md:-mx-4">
                <div class="md:w-7/12 mx-4">
                    <div class="p-6 bg-white rounded shadow">
                        <donation-form :user="{{ Auth::user() === null ? json_encode(null) : Auth::user() }}"></donation-form>
                    </div>
                </div>
                <div class="md:w-5/12 mx-4">
                    <div class="p-6 bg-white rounded shadow">
                        <p class="leading-normal mb-4">For twenty-five years, MBLGTACC has brought together students from around the United States for a
                            few days each year to learn and grow through the knowledge and experiences of others. We are
                            dedicated to ensuring that the history of the conference carries forward to touch countless
                            lives in the next quarter century.</p>
                        <p class="leading-normal mb-4">And we will do more. For the first time, this student movement to build queer success in the
                            Midwest is taking the principles of MBLGTACC beyond the three-day event.</p>
                        <p class="leading-normal mb-4">Your support will mean two important things.</p>
                        <p class="leading-normal mb-4"><strong>First</strong>, all of this work will be possible. As a non-profit organization with an
                            all-volunteer staff, all gifts to the Institute will go directly toward programming, resources,
                            and operations that support students.</p>
                        <p class="leading-normal"><strong>Second</strong>, you’ll be advancing our commitment to economic justice. We pledge to
                            make our programs accessible to all students and young leaders regardless of their financial
                            means. We'll limit costs for participation and materials, and make additional support available
                            to those with limited access to resources. Your support turns this commitment into action.
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('beforeScripts')
    <script src="https://checkout.stripe.com/checkout.js"></script>
@endsection