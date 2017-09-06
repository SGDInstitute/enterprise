@extends('layouts.app')

@section('title', 'Orders')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-top text-white"
                         style="background-image: linear-gradient(rgba(0, 0, 0, 0.55),rgba(0, 0, 0, 0.55)), url({{ $order->event->image }})">
                        @if(isset($order->event->logo_light))
                            <img src="{{ $order->event->logo_light }}" alt="{{ $order->event->title }} Logo"
                                 style="width: 75%; margin-bottom: .5em;">
                        @else
                            <h4 class="card-title">{{ $order->event->title }}</h4>
                        @endif
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
                        @if($order->isPaid())
                            <p class="card-text">Confirmation
                                Number:<br> {{ join('-', str_split($order->confirmation_number, 4)) }}</p>
                            @if($order->isCard())
                                <p class="card-text">Billed to Card: ****-****-****-{{ $order->card_last_four }}</p>
                            @else
                                <p class="card-text">Check Number: {{ $order->transaction_id }}</p>
                            @endif
                        @endif
                    </div>
                    <div class="list-group list-group-flush">
                        @if($order->isPaid())
                            <a href="#" class="list-group-item list-group-item-action">
                                <i class="fa fa-file-text-o fa-fw" aria-hidden="true"></i> Get Receipt</a>
                        @else
                            <a class="list-group-item list-group-item-action" data-toggle="collapse"
                               href="#collapseExample">
                                <i class="fa fa-money fa-fw" aria-hidden="true"></i> Pay Now
                            </a>
                            <div class="collapse list-sub-group" id="collapseExample">
                                <pay-with-card :order="{{ $order }}"
                                               stripe_key="{{ $order->event->getPublicKey() }}"></pay-with-card>
                                <pay-with-check :order="{{ $order }}"></pay-with-check>
                            </div>
                        @endif
                        <invoice-button :order="{{ $order }}"></invoice-button>
                        <a href="{{ asset('/documents/SGD-Institute-W9.pdf') }}" target="_blank"
                           class="list-group-item list-group-item-action">
                            <i class="fa fa-file-text-o fa-fw" aria-hidden="true"></i> Request W-9
                        </a>
                    </div>
                </div>
            </div>
            <div class="col">
                @include('flash::message')

                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Are you ready to tell us who’s
                                    attending {{ $order->event->title }}?</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Great! There are two options to do so. How do you want to proceed?</p>

                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="exampleRadios"
                                               id="exampleRadios1" value="option1">
                                        Fill out attendee information manually
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="exampleRadios"
                                               id="exampleRadios2" value="option2">
                                        Invite attendees to fill out their own information
                                    </label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary">Continue</button>
                            </div>
                        </div>
                    </div>
                </div>

                <h4>{{ $order->event->ticket_string }} Details</h4>
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
                            <td colspan="3" class="text-center">Looks like you don't have
                                any {{ str_plural($order->event->ticket_string) }} filled
                                out!<br><br>
                                <button type="button" class="btn btn-primary border-dark" data-toggle="modal"
                                        data-target="#exampleModal">
                                    Add {{ $order->event->ticket_string }} Information Now
                                </button>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <invoice-form :order="{{ $order }}" :user="{{ Auth::user() }}"></invoice-form>
        <view-invoice-modal :order="{{ $order }}"></view-invoice-modal>
    </div>
@endsection

@section('beforeScripts')
    <script src="https://checkout.stripe.com/checkout.js"></script>
@endsection