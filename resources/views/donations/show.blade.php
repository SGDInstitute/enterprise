@extends('layouts.app')

@section('title', 'View Donation')

@section('content')
    <div class="container">
        @include('flash::message')

        <div class="row">
            <div class="nav col-md-3 flex-column nav-pills" id="v-pills-tab" role="tablist">
                <a class="nav-link active" id="v-pills-primary-contact-tab" data-toggle="pill"
                   href="#v-pills-primary-contact" role="tab" aria-controls="v-pills-primary-contact"
                   aria-expanded="true">Primary Contact</a>
                @if($donation->company_name)
                    <a class="nav-link" id="v-pills-company-tab" data-toggle="pill" href="#v-pills-company" role="tab"
                       aria-controls="v-pills-company" aria-expanded="true">Company Information</a>
                @endif
                @if(isset($charge))
                    <a class="nav-link" id="v-pills-transaction-tab" data-toggle="pill" href="#v-pills-transaction"
                       role="tab" aria-controls="v-pills-transaction" aria-expanded="true">Transaction</a>
                @else
                    <a class="nav-link" id="v-pills-recurring-donation-tab" data-toggle="pill"
                       href="#v-pills-recurring-donation" role="tab" aria-controls="v-pills-recurring-donation"
                       aria-expanded="true">Recurring Donation</a>
                @endif
            </div>
            <div class="col tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-primary-contact" role="tabpanel"
                     aria-labelledby="v-pills-primary-contact-tab">
                    @include('donations.partials.primary_contact')
                </div>
                @if($donation->company_name)
                    <div class="tab-pane fade" id="v-pills-company" role="tabpanel"
                         aria-labelledby="v-pills-company-tab">
                        @include('donations.partials.company')
                    </div>
                @endif
                @if(isset($charge))
                    <div class="tab-pane fade" id="v-pills-transaction" role="tabpanel"
                         aria-labelledby="v-pills-transaction-tab">
                        @include('donations.partials.transaction')
                    </div>
                @else
                    <div class="tab-pane fade" id="v-pills-recurring-donation" role="tabpanel"
                         aria-labelledby="v-pills-recurring-donation-tab">
                        @include('donations.partials.subscription')
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection