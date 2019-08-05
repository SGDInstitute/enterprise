@extends('layouts.app', ['title' => 'Orders'])

@section('content')
    <div class="container">
        @if(Auth::user()->can('update', $order))
        <div class="flex border rounded mb-8">
            <div class="flex-1 p-4 flex items-center border-r">
                <span class="fa-stack mr-4">
                    <i class="fas fa-circle fa-stack-2x text-mint"></i>
                    <i class="fas fa-check fa-stack-1x fa-inverse"></i>
                </span>
                <span>Create Order</span>
            </div>
            <div class="flex-1 p-4 flex items-center justify-between border-r">
                <div class="flex items-center">
                    <span class="fa-stack mr-4">
                        <i class="fas fa-circle fa-stack-2x {{ $order->isPaid() ? 'text-mint' : 'text-grey' }}"></i>
                        @if($order->isPaid())
                            <i class="fas fa-check fa-stack-1x fa-inverse"></i>
                        @endif
                    </span>
                    <span>Pay Now</span>
                </div>
                <pay-tour></pay-tour>
            </div>
            <div class="flex-1 p-4 flex items-center justify-between border-r">
                <div class="flex items-center">
                    <span class="fa-stack mr-4">
                        <i class="fas fa-circle fa-stack-2x {{ $order->tickets()->filled()->count() === $order->tickets->count() ? 'text-mint' : 'text-grey' }}"></i>
                        @if($order->tickets()->filled()->count() === $order->tickets->count())
                            <i class="fas fa-check fa-stack-1x fa-inverse"></i>
                        @endif
                    </span>
                    <span>Tell Us Who's Coming</span>
                </div>
                <invite-tour></invite-tour>
            </div>
            <div class="flex-1 p-4 flex items-center justify-between">
                <div class="flex items-center">
                    <span class="fa-stack mr-4">
                        <i class="fas fa-circle fa-stack-2x text-grey"></i>
                    </span>
                    <span>Get Ready to Come!</span>
                </div>
                <a href="https://mblgtacc.org/2019/lodging-transportation" target="_blank" class="text-grey">
                    <i class="fa fa-info"></i>
                </a>
            </div>
        </div>
        @endif

        <div class="row">
            <div class="col-md-4">
                @include('orders.partials.information')
            </div>
            <div class="col">
                @include('flash::message')

                @if(Auth::user()->can('update', $order))
                    <modal-button class="btn btn-primary float-right btn-sm" event="showInviteUsers">
                        Invite users to fill out information
                    </modal-button>
                @endif

                <h2>{{ $order->event->ticket_string }} Details</h2>

                @include('orders.partials.tickets')
            </div>
        </div>

        <invite-users-form :order="{{ $order }}"
                           :tickets="{{ $order->tickets->where('user_id', null) }}"></invite-users-form>
        <invoice-form :order="{{ $order }}" :user="{{ Auth::user() }}"></invoice-form>
        <manual-user-modal></manual-user-modal>
        @if($order->invoice !== null)
            <view-invoice-modal :order="{{ $order }}"></view-invoice-modal>
        @endif
        <view-receipt-modal :order="{{ $order }}"></view-receipt-modal>
        <view-profile-modal :tickets="{{ $order->tickets }}"></view-profile-modal>
    </div>
@endsection

@section('beforeScripts')
    <script src="https://checkout.stripe.com/checkout.js"></script>
@endsection