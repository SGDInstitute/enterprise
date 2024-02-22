<div class="pointer-events-none fixed right-0 top-0 z-50 pr-6 pt-6">
    @foreach ($notifications as $notification)
        <x-bit.notification :notification="$notification" :key="$loop->index" />
    @endforeach
</div>
