@extends('layouts.admin')

@section('header')
    @component('layouts.components.admin.header')
        <div class="col-lg-10">
            <h2>Edit {{ str_title($role->name) }} Role</h2>
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
                    <strong>Edit {{ str_title($role->name) }} Role</strong>
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
                    <form action="{{ route("admin.roles.update", $role) }}" class="form-horizontal" method="post">
                        {{ method_field("patch") }}
                        @include("admin.roles.partials.form")
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
