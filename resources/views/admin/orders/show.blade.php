@extends('layouts.admin', ['title' => 'Show Order'])

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include("components.app.event", ['event' => $order->event])
        </div>
        <div class="col-md-9">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#tickets"><i class="fa fa-ticket" aria-hidden="true"></i> Tickets</a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#payment">
                            <i class="fa fa-credit-card" aria-hidden="true"></i> Payment Details
                        </a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#invoice">
                            <i class="fa fa-file-text-o" aria-hidden="true"></i> Invoice
                        </a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#activity"><i class="fa fa-bolt" aria-hidden="true"></i> Activity</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="tickets" class="tab-pane active">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>T-Shirt</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($order->tickets as $ticket)
                                        <tr>
                                            <td>{{ $ticket->user->name }}</td>
                                            <td>{{ $ticket->user->email }}</td>
                                            <td>{{ $ticket->user->tshirt }}</td>
                                            <td class="text-right">
                                                <a href="" class="btn btn-default">View User</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div id="payment" class="tab-pane">
                        <div class="panel-body">
                            <strong>Donec quam felis</strong>

                            <p>Thousand unknown plants are noticed by me: when I hear the buzz of the little world among
                                the stalks, and grow familiar with the countless indescribable forms of the insects
                                and flies, then I feel the presence of the Almighty, who formed us in his own image, and
                                the breath </p>

                            <p>I am alone, and feel the charm of existence in this spot, which was created for the bliss
                                of souls like mine. I am so happy, my dear friend, so absorbed in the exquisite
                                sense of mere tranquil existence, that I neglect my talents. I should be incapable of
                                drawing a single stroke at the present moment; and yet.</p>
                        </div>
                    </div>
                    <div id="invoice" class="tab-pane"></div>
                    <div id="activity" class="tab-pane"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
