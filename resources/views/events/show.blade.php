@extends('layouts.app', ['title' => $event->title])

@section('content')
    <main role="main">
        <div class="bg-mint-500 h-1/3 absolute top-0 w-full -z-1 overflow-hidden"
             style="background: #38AFAD; background: -webkit-linear-gradient(to left, #1a7796, #38AFAD); background: linear-gradient(to left, #1a7796, #38AFAD);">
        </div>

        <div class="px-4 md:px-0 lg:w-8/12 container mx-auto bg-transparent">
            <div class="my-16 w-full relative shadow bg-white rounded-lg overflow-hidden">
                <div class="md:flex">
                    <div class="w-full h-64 md:w-2/3 md:h-80  bg-cover bg-center" style="background-image: url({{ Storage::url($event->image) }})">
                        <img src="{{ Storage::url($event->image) }}" class="hidden" alt="{{ $event->title }} Image">
                    </div>
                    <div class="hidden md:block md:w-1/3 bg-gray-300 py-4 px-6">
                        <h1 class="text-3xl mb-6">{{ $event->title }}</h1>
                        <div class="flex items-center mb-6">
                            <time class="text-center border-r border-gray-500 pr-2" datetime="{{ $event->start }}">
                                <p class="uppercase tracking-wide text-lg font-bold">{{ $event->start->format('M') }}</p>
                                <p class="text-xl tracking-wide">{{ $event->start->format('d') }}</p>
                            </time>
                            <time class="text-center pl-2" datetime="{{ $event->end }}">
                                <p class="uppercase tracking-wide text-lg font-bold">{{ $event->end->format('M') }}</p>
                                <p class="text-xl tracking-wide">{{ $event->end->format('d') }}</p>
                            </time>
                        </div>
                        <p>{{ $event->place }}</p>
                        <p>{{ $event->location }}</p>
                    </div>
                </div>

                <div class="border-b border-t p-4 flex justify-between items-center">
                    @if(isset($event->logo_dark))
                        <img src="{{ Storage::url($event->logo_dark) }}" alt="{{ $event->title }} Logo" class="w-1/3">
                    @else
                        <h1 class="text-3xl">{{ $event->title }}</h1>
                    @endif

                    <div>
                        @component('components.app.links', ['class' => 'text-2xl', 'links' => collect($event->links)->sortBy('order')])
                        @endcomponent
                    </div>
                </div>

                <div class="md:flex">
                    <div class="w-full md:w-2/3 px-4 py-6">
                        <h2 class="text-xl leading-normal mb-4">Description</h2>

                        <ul class="fa-ul list-reset leading-normal ml-6">
                            <li><span class="fa-li"><i class="fal fa-clock"></i></span>{{ $event->duration }}</li>
                            <li><span class="fa-li"><i class="fal fa-map-marker-alt"></i></span>{{ $event->place }} {{ $event->location }}</li>
                        </ul>
                        @if($event->description)
                            <div class="my-8 leading-normal">
                                {!! $event->description !!}
                            </div>
                        @endif


                        @if($event->refund_policy)
                            <p>
                                <a class="text-mint-600 hover:text-mint-800"
                                   data-toggle="collapse" href="#refund_policy" role="button" aria-expanded="false"
                                   aria-controls="refund_policy">
                                    Refund Policy <i class="fa fa-info-circle" aria-hidden="true"></i>
                                </a>
                            </p>
                            <div class="collapse hidden mb-4" id="refund_policy">
                                {!! $event->refund_policy !!}
                            </div>
                        @endif

                        @if($event->photo_policy)
                            <p>
                                <a data-toggle="collapse" href="#photo_policy" role="button" aria-expanded="false"
                                   aria-controls="photo_policy">
                                    Photo Policy <i class="fa fa-info-circle" aria-hidden="true"></i>
                                </a>
                            </p>
                            <div class="collapse mb-4" id="photo_policy">
                                {!! $event->photo_policy !!}
                            </div>
                        @endif

                        @if($event->inclusion_policy)
                            <p>
                                <a data-toggle="collapse" href="#inclusion_policy" role="button" aria-expanded="false"
                                   aria-controls="inclusion_policy">
                                    Code for Inclusion <i class="fa fa-info-circle" aria-hidden="true"></i>
                                </a>
                            </p>
                            <div class="collapse mb-4" id="inclusion_policy">
                                {!! $event->inclusion_policy !!}
                            </div>
                        @endif
                    </div>
                    <div class="w-full border-t md:border-t-0 md:border-l md:w-1/3 px-4 py-6">
                        <start-order :ticket_types="{{ $event->ticket_types }}" :event="{{ $event }}" :user="{{ json_encode(Auth::user()) }}"></start-order>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
