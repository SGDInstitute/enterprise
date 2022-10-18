<div class="space-y-8">
    <div class="prose dark:prose-light">
        <h1>Bulletin Board</h1>
    </div>

    <div class="space-y-4">
        @forelse ($bulletins as $bulletin)
            <x-bit.bulletin :bulletin="$bulletin" />
        @empty
            <p class="text-gray-700 dark:text-gray-400">No notifications at the moment.</p>
        @endforelse
    </div>
</div>
