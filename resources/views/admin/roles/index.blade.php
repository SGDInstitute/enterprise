@extends('layouts.admin')

@section('header')
    @component('layouts.components.admin.header')
        <div class="col-lg-10">
            <h2>Roles and Permissions</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="/admin">Dashboard</a>
                </li>
                <li>
                    <a href="/admin/users">Users</a>
                </li>
                <li class="active">
                    <strong>Roles and Permissions</strong>
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
                        <tab name="Users">
                            @include('admin.roles.partials.usersTable')
                        </tab>
                        <tab name="Roles">
                            @include('admin.roles.partials.rolesTable')
                        </tab>
                        <tab name="Permissions">
                            @include('admin.roles.partials.permissionsTable')
                        </tab>
                    </tabs>
                </div>
            </div>
        </div>
    </div>
@endsection
