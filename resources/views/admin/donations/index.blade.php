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
                <div class="ibox-content">
                    @include("admin.donations.partials.table")
                </div>
            </div>
        </div>
    </div>
@endsection
