<div class="card">
    <div class="card-top text-white"
         style="background-image: linear-gradient(rgba(0, 0, 0, 0.55),rgba(0, 0, 0, 0.55)), url({{ $order->event->image }})">
        @if(isset($order->event->logo_light))
            <img src="{{ $order->event->logo_light }}" alt="{{ $order->event->title }} Logo"
                 style="width: 75%; margin-bottom: .5em;">
        @else
            <h4 class="card-title">{{ $order->event->title }}</h4>
        @endif
        <ul class="fa-ul">
            <li><i class="fa-li fa fa-clock-o"></i>
                {{ $order->event->formatted_start }} - {{ $order->event->formatted_end }}</li>
            <li>
                <i class="fa-li fa fa-map-marker"></i> {{ $order->event->place }} {{ $order->event->location }}
            </li>
        </ul>
        @component('components.app.links', ['links' => $order->event->links])
            <a href="/events/{{ $order->event->slug }}" class="btn btn-outline-light pull-right btn-sm">VIEW
                EVENT</a>
        @endcomponent
    </div>
    <div class="card-body">
        <h4 class="card-title">{{ '$' . number_format($order->amount/100, 2) }}</h4>
        <p class="card-text text-muted">Number of {{ str_plural($order->event->ticket_string) }} Filled
            <span class="pull-right">
                {{ $order->tickets()->filled()->count() }} of {{ $order->tickets->count() }}
            </span>
        </p>
        @if($order->isPaid())
            <p class="card-text">Confirmation
                Number:<br> {{ join('-', str_split($order->confirmation_number, 4)) }}</p>
            @if(Auth::user()->can('update', $order))
                @if($order->isCard())
                    <p class="card-text">Billed to Card: ****-****-****-{{ $order->receipt->card_last_four }}</p>
                @else
                    <p class="card-text">Check Number: {{ $order->receipt->transaction_id }}</p>
                @endif
            @endif
        @endif
    </div>
    @if(Auth::user()->can('update', $order))
        <div class="list-group list-group-flush">
        @if($order->isPaid())
            <receipt-button :order="{{ $order }}"></receipt-button>
        @else
            <a class="list-group-item list-group-item-action" data-toggle="collapse"
               href="#collapseExample">
                <i class="fa fa-money fa-fw" aria-hidden="true"></i> Pay Now
            </a>
            <div class="collapse list-sub-group" id="collapseExample">
                <pay-with-card :order="{{ $order }}"
                               stripe_key="{{ $order->event->getPublicKey() }}"></pay-with-card>
                <pay-with-check :order="{{ $order }}"></pay-with-check>
            </div>
        @endif
        <invoice-button :order="{{ $order }}"></invoice-button>
        <a href="{{ asset('/documents/SGD-Institute-W9.pdf') }}" target="_blank"
           class="list-group-item list-group-item-action">
            <i class="fa fa-file-text-o fa-fw" aria-hidden="true"></i> Request W-9
        </a>
        @if(!$order->isPaid())
            <a href="#" class="list-group-item list-group-item-action"
               onclick="event.preventDefault(); document.getElementById('delete-order-form').submit();">
                <i class="fa fa-trash fa-fw" aria-hidden="true"></i> Delete Order
            </a>

            <form id="delete-order-form" action="/orders/{{ $order->id }}" method="post" style="display: none;">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}
            </form>
        @endif
    </div>
    @endif
</div>