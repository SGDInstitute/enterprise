@extends('layouts.app', ['title' => $event->title])

@section('content')
<main role="main" class="mt-40">
    <div class="absolute top-0 w-full overflow-hidden bg-mint-500 h-1/3 -z-1" style="background: #38AFAD; background: -webkit-linear-gradient(to left, #1a7796, #38AFAD); background: linear-gradient(to left, #1a7796, #38AFAD);">
    </div>

    <div class="container px-4 mx-auto bg-transparent md:px-0 lg:w-8/12">
        <div class="relative w-full my-16 overflow-hidden bg-white rounded-lg shadow">
            <div class="md:flex">
                <div class="w-full h-64 bg-center bg-cover md:w-2/3 md:h-80" style="background-image: url({{ Storage::url($event->image) }})">
                    <img src="{{ Storage::url($event->image) }}" class="hidden" alt="{{ $event->title }} Image">
                </div>
                <div class="hidden px-6 py-4 bg-gray-300 md:block md:w-1/3">
                    <h1 class="mb-6 text-3xl">{{ $event->title }}</h1>
                    <div class="flex items-center mb-6">
                        @if($event->end->format('Y-m-d') != $event->start->format('Y-m-d'))
                        <time class="pr-2 text-center border-r border-gray-500" datetime="{{ $event->start }}">
                            <p class="text-lg font-bold tracking-wide uppercase">{{ $event->start->format('M') }}</p>
                            <p class="text-xl tracking-wide">{{ $event->start->format('d') }}</p>
                        </time>
                        @endif
                        <time class="pl-2 text-center" datetime="{{ $event->end }}">
                            <p class="text-lg font-bold tracking-wide uppercase">{{ $event->end->format('M') }}</p>
                            <p class="text-xl tracking-wide">{{ $event->end->format('d') }}</p>
                        </time>
                    </div>
                    <p>{{ $event->place }}</p>
                    <p>{{ $event->location }}</p>
                </div>
            </div>

            <div class="flex items-center justify-between p-4 border-t border-b">
                @if(isset($event->logo_dark))
                <img src="{{ Storage::url($event->logo_dark) }}" alt="{{ $event->title }} Logo" class="w-1/3">
                @else
                <h1 class="text-3xl">{{ $event->title }}</h1>
                @endif

                <div class="flex items-center">
                    @component('components.app.links', ['class' => 'text-2xl inline-block', 'links' => collect($event->links)->sortBy('order')])
                    @endcomponent
                    @if($event->has('contributions'))
                    <a href="/donations/create/{{ $event->slug }}" class="px-2 py-1 ml-4 bg-transparent border rounded cursor-pointer hover:bg-mint-700 text-mint-700 hover:text-white border-mint-700 hover:border-transparent">
                        Sponsor
                    </a>
                    @endif
                </div>
            </div>

            <div class="md:flex">
                <div class="w-full px-4 py-6 md:w-2/3">
                    <h2 class="mb-4 text-xl leading-normal">Description</h2>

                    <ul class="ml-6 leading-normal fa-ul list-reset">
                        <li><span class="fa-li"><i class="fal fa-clock"></i></span>{{ $event->duration }}</li>
                        <li><span class="fa-li"><i class="fal fa-map-marker-alt"></i></span>{{ $event->place }} {{ $event->location }}</li>
                    </ul>
                    @if($event->description)
                    <div class="my-8 leading-normal">
                        {!! $event->description !!}
                    </div>
                    @endif

                    @if($event->refund_policy)
                    <p class="mb-4">
                        <a class="btn btn-link hover:bg-gray-100" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                            Refund Policy <i class="fa fa-info-circle" aria-hidden="true"></i>
                        </a>
                    </p>
                    <div class="collapse" id="collapseExample">
                        {!! $event->refund_policy !!}
                    </div>
                    @endif

                    @if($event->photo_policy)
                    <p>
                        <a data-toggle="collapse" href="#photo_policy" role="button" aria-expanded="false" aria-controls="photo_policy">
                            Photo Policy <i class="fa fa-info-circle" aria-hidden="true"></i>
                        </a>
                    </p>
                    <div class="mb-4 collapse" id="photo_policy">
                        {!! $event->photo_policy !!}
                    </div>
                    @endif

                    @if($event->inclusion_policy)
                    <p>
                        <a data-toggle="collapse" href="#inclusion_policy" role="button" aria-expanded="false" aria-controls="inclusion_policy">
                            Code for Inclusion <i class="fa fa-info-circle" aria-hidden="true"></i>
                        </a>
                    </p>
                    <div class="mb-4 collapse" id="inclusion_policy">
                        {!! $event->inclusion_policy !!}
                    </div>
                    @endif
                </div>
                <div class="w-full px-4 py-6 border-t md:border-t-0 md:border-l md:w-1/3">
                    @if($show_volunteer)
                    <div class="p-4 mb-4 border-l-4 rounded shadow bg-mint-200 border-mint-500">
                        <p class="mb-2 leading-normal">It looks like you're a volunteer! If you haven't signed up for any shifts please do so before registering, otherwise we can't calculate your discount!</p>
                        <calculate-discount id="{{ $event->id }}" class="rounded-lg btn btn-mint btn-sm btn-block">Calculate</calculate-discount>
                    </div>
                    @endif
                    <start-order :ticket_types="{{ $ticket_types }}" :event="{{ $event }}" :user="{{ json_encode(Auth::user()) }}"></start-order>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
