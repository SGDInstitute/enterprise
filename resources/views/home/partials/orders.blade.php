<tabs :options="{ useUrlFragment: false }">
    <tab name="Orders for Upcoming Events" suffix='<span class="badge badge-pill badge-secondary">{{ $orders['past']->count() }}</span>'>
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
                        <div class="col-md-6">
                            @include("components.app.event", ['event' => $event])
                        </div>
                    @endforeach
                </div>
            @endif
        @endforelse
    </tab>
    <tab name="Orders for Past Events" suffix='<span class="badge badge-pill badge-secondary">{{ $orders['past']->count() }}</span>'>
        @foreach($orders['past'] as $order)
            @include('components.app.order', ['order' => $order])
        @endforeach
    </tab>
</tabs>