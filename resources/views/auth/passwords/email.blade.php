@extends('layouts.app', ['title' => 'Reset Password'])

@section('content')
<main role="main" class="mt-40">
    <div class="bg-mint-500 h-80 absolute top-0 w-full -z-1 overflow-hidden" style="background: #38AFAD; background: -webkit-linear-gradient(to left, #1a7796, #38AFAD); background: linear-gradient(to left, #1a7796, #38AFAD);">
    </div>
    <div class="w-full px-4 md:px-0 md:w-1/2 mx-auto">
        <div class="bg-white p-6 rounded shadow mb-16">
            <h1 class="text-xl mb-6">Reset Password</h1>

            <form method="POST" action="{{ route('password.email') }}">
                {{ csrf_field() }}

                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif

                <div class="mb-3">
                    <label for="email" class="form-label">E-Mail Address</label>

                    <input id="email" type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                    @if ($errors->has('email'))
                    <span class="mt-2 text-red-500">{{ $errors->first('email') }}</span>
                    @endif
                </div>

                <button type="submit" class="btn btn-mint">
                    Send Password Reset Link
                </button>
            </form>
        </div>
    </div>
</main>
@endsection