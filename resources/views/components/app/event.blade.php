<div class="col-md-6">
    <a href="/events/{{ $event->slug }}" class="card card-background-image" style="background-image: linear-gradient(rgba(0, 0, 0, 0.55),rgba(0, 0, 0, 0.55)), url({{ $event->image }})">
        <div class="card-body text-white">
            @if(isset($event->logo_light))
                <img src="{{ $event->logo_light }}" alt="{{ $event->title }} Logo" style="width: 75%; margin-bottom: .5em;">
            @else
                <h4 class="card-title">{{ $event->title }}</h4>
            @endif
            <ul class="fa-ul">
                <li><i class="fa-li fa fa-clock-o"></i>
                    {{ $event->formatted_start }} - {{ $event->formatted_end }}, {{ $event->end->format('Y') }}</li>
                <li>
                    <i class="fa-li fa fa-map-marker"></i> {{ $event->place }} {{ $event->location }}
                </li>
            </ul>
        </div>
    </a>
</div>