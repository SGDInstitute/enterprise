@extends('layouts.app')

@section('title', 'Orders')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-top text-white"
                         style="background-image: linear-gradient(rgba(0, 0, 0, 0.55),rgba(0, 0, 0, 0.55)), url(https://www.unomaha.edu/college-of-public-affairs-and-community-service/criminology-and-criminal-justice/_files/images/arts-and-sciences-fall.jpg)">
                        <h4 class="card-title">{{ $order->event->title }}</h4>
                        <ul class="fa-ul">
                            <li><i class="fa-li fa fa-clock-o"></i>
                                {{ $order->event->formatted_start }} - {{ $order->event->formatted_end }}</li>
                            <li>
                                <i class="fa-li fa fa-map-marker"></i> {{ $order->event->place }} {{ $order->event->location }}
                            </li>
                        </ul>
                        @component('components.app.links', ['links' => $order->event->links])
                            <a href="/events/{{ $order->event->slug }}" class="btn btn-outline-light pull-right btn-sm">VIEW
                                EVENT</a>
                        @endcomponent
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">{{ '$' . number_format($order->amount/100, 2) }}</h4>
                        <p class="card-text text-muted">Number of Tickets
                            <span class="pull-right">
                                {{ $order->tickets()->filled()->count() }} of {{ $order->tickets->count() }}
                            </span>
                        </p>
                    </div>
                    <div class="list-group list-group-flush">
                        @if($order->isPaid())
                            <a href="#" class="list-group-item list-group-item-action">
                                <i class="fa fa-file-text-o fa-fw" aria-hidden="true"></i> Get Receipt</a>
                        @else
                            <pay-with-card :order="{{ $order }}" stripe_key="{{ $order->event->getPublicKey() }}"></pay-with-card>
                            <pay-with-check :order="{{ $order }}"></pay-with-check>
                            <download-invoice :order="{{ $order }}"></download-invoice>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col">
                @include('flash::message')

                <button class="btn btn-primary pull-right btn-sm">Fill Out Ticket</button>
                <h4>Ticket Details</h4>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>E-Mail</th>
                        <th>T-Shirt</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse ($order->tickets()->filled() as $ticket)
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">Looks like you don't have any tickets filled out! Want to do that now?</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <create-invoice-modal></create-invoice-modal>
    </div>
@endsection

@section('beforeScripts')
    <script src="https://checkout.stripe.com/checkout.js"></script>
@endsection