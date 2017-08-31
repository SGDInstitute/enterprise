<nav class="nav material-tabs" id="myTab" role="tablist">
    <a class="nav-item nav-link active" id="nav-upcoming-tab" data-toggle="tab" href="#nav-upcoming" role="tab" aria-controls="nav-upcoming" aria-expanded="true">Upcoming Events</a>
    <a class="nav-item nav-link" id="nav-past-tab" data-toggle="tab" href="#nav-past" role="tab" aria-controls="nav-past">Past Events</a>
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-upcoming" role="tabpanel" aria-labelledby="nav-upcoming-tab">
        @foreach($orders as $order)
            @include('components.app.order', ['order' => $order])
        @endforeach
    </div>
    <div class="tab-pane fade" id="nav-past" role="tabpanel" aria-labelledby="nav-past-tab">

    </div>
</div>