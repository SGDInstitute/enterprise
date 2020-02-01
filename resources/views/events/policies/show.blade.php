@extends('layouts.app', ['title' => $event->title . ' ' . ucfirst($policy)])

@extends('layouts.app', ['title' => $event->title])

@section('content')
<main role="main" class="mt-40">
    <div class="bg-mint-500 h-1/3 absolute top-0 w-full -z-1 overflow-hidden" style="background: #38AFAD; background: -webkit-linear-gradient(to left, #1a7796, #38AFAD); background: linear-gradient(to left, #1a7796, #38AFAD);">
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

                <div class="flex items-center">
                    @component('components.app.links', ['class' => 'text-2xl inline-block', 'links' => collect($event->links)->sortBy('order')])
                    @endcomponent
                    @if($event->has('contributions'))
                    <a href="/donations/create/{{ $event->slug }}" class="ml-4 bg-transparent hover:bg-mint-700 text-mint-700 hover:text-white px-2 py-1 border border-mint-700 hover:border-transparent rounded cursor-pointer">
                        Sponsor
                    </a>
                    @endif
                </div>
            </div>

            <div class="p-16">
                <h2 class="text-xl text-mint-700 mb-2">{{ ucfirst($policy) }} Policy</h2>

                {!! $event->$attribute !!}
            </div>
        </div>
    </div>
</main>
@endsection