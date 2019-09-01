@extends('layouts.app', ['title' => 'Orders'])

@section('content')
<main role="main" class="pt-32">
    <div class="bg-mint-500 h-80 absolute top-0 w-full -z-1 overflow-hidden" style="background: #38AFAD; background: -webkit-linear-gradient(to left, #1a7796, #38AFAD); background: linear-gradient(to left, #1a7796, #38AFAD);">
    </div>

    <div class="px-4 md:px-0 container mx-auto bg-transparent">
        @include('orders.partials.wizard')

        <div class="md:flex -mx-4 mb-16">
            <div class="md:w-1/3 md:mx-4">
                @include('orders.partials.information')
            </div>
            <div class="md:w-2/3 md:mx-4">
                @include('flash::message')

                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-4xl text-white">{{ $order->event->ticket_string }} Details</h2>

                    @if(Auth::user()->can('update', $order))
                    <modal-button class="btn btn-gray btn-sm" event="showInviteUsers">
                        Invite users to fill out information
                    </modal-button>
                    @endif
                </div>

                @include('orders.partials.tickets')
            </div>
        </div>

        <!-- <invite-users-form :order="{{ $order }}" :tickets="{{ $order->tickets->where('user_id', null) }}"></invite-users-form>
        <invoice-form :order="{{ $order }}" :user="{{ Auth::user() }}"></invoice-form>
        <manual-user-modal></manual-user-modal>
        @if($order->invoice !== null)
        <view-invoice-modal :order="{{ $order }}"></view-invoice-modal>
        @endif
        <view-receipt-modal :order="{{ $order }}"></view-receipt-modal>
        <view-profile-modal :tickets="{{ $order->tickets }}"></view-profile-modal> -->
    </div>
</main>
@endsection

@section('beforeScripts')
<script src="https://checkout.stripe.com/checkout.js"></script>
@endsection