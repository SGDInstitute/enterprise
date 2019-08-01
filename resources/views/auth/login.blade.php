@extends('layouts.app', ['title' => 'Login'])

@section('content')
    <main role="main" class="mt-40">
        <div class="bg-mint-500 h-80 absolute top-0 w-full -z-1 overflow-hidden"
             style="background: #38AFAD; background: -webkit-linear-gradient(to left, #1a7796, #38AFAD); background: linear-gradient(to left, #1a7796, #38AFAD);">
        </div>
        <div class="w-full px-4 md:px-0 md:w-1/2 mx-auto">
            <div class="bg-white p-6 rounded shadow">
                <h1 class="text-xl mb-6">Login</h1>
                <form method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}

                    <div class="mb-3">
                        <label for="email" class="form-label">E-Mail Address</label>

                        <input id="email" type="email"
                               class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email"
                               value="{{ old('email') }}" required autofocus>

                        @if ($errors->has('email'))
                            <span class="invalid-feedback">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>

                        <input id="password" type="password"
                               class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                               required>

                        @if ($errors->has('password'))
                            <span class="invalid-feedback">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            <input class="form-check-input" type="checkbox" name="remember"> Remember Me
                        </label>
                    </div>

                    <button type="submit" class="btn btn-mint">Login</button>
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        Forgot Your Password?
                    </a>
                    <a class="btn btn-link" href="{{ route('login.magic') }}">
                        Login with magic link instead
                    </a>
                </form>
            </div>
        </div>
    </main>
@endsection
