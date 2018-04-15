@extends('layouts.admin')

@section('header')
    @component('layouts.components.admin.header')
        <div class="col-lg-10">
            <h2>Donations</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="/admin">Dashboard</a>
                </li>
                <li>
                    <a href="/admin/donations">Donations</a>
                </li>
                <li class="active">
                    <strong>Current Donation</strong>
                </li>
            </ol>
        </div>
    @endcomponent
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-content">

                    <h3>Primary Contact</h3>
                    @include('donations.partials.primary_contact')

                    @if($donation->company_name)
                        <h3>Company Information</h3>
                        @include('donations.partials.company')
                    @endif

                    @if(isset($charge))
                        <h3>Transaction Information</h3>
                        @include('donations.partials.transaction')
                    @else
                        <h3>Subscription Information</h3>
                        @include('donations.partials.subscription')
                    @endif

                    <h3>Address</h3>


                    <address>
                        {!! $address !!}
                    </address>
                </div>
            </div>
        </div>
    </div>
@endsection
