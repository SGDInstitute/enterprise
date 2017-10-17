@extends('layouts.admin')

@section('header')
    @component('layouts.components.admin.header')
        <div class="col-lg-10">
            <h2>Create Role</h2>
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
                    <strong>Create Role</strong>
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
                    <form action="/admin/roles" class="form-horizontal" method="post">
                        @include("admin.roles.partials.form")
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
