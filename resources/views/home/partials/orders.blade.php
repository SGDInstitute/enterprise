<nav class="nav material-tabs" id="myTab" role="tablist">
    <a class="nav-item nav-link active" id="nav-upcoming-tab" data-toggle="tab" href="#nav-upcoming" role="tab"
       aria-controls="nav-upcoming" aria-expanded="true">Orders for Upcoming Events
        <span class="badge badge-pill badge-secondary">{{ $orders['upcoming']->count() }}</span>
    </a>
    <a class="nav-item nav-link" id="nav-past-tab" data-toggle="tab" href="#nav-past" role="tab"
       aria-controls="nav-past">Orders for Past Events
        <span class="badge badge-pill badge-secondary">{{ $orders['past']->count() }}</span>
    </a>
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-upcoming" role="tabpanel" aria-labelledby="nav-upcoming-tab">

        @forelse($orders['upcoming'] as $order)
            <div class="row">
                @include('components.app.order', ['order' => $order])
            </div>
        @empty
            <p>Whoops, it doesn't look like you have any orders for an upcoming event!</p>
            @if($upcomingEvents->count() === 0)

            @elseif($upcomingEvents->count() === 1)
                <p>Why not come to
                    <a href="/events/{{ $upcomingEvents->first()->slug }}">{{ $upcomingEvents->first()->title }}</a>
                </p>
            @else
                <p>Why not come to one of the following events?</p>

                <div class="row">
                    @foreach($upcomingEvents as $event)
                        @include("components.app.event", ['event' => $event])
                    @endforeach
                </div>
            @endif
        @endforelse

    </div>
    <div class="tab-pane fade" id="nav-past" role="tabpanel" aria-labelledby="nav-past-tab">
        @foreach($orders['past'] as $order)
            @include('components.app.order', ['order' => $order])
        @endforeach
    </div>
</div>