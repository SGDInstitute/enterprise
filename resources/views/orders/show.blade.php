@extends('layouts.app', ['title' => 'Orders'])

@section('content')
<main role="main" class="pt-32">
    <div class="bg-mint-500 h-80 absolute top-0 w-full -z-1 overflow-hidden" style="background: #38AFAD; background: -webkit-linear-gradient(to left, #1a7796, #38AFAD); background: linear-gradient(to left, #1a7796, #38AFAD);">
    </div>

    <div class="px-4 md:px-0 container mx-auto bg-transparent">
        @include('orders.partials.wizard')

        <div class="lg:flex lg:-mx-4 mb-16">
            <div class="lg:w-1/2 lg:w-1/3 lg:mx-4">
                @include('orders.partials.information')
            </div>
            <div class="lg:w-2/3 lg:mx-4 mt-8 lg:mt-0">
                @include('flash::message')

                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-4xl text-gray-700 lg:text-white">{{ $order->event->ticket_string }} Details</h2>

                    @if(Auth::user()->can('update', $order))
                    <invite-users-form :order="{{ $order }}" :tickets="{{ $order->tickets->where('user_id', null) }}" classes="btn btn-gray btn-sm"></invite-users-form>
                    @endif
                </div>

                @include('orders.partials.tickets')
            </div>
        </div>
    </div>
</main>
@endsection