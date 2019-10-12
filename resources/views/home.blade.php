@extends('layouts.app', ['title' => 'Home'])

@section('content')
<main role="main" class="mt-32">
    <div class="mt-12 container mb-16">
        <div class="md:flex -mx-4">
            <div class="md:w-1/4 px-4">
                <div class="nav flex flex-col bg-white rounded shadow vertical-nav overflow-hidden" id="sections" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="orders-tab" data-toggle="tab" href="#orders" role="tab" aria-controls="orders" aria-selected="true">Orders</a>
                    <a class="nav-link" id="donations-tab" data-toggle="tab" href="#donations" role="tab" aria-controls="donations" aria-selected="false">Donations</a>
                    <a class="nav-link" id="workshops-tab" data-toggle="tab" href="#workshops" role="tab" aria-controls="workshops" aria-selected="false">Workshops</a>
                    <a class="nav-link" id="settings-tab" data-toggle="tab" href="#settings" role="tab" aria-controls="settings" aria-selected="false">Settings</a>
                </div>
            </div>
            <div class="md:w-3/4 px-4">
                <div class="tab-content" id="sectionsContent">
                    <div class="tab-pane fade show active" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                        @include('home.partials.orders')
                    </div>
                    <div class="tab-pane fade" id="donations" role="tabpanel" aria-labelledby="donations-tab">
                        @include('home.partials.donations')
                    </div>
                    <div class="tab-pane fade" id="workshops" role="tabpanel" aria-labelledby="workshops-tab">
                        @include('home.partials.workshops')
                    </div>
                    <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                        @include('home.partials.settings')
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection