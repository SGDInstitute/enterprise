@extends("layouts.admin")

@section('header')
    @component('layouts.components.admin.header')
        <div class="col-lg-10">
            <h2>{{ $user->name }}'s Profile</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="/admin">Dashboard</a>
                </li>
                <li>
                    <a href="/admin/users">Users</a>
                </li>
                <li class="active">
                    <strong>Profile</strong>
                </li>
            </ol>
        </div>
    @endcomponent
@endsection

@section("content")
    <div class="row">
        <div class="col-md-4">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Profile Detail</h5>
                </div>
                <div>
                    <div class="ibox-content">
                        <img alt="Profile Image" class="img-responsive img-circle pull-left m-r-lg" src="{{ $user->image }}">
                        <h4><strong>{{ $user->name }}</strong></h4>

                        <p><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></p>
                        <p><b>Joined On:</b> {{ $user->created_at->format('m/d/Y h:i a') }}</p>

                        @can('impersonate')
                            <a href="{{ route('admin.user.impersonate', $user) }}" class="btn btn-default btn-block">
                                <i class="fa fa-user-secret"></i> Impersonate</a>
                        @endcan
                    </div>
                    <div class="ibox-content no-padding">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <strong>Pronouns</strong> {{ $user->profile->pronouns }}
                            </li>
                            <li class="list-group-item">
                                <strong>Sexuality</strong> {{ $user->profile->sexuality }}
                            </li>
                            <li class="list-group-item">
                                <strong>Gender</strong> {{ $user->profile->gender }}
                            </li>
                            <li class="list-group-item ">
                                <strong>Race</strong> {{ $user->profile->race }}
                            </li>
                            <li class="list-group-item">
                                <strong>College</strong> {{ $user->profile->college }}
                            </li>
                            <li class="list-group-item">
                                <strong>T-Shirt Size</strong> {{ $user->profile->tshirt}}
                            </li>
                            <li class="list-group-item">
                                <strong>Accommodation</strong> {{ $user->profile->accommodation }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#orders" aria-controls="orders" role="tab" data-toggle="tab">Orders</a></li>
                <li role="presentation"><a href="#donations" aria-controls="donations" role="tab" data-toggle="tab">Donations</a></li>
                <li role="presentation"><a href="#activity" aria-controls="activity" role="tab" data-toggle="tab">Activity</a></li>
                @can('manage_roles')
                    <li role="presentation"><a href="#permissions" aria-controls="permissions" role="tab" data-toggle="tab">Settings</a></li>
                @endcan
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="orders">...</div>
                <div role="tabpanel" class="tab-pane" id="donations">...</div>
                <div role="tabpanel" class="tab-pane" id="activity">...</div>
                <div role="tabpanel" class="tab-pane" id="permissions">...</div>
            </div>
        </div>
    </div>
@endsection