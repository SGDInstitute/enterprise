@extends('layouts.admin')

@section('header')
    @component('layouts.components.admin.header')
        <div class="col-lg-10">
            <h2>Give Roles & Permissions to Users</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="/admin">Dashboard</a>
                </li>
                <li>
                    <a href="/admin/users">Users</a>
                </li>
                <li>
                    <a href="/admin/roles">Roles & Permissions</a>
                </li>
                <li class="active">
                    <strong>Give Roles & Permissions</strong>
                </li>
            </ol>
        </div>
    @endcomponent
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-heading"></div>
                <div class="ibox-content">
                    <form action="{{ route('admin.users.access.store') }}" class="form-horizontal" method="post">
                        @include("admin.users.access.partials.form")
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
