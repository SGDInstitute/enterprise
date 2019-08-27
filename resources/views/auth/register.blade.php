@extends('layouts.app', ['title' => 'Register'])

@section('content')
<main role="main" class="mt-40">
    <div class="bg-mint-500 h-80 absolute top-0 w-full -z-1 overflow-hidden" style="background: #38AFAD; background: -webkit-linear-gradient(to left, #1a7796, #38AFAD); background: linear-gradient(to left, #1a7796, #38AFAD);">
    </div>
    <div class="w-full px-4 md:px-0 md:w-1/2 mx-auto">
        <div class="bg-white p-6 rounded shadow mb-16">
            <h1 class="text-xl mb-6">Create an Account</h1>
            <form method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>

                    <input id="name" type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                    @if ($errors->has('name'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">E-Mail Address</label>

                    <input id="email" type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                    @if ($errors->has('email'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>

                    <div class="input-group">
                        <input id="password" type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password" required>
                        <div class="input-group-append">
                            <span class="input-group-text" data-container="body" data-toggle="popover" data-placement="top" title="Password Requirements" data-content="Your password must be at least 8 characters in length, with at least 3 of the following: upper case letter, lower case letter, number, or special character.">
                                <i class="fa fa-info"></i>
                            </span>
                        </div>
                    </div>

                    @if ($errors->has('password'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="password-confirm" class="form-label">Confirm Password</label>

                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                </div>

                <button type="submit" class="btn btn-mint">Create Account</button>
                <a class="btn btn-link" href="{{ route('login') }}">
                    Already have an account? Login
                </a>
            </form>
        </div>
    </div>
</main>
@endsection