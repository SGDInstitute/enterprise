<nav class="nav material-tabs" id="myTab" role="tablist">
    <a class="nav-item nav-link active" id="nav-upcoming-tab" data-toggle="tab" href="#nav-upcoming" role="tab"
       aria-controls="nav-upcoming" aria-expanded="true">Upcoming Events
        <span class="badge badge-pill badge-secondary">{{ $orders['upcoming']->count() }}</span>
    </a>
    <a class="nav-item nav-link" id="nav-past-tab" data-toggle="tab" href="#nav-past" role="tab"
       aria-controls="nav-past">Past Events
        <span class="badge badge-pill badge-secondary">{{ $orders['past']->count() }}</span>
    </a>
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-upcoming" role="tabpanel" aria-labelledby="nav-upcoming-tab">
        <div class="row">
            @foreach($orders['upcoming'] as $order)
                @include('components.app.order', ['order' => $order])
            @endforeach
        </div>
    </div>
    <div class="tab-pane fade" id="nav-past" role="tabpanel" aria-labelledby="nav-past-tab">
        @foreach($orders['past'] as $order)
            @include('components.app.order', ['order' => $order])
        @endforeach
    </div>
</div>