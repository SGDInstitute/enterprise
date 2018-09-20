@extends('layouts.app')

@section('title', 'View Donation')

@section('content')
    <div class="container">
        @include('flash::message')

        <div class="mx-auto w-2/3">
            <h2 class="text-lg text-grey-darker">Contact Information</h2>
            @include('donations.partials.contact')

            @if(isset($charge))
                <h2 class="text-lg text-grey-darker">Transaction</h2>
                @include('donations.partials.transaction')
            @else
                <h2 class="text-lg text-grey-darker">Recurring Donation</h2>
                @include('donations.partials.subscription')
            @endif
        </div>
    </div>
@endsection

@section('beforeScripts')
    <script src="https://checkout.stripe.com/checkout.js"></script>
@endsection