@if(Auth::user()->can('update', $order))
<div class="flex border rounded mb-8 bg-gray-100">
    <div class="flex-1 p-4 flex items-center border-r">
        <span class="fa-stack mr-4">
            <i class="fas fa-circle fa-stack-2x text-mint-500"></i>
            <i class="fas fa-check fa-stack-1x fa-inverse"></i>
        </span>
        <span>Create Order</span>
    </div>
    <div class="flex-1 p-4 flex items-center justify-between border-r">
        <div class="flex items-center">
            <span class="fa-stack mr-4">
                <i class="fas fa-circle fa-stack-2x {{ $order->isPaid() ? 'text-mint-500' : 'text-gray-500' }}"></i>
                @if($order->isPaid())
                <i class="fas fa-check fa-stack-1x fa-inverse"></i>
                @endif
            </span>
            <span>Pay Now</span>
        </div>
        <pay-tour></pay-tour>
    </div>
    <div class="flex-1 p-4 flex items-center justify-between border-r">
        <div class="flex items-center">
            <span class="fa-stack mr-4">
                <i class="fas fa-circle fa-stack-2x {{ $order->tickets()->filled()->count() === $order->tickets->count() ? 'text-mint-500' : 'text-gray-500' }}"></i>
                @if($order->tickets()->filled()->count() === $order->tickets->count())
                <i class="fas fa-check fa-stack-1x fa-inverse"></i>
                @endif
            </span>
            <span>Tell Us Who's Coming</span>
        </div>
        <invite-tour></invite-tour>
    </div>
    <div class="flex-1 p-4 flex items-center justify-between">
        <div class="flex items-center">
            <span class="fa-stack mr-4">
                <i class="fas fa-circle fa-stack-2x text-gray-500"></i>
            </span>
            <span>Get Ready to Come!</span>
        </div>
        <a href="https://mblgtacc.org/2020/lodging-transportation" target="_blank" class="text-grey">
            <i class="fa fa-info"></i>
        </a>
    </div>
</div>
@endif