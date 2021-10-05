<div class="space-y-8">
    <div class="prose dark:prose-light">
        <h1>Bulletin Board</h1>
    </div>

    <div class="space-y-4">
        @foreach($event->publishedBulletins->sortByDesc('published_at') as $bulletin)
        <x-bit.bulletin :bulletin="$bulletin" />
        @endforeach
    </div>
</div>
