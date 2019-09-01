<a href="/orders/{{ $order->id }}" class="transition block w-80 mx-4 bg-gray-100 hover:bg-white rounded-lg overflow-hidden shadow hover:shadow-lg">
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
            <li>
                <span class="fa-li"><i class="fal fa-ticket"></i></span>
                {{ $order->tickets->count() }} Tickets
            </li>
        </ul>
        <div class="flex justify-between mt-4">
            @if($order->isPaid())
            <h4 class="text-lg font-semibold">PAID</h4>
            @endif

            <h4 class="text-lg">{{ '$' . number_format($order->amount/100, 2) }}</h4>
        </div>
    </div>
</a>