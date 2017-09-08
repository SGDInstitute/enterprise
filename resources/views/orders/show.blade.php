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

                @foreach($order->tickets as $ticket)
                    <div class="card mb-2">
                        <div class="card-body">
                            <p class="card-text">{{ $ticket->ticket_type->name }}</p>

                            @if(is_null($ticket->user_id))
                                @if(! $order->tickets->pluck('user_id')->contains(Auth::user()->id))
                                    <a href="#" class="card-link">Add my information</a>
                                @endif
                                <modal-button class="card-link" event="showManualUserModal">
                                    Manually add information
                                </modal-button>
                                <modal-button class="card-link" event="showInviteUsers">
                                    Invite users to fill out information
                                </modal-button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <invite-users-form :tickets="{{ $order->tickets->where('user_id', null) }}"></invite-users-form>
        <invoice-form :order="{{ $order }}" :user="{{ Auth::user() }}"></invoice-form>
        <manual-user-modal></manual-user-modal>
        <view-invoice-modal :order="{{ $order }}"></view-invoice-modal>
        <view-receipt-modal :order="{{ $order }}"></view-receipt-modal>
    </div>
@endsection

@section('beforeScripts')
    <script src="https://checkout.stripe.com/checkout.js"></script>
@endsection