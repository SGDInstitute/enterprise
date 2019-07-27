<a href="/events/{{ $event->slug }}" class="block w-80 bg-gray-100 hover:bg-white rounded overflow-hidden shadow hover:shadow-lg">
    @if($event->image)
        <img class="w-full" src="{{ $event->image }}" alt="{{ $event->title }}">
    @else
    <img class="w-full" src="https://tailwindcss.com/img/card-top.jpg" alt="Sunset in the mountains">
    @endif
    <div class="px-6 py-4">
        @if(isset($event->logo_dark))
            <img src="{{ Storage::url($event->logo_dark) }}" alt="{{ $event->title }} Logo" style="width: 75%; margin-bottom: .5em;">
        @else
            <h2 class="font-bold text-xl mb-2">{{ $event->title }}</h2>
        @endif
        <ul class="fa-ul list-reset ml-6">
            <li>
                <span class="fa-li"><i class="fal fa-clock"></i></span>
                {{ $event->formatted_start }} - {{ $event->formatted_end }}, {{ $event->end->format('Y') }}</li>
            <li>
                <span class="fa-li"><i class="fal fa-map-marker-alt"></i></span>
                {{ $event->place }} {{ $event->location }}
            </li>
        </ul>
    </div>
</a>