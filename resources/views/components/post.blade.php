<li {{ $attributes->merge(['class' => 'py-4 px-6 bg-white dark:bg-gray-800 shadow flex items-center']) }}>
    <div class="w-1/2 space-y-2">
        <div>
            @foreach ($post->tags as $tag)
            <x-bit.badge>{{ $tag->name }}</x-bit.badge>
            @endforeach
        </div>
        <div>
            <a href="{{ route('posts.show', [$event, $post]) }}" class="text-xl font-bold hover:underline">{{ $post->title }}</a>
        </div>
    </div>
    <div class="w-1/4">{{ $post->user->name }} {{ $post->user->pronouns ? "($post->user->pronouns)" : '' }}</div>
    <div class="w-1/4 text-right">{{ $post->created_at->format('m/d/Y') }}</div>
</li>