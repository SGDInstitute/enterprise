<div class="card">
    <div class="card-top text-white"
         style="background-image: linear-gradient(rgba(0, 0, 0, 0.55),rgba(0, 0, 0, 0.55)), url({{ Storage::url($order->event->image) }})">
        @if(isset($order->event->logo_light))
            <img src="{{ Storage::url($order->event->logo_light) }}" alt="{{ $order->event->title }} Logo"
                 style="width: 75%; margin-bottom: .5em;">
        @else
            <h4 class="card-title">{{ $order->event->title }}</h4>
        @endif
        <ul class="fa-ul list-reset ml-6 mt-2">
            <li>
                <span class="fa-li"><i class="fal fa-clock"></i></span>
                {{ $order->event->formatted_start }} - {{ $order->event->formatted_end }}</li>
            <li>
                <span class="fa-li"><i class="fal fa-map-marker"></i></span>
                {{ $order->event->place }} {{ $order->event->location }}
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
                <a id="pay" class="list-group-item list-group-item-action" data-toggle="collapse"
                   href="#collapseExample">
                    <i class="fal fa-fw fa-money-bill"></i> Pay Now
                </a>
                <div class="collapse list-sub-group" id="collapseExample">
                    <pay-with-card :order="{{ $order }}"
                                   stripe_key="{{ $order->event->getPublicKey() }}"></pay-with-card>
                    <pay-with-check :order="{{ $order }}"></pay-with-check>
                </div>
            @endif
            <invoice-button id="invoice" :order="{{ $order }}"></invoice-button>
            <a href="{{ asset('/documents/SGD-Institute-W9.pdf') }}" target="_blank"
               class="list-group-item list-group-item-action">
                <i class="fal fa-fw fa-file-alt"></i> Request W-9
            </a>
        </div>
    @endif
</div>

@if(!$order->isPaid())
    <a href="#" class="list-group-item list-group-item-action rounded bg-red-lightest text-red-darkest hover:bg-red-lighter hover:text-red-darkest mt-6"
       onclick="event.preventDefault(); document.getElementById('delete-order-form').submit();">
        <i class="fal fa-fw fa-trash-alt"></i> Delete Order
    </a>

    <form id="delete-order-form" action="/orders/{{ $order->id }}" method="post" style="display: none;">
        {{ method_field('DELETE') }}
        {{ csrf_field() }}
    </form>
@endif