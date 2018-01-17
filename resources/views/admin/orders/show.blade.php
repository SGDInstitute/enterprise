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
                                            <td>{{ $ticket->user ? $ticket->user->name : '' }}</td>
                                            <td>{{ $ticket->user ? $ticket->user->email : '' }}</td>
                                            <td>{{ $ticket->user ? $ticket->user->tshirt : '' }}</td>
                                            <td class="text-right">
                                                @if($ticket->user)
                                                    <a href="" class="btn btn-default">View User</a>
                                                @endif
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
                            @if($order->isPaid())
                                <dl class="dl-horizontal">
                                    <dt>Confirmation Number:</dt>
                                    <dd>{{ join('-', str_split($order->confirmation_number, 4)) }}</dd>

                                    @if($order->isCard())
                                        <dt>Billed to Card</dt>
                                        <dd>****-****-****-{{ $order->receipt->card_last_four }} <i class="fa fa-cc-{{ strtolower($order->receipt->charge()->source->brand) }}"></i></dd>

                                        <dt>Billing Address</dt>
                                        <dd>{{ $order->receipt->charge()->source->address_line1 }} {{ $order->receipt->charge()->source->address_line2 }}, {{ $order->receipt->charge()->source->address_city }}, {{ $order->receipt->charge()->source->address_zip }}</dd>
                                    @else
                                        <dt>Check Number:</dt>
                                        <dd>{{ $order->receipt->transaction_id }}</dd>
                                    @endif

                                    <dt>Paid On:</dt>
                                    <dd>{{ $order->receipt->created_at->format('M j, Y') }}</dd>
                                </dl>
                            @else
                                <p>Order is not paid <button class="btn btn-default" @click="showMarkAsPaidModal = true">Mark as Paid</button></p>

                                <mark-as-paid-modal :order="{{ $order }}" v-if="showMarkAsPaidModal" @close="showMarkAsPaidModal = false"></mark-as-paid-modal>
                            @endif
                        </div>
                    </div>
                    <div id="invoice" class="tab-pane"></div>
                    <div id="activity" class="tab-pane"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
