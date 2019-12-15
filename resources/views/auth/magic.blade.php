@extends('layouts.app', ['title' => 'Magic Login'])

@section('content')
<main role="main" class="mt-40">
    <div class="bg-mint-500 h-80 absolute top-0 w-full -z-1 overflow-hidden" style="background: #38AFAD; background: -webkit-linear-gradient(to left, #1a7796, #38AFAD); background: linear-gradient(to left, #1a7796, #38AFAD);">
    </div>
    <div class="w-full px-4 md:px-0 md:w-1/2 mx-auto">
        <div class="bg-white p-6 rounded shadow mb-16">
            <h1 class="text-xl mb-6">Login with Login Link</h1>
            <form method="POST" action="/login/magic">
                {{ csrf_field() }}

                <div class="mb-3">
                    <label for="email" class="form-label">E-Mail Address</label>

                    <input id="email" type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                    @if ($errors->has('email'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        <input class="form-check-input" type="checkbox" name="remember"> Remember Me
                    </label>
                </div>

                <button type="submit" class="btn btn-mint">Send Magic Login Link</button>
                <a class="btn btn-link" href="{{ route('login') }}">
                    Login with password instead
                </a>
            </form>
        </div>
    </div>
</main>
@endsection

@extends('layouts.app', ['title' => 'Magic Login'])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Magic Login</div>
                <div class="card-body">
                    @include('flash::message')

                    <form method="POST" action="/login/magic">
                        {{ csrf_field() }}

                        <div class="row form-group">
                            <label for="email" class="col-md-3 col-form-label">E-Mail Address</label>

                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-9 ml-auto">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" name="remember"> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-9 ml-auto">
                                <button type="submit" class="btn btn-primary">Send Magic Login Link</button>
                                <a class="btn btn-link" href="{{ route('login') }}">
                                    Login with password instead
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection