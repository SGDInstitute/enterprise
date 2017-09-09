@extends('layouts.app')

@section('title', 'Orders')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                @include('orders.partials.information')
            </div>
            <div class="col">
                @include('flash::message')

                {{--@include('orders.partials.ticket_information')--}}

                <modal-button class="btn btn-primary pull-right btn-sm" event="showInviteUsers">
                    Invite users to fill out information
                </modal-button>

                <h2>{{ $order->event->ticket_string }} Details</h2>

                @include('orders.partials.tickets')
            </div>
        </div>

        <invite-users-form :order="{{ $order }}" :tickets="{{ $order->tickets->where('user_id', null) }}"></invite-users-form>
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