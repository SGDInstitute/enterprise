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
                            <a href="{{ route("admin.users.access.create") }}" class="btn btn-default m-b-sm">
                                Give Permission To</a>
                            @include('admin.roles.partials.usersTable')
                        </tab>
                        <tab name="Roles">
                            <a href="{{ route('admin.roles.create') }}" class="btn btn-default m-b-sm">Create Role</a>
                            @include('admin.roles.partials.rolesTable')
                        </tab>
                        <tab name="Permissions">
                            @can("create_permission")
                                <a href="{{ route('admin.permissions.create') }}" class="btn btn-default m-b-sm">
                                    Create Permission</a>
                            @endcan

                            @include('admin.roles.partials.permissionsTable')
                        </tab>
                    </tabs>
                </div>
            </div>
        </div>
    </div>
@endsection
