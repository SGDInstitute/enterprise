<article class="flex flex-col items-start justify-between bg-white p-4 shadow-md dark:bg-gray-800">
    <div class="flex items-center gap-x-4 text-xs">
        <time datetime="{{ $post->created_at }}" class="dark:text-grat-400 text-gray-500">
            {{ $post->created_at->format('M j, Y') }}
        </time>
        @foreach ($post->tags as $tag)
            <x-bit.badge>{{ $tag->name }}</x-bit.badge>
        @endforeach
    </div>
    <div class="relative">
        <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900 dark:text-gray-200">
            {{ $post->title }}
        </h3>
        <div class="prose dark:prose-light">{!! $post->content !!}</div>
    </div>
    <div class="relative mt-8 flex items-center gap-x-4">
        <div class="text-sm leading-6">
            <p class="font-semibold text-gray-900 dark:text-gray-200">
                {{ $post->user->formattedName }}
            </p>
            <p class="text-gray-600 dark:text-gray-400">{{ $post->user->email }}</p>
        </div>
    </div>
</article>
