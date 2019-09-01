@extends('layouts.app', ['title' => 'View Donation'])

@section('content')
<main role="main" class="mt-40">
    <div class="bg-mint-500 h-80 absolute top-0 w-full -z-1 overflow-hidden" style="background: #38AFAD; background: -webkit-linear-gradient(to left, #1a7796, #38AFAD); background: linear-gradient(to left, #1a7796, #38AFAD);">
    </div>
    <div class="w-1/2 mx-auto mb-16">
        <a href="/home" class="text-white py-2 block"><i class="fa fa-chevron-left"></i> Back Home</a>

        <div class="p-6 rounded bg-white shadow mb-4">
            <h2 class="text-2xl mb-4 text-gray-700">Contact Information</h2>
            @include('donations.partials.contact')
        </div>
        @if($charge)
        <div class="p-6 rounded bg-white shadow mb-4">
            <h2 class="text-2xl mb-4 text-gray-700">Transaction</h2>
            @include('donations.partials.transaction')
        </div>
        @endif

        @if($subscription)
        <div class="p-6 rounded bg-white shadow">
            <h2 class="text-2xl mb-4 text-gray-700">Recurring Donation</h2>
            @include('donations.partials.subscription')
        </div>
        @endif

        @if($donation->contributions->count() > 0)
        <div class="p-6 rounded bg-white shadow">
            <h2 class="text-2xl mb-4 text-gray-700">Contributions</h2>
            @include('donations.partials.contributions')
        </div>
        @endif
    </div>
</main>
@endsection