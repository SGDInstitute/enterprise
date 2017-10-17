@extends('layouts.admin')

@section('header')
    @component('layouts.components.admin.header')
        <div class="col-lg-10">
            <h2>Donations</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="/admin">Dashboard</a>
                </li>
                <li class="active">
                    <strong>Donations</strong>
                </li>
            </ol>
        </div>
    @endcomponent
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-content no-padding">
                    <tabs>
                        <tab name="One Time Donations">
                            @include("admin.donations.partials.oneTimeTable")
                        </tab>
                        <tab name="Recurring Donations">
                            @include("admin.donations.partials.recurringTable")
                        </tab>
                    </tabs>
                </div>
            </div>
        </div>
    </div>
@endsection
