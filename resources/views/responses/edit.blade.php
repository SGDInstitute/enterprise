@extends('layouts.app', ['title' => $form->name])

@section('content')
<main role="main" class="mt-40">
    <div class="bg-mint-500 h-80 absolute top-0 w-full -z-1 overflow-hidden" style="background: #38AFAD; background: -webkit-linear-gradient(to left, #1a7796, #38AFAD); background: linear-gradient(to left, #1a7796, #38AFAD);">
    </div>
    <div class="mt-12 container">
        @include('flash::message')

        <h1 class="text-white text-center text-3xl font-semibold mb-4">{{ $form->name }}</h1>

        <div class="mb-16">
            <div class="md:w-2/3 lg:w-1/2 md:mx-auto mx-4">
                <div class="p-6 bg-white rounded shadow">
                    @if(now() < $form->start)
                        <h1 class="text-center text-xl">Sorry this form isn't open yet 😟.<br> Check back on {{ $form->start->format('l, F j, Y') }}.</h1>
                        @elseif(now() > $form->end)
                        <h1 class="text-center text-xl">Sorry this form is closed. 😟</h1>
                        @else
                        @if($form->type === 'workshop')
                        @guest
                        <p class="bg-mint-300 border-l-4 border-mint-500 p-4 shadow mb-4 rounded overflow-hidden">
                            Please create an account or login before submitting a workshop proposal.<br> By logging in, you will be able to come back and change your responses later.
                        </p>
                        <workshop-form :dbform="{{ $form }}" :disabled="true"></workshop-form>
                        @else
                        <workshop-form :dbform="{{ $form }}" :response="{{ $response }}"></workshop-form>
                        @endguest
                        @else
                        <dynamic-form :dbform="{{ $form }}"></dynamic-form>
                        @endif
                        @endif
                </div>
            </div>
        </div>
    </div>
</main>
@endsection