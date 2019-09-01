<div class="bg-white rounded shadow overflow-hidden">
    <nav class="bg-mint-200 px-8 pt-2 border-b border-mint-300">
        <div class="-mb-px flex nav nav-tabs material-nav" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="upcoming-tab" data-toggle="tab" href="#upcoming" role="tab" aria-controls="upcoming" aria-selected="true">Orders for Upcoming Events</a>
            @if($orders['past']->isNotEmpty())
            <a class="nav-item nav-link" id="past-tab" data-toggle="tab" href="#past" role="tab" aria-controls="past" aria-selected="false">Orders for Past Events</a>
            @endif
        </div>
    </nav>
    <div class="tab-content p-6" id="nav-tabContent">
        <div class="tab-pane fade show active" id="upcoming" role="tabpanel" aria-labelledby="upcoming-tab">
            @if($orders['upcoming']->isNotEmpty())
            <div class="flex flex-wrap -mx-4">
                @foreach($orders['upcoming'] as $order)
                <div class="w-1/2 mb-4">
                    @include('components.app.order', ['order' => $order])
                </div>
                @endforeach
            </div>
            @else
            <p class="leading-normal">Whoops, it doesn't look like you have any orders for an upcoming event!</p>
            @if($upcomingEvents->count() === 0)

            @elseif($upcomingEvents->count() === 1)
            <p class="leading-normal">Why not come to
                <a href="/events/{{ $upcomingEvents->first()->slug }}">{{ $upcomingEvents->first()->title }}</a>?
            </p>
            @else
            <p class="leading-normal mb-4">Why not come to one of the following events?</p>

            <div class="flex flex-wrap -mx-4">
                @foreach($upcomingEvents as $upcoming)
                @include("components.app.event", ['event' => $upcoming])
                @endforeach
            </div>
            @endif
            @endif
        </div>
        @if($orders['past']->isNotEmpty())
        <div class="tab-pane fade" id="past" role="tabpanel" aria-labelledby="past-tab">
            @foreach($orders['past'] as $order)
            @include('components.app.order', ['order' => $order])
            @endforeach
        </div>
        @endif
    </div>
</div>