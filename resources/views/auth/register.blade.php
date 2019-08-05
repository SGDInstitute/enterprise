@extends('layouts.app', ['title' => 'Register'])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card">
                <div class="card-header">Register</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="row form-group">
                            <label for="name" class="col-md-4 col-form-label">Name</label>

                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row form-group">
                            <label for="email" class="col-md-4 col-form-label">E-Mail Address</label>

                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row form-group">
                            <label for="password" class="col-md-4 col-form-label">Password</label>

                            <div class="col-md-8">
                                <div class="input-group">
                                    <input id="password" type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text"
                                              data-container="body" data-toggle="popover"
                                              data-placement="top"
                                              title="Password Requirements"
                                              data-content="Your password must be at least 8 characters in length, with at least 3 of the following: upper case letter, lower case letter, number, or special character.">
                                            <i class="fa fa-info"></i>
                                        </span>
                                    </div>
                                </div>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" style="display: block;">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row form-group">
                            <label for="password-confirm" class="col-md-4 col-form-label">Confirm Password</label>

                            <div class="col-md-8">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-8 ml-auto">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
