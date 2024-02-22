<div class="prose mx-auto space-y-4 dark:prose-light">
    <h1>Virtual Schedule</h1>

    @foreach ($items as $item)
        <div class="block rounded border border-gray-500 p-4">
            <h2 class="-mt-2">{{ $item->name }}</h2>
            <p>{{ $item->formattedDuration }}</p>
            <p>{{ $item->speaker }}</p>
            <div class="-mb-2">{!! markdown($item->description) !!}</div>
        </div>
    @endforeach
</div>
