@extends('layouts.app', ['title' => 'Home'])

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="nav list-group" id="v-pills-tab" role="tablist">
                    <a class="list-group-item list-group-item-action active" id="v-pills-orders-tab" data-toggle="pill"
                       href="#v-pills-orders" role="tab" aria-controls="v-pills-orders" aria-expanded="true">Orders</a>
                    <a class="list-group-item list-group-item-action" id="v-pills-donations-tab" data-toggle="pill"
                       href="#v-pills-donations" role="tab" aria-controls="v-pills-donations" aria-expanded="true">Donations</a>
                </div>
            </div>
            <div class="col">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-orders" role="tabpanel"
                         aria-labelledby="v-pills-orders-tab">
                        @include('home.partials.orders')
                    </div>
                    <div class="tab-pane fade" id="v-pills-donations" role="tabpanel"
                         aria-labelledby="v-pills-donations-tab">
                        @include('home.partials.donations')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
