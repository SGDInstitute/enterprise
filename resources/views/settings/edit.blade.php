@extends('layouts.app')

@section('title', 'Settings')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="nav list-group" id="tab" role="tablist">
                    <a class="list-group-item list-group-item-action active" id="profile-tab" data-toggle="pill"
                       href="#profile" role="tab" aria-controls="profile" aria-expanded="true">Profile</a>
                    <a class="list-group-item list-group-item-action" id="password-tab" data-toggle="pill"
                       href="#password" role="tab" aria-controls="password" aria-expanded="true">Password</a>
                </div>
            </div>
            <div class="col">
                <div class="tab-content" id="tabContent">
                    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <edit-profile :user="{{ $user }}" :profile="{{ $user->profile }}"></edit-profile>
                    </div>
                    <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
                        <edit-password></edit-password>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection