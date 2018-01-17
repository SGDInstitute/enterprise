@extends('layouts.admin')

@section('header')
    @component('layouts.components.admin.header')
        <div class="col-lg-10">
            <h2>Reports</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="/admin">Dashboard</a>
                </li>
                <li class="active">
                    <strong>Reports</strong>
                </li>
            </ol>
        </div>
    @endcomponent
@endsection

@section('content')
    <report></report>
@endsection