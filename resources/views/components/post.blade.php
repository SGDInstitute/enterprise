<article class="flex flex-col items-start justify-between bg-white shadow-md dark:bg-gray-800 p-4">
    <div class="flex items-center gap-x-4 text-xs">
        <time datetime="{{ $post->created_at }}" class="text-gray-500">{{ $post->created_at->format('M j, Y') }}</time>
        @foreach ($post->tags as $tag)
        <x-bit.badge>{{ $tag->name }}</x-bit.badge>
        @endforeach
    </div>
    <div class="group relative">
        <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
            {{ $post->title }}
        </h3>
        <div>{!! $post->content !!}</div>
    </div>
    <div class="relative mt-8 flex items-center gap-x-4">
        <div class="text-sm leading-6">
            <p class="font-semibold text-gray-900">
                {{ $post->user->formattedName }}
            </p>
            <p class="text-gray-600">{{ $post->user->email }}</p>
        </div>
    </div>
</article>