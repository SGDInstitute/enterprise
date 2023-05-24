<li class="py-4 px-6 bg-white dark:bg-gray-800 shadow flex items-center">
    <div class="w-1/2 space-y-2">
        <div>
            @foreach ($thread->tags as $tag)
            <x-ui.badge>{{ $tag->name }}</x-ui.badge>
            @endforeach
        </div>
        <div>
            <a href="{{ route('threads.show', [$event, $thread]) }}" class="font-bold text-xl hover:underline">{{ $thread->title }}</a>
        </div>
    </div>
    <div class="w-1/4">{{ $thread->user->name }} {{ $thread->user->pronouns ? "($thread->user->pronouns)" : '' }}</div>
    <div class="w-1/4 text-right">{{ $thread->created_at->format('m/d/Y') }}</div>
</li>