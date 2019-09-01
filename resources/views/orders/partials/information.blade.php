<div class="bg-white shadow rounded-lg overflow-hidden">
    @if($order->event->image)
    <div class="w-full h-48 bg-cover bg-center" style="background-image: url({{ Storage::url($order->event->image) }})">
        <img src="{{ Storage::url($order->event->image) }}" class="hidden" alt="{{ $order->event->title }} Image">
    </div>
    @else
    <div class="w-full h-48 bg-cover bg-center" style="background-image: url(https://tailwindcss.com/img/card-top.jpg)">
        <img src="https://tailwindcss.com/img/card-top.jpg" class="hidden" alt="{{ $order->event->title }} Image">
    </div>
    @endif
    <div class="px-6 py-4">
        @if(isset($order->event->logo_dark))
        <img src="{{ Storage::url($order->event->logo_dark) }}" alt="{{ $order->event->title }} Logo" style="width: 75%; margin-bottom: .5em;">
        @else
        <h2 class="font-bold text-xl mb-2">{{ $order->event->title }}</h2>
        @endif
        <ul class="fa-ul list-reset ml-6">
            <li>
                <span class="fa-li"><i class="fal fa-clock"></i></span>
                {{ $order->event->formatted_start }} - {{ $order->event->formatted_end }}, {{ $order->event->end->format('Y') }}</li>
            <li>
                <span class="fa-li"><i class="fal fa-map-marker-alt"></i></span>
                {{ $order->event->place }} {{ $order->event->location }}
            </li>
        </ul>

        <h3 class="text-2xl text-gray-700 font-semibold my-4">{{ '$' . number_format($order->amount/100, 2) }}</h3>
        <p class="text-gray-700 leading-normal mb-6">Number of {{ Str::plural($order->event->ticket_string) }} Filled
            <span class="float-right">
                {{ $order->tickets()->filled()->count() }} of {{ $order->tickets->count() }}
            </span>
        </p>

        @if($order->isPaid())
        <p class="leading-normal text-gray-700">Confirmation
            Number:<br> {{ join('-', str_split($order->confirmation_number, 4)) }}</p>
        @if(Auth::user()->can('update', $order))
        @if($order->isCard())
        <p class="leading-normal text-gray-700">Billed to Card: ****-****-****-{{ $order->receipt->card_last_four }}</p>
        @else
        <p class="leading-normal text-gray-700">Check Number: {{ $order->receipt->transaction_id }}</p>
        @endif
        @endif
        @endif
    </div>
    @if(Auth::user()->can('update', $order))
    <div>
        @if($order->isPaid())
        <receipt-button :order="{{ $order }}" classes="w-full text-left block px-6 py-4 border-t border-b border-gray-300 hover:bg-gray-100"></receipt-button>
        @else
        <a id="pay" class="block px-6 py-4 border-t border-b border-gray-300 hover:bg-gray-100" data-toggle="collapse" href="#collapseExample">
            <i class="fal fa-fw fa-money-bill mr-4"></i> Pay Now
        </a>
        <div class="collapse block" id="collapseExample">
            <pay-with-card :order="{{ $order }}" stripe_key="{{ $order->event->getPublicKey() }}" classes="w-full block text-left px-6 py-4 border-b border-gray-300 hover:bg-gray-100"></pay-with-card>
            <pay-with-check :order="{{ $order }}" classes="w-full block text-left px-6 py-4 border-b border-gray-300 hover:bg-gray-100"></pay-with-check>
        </div>
        @endif
        @if($order->invoice)
        <view-invoice-button id="invoice" :order="{{ $order }}" classes="w-full text-left block px-6 py-4 border-b border-gray-300 hover:bg-gray-100"></view-invoice-button>
        @endif
        <invoice-form id="invoice" :order="{{ $order }}" classes="w-full text-left block px-6 py-4 border-b border-gray-300 hover:bg-gray-100"></invoice-form>
        <a href="{{ asset('/documents/SGD-Institute-W9.pdf') }}" target="_blank" class="block px-6 py-4 border-gray-300 hover:bg-gray-100">
            <i class="fal fa-fw fa-file-alt mr-4"></i> Request W-9
        </a>
    </div>
    @endif
</div>