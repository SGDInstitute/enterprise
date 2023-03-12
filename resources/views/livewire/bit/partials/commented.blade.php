<div class="relative flex items-start space-x-3">
    <div class="relative">
        @isset($activity->causer)
        <img class="flex items-center justify-center w-10 h-10 bg-gray-400 rounded-full ring-8 ring-gray-100 dark:ring-gray-700" src="{{ $activity->causer->profile_photo_url }}" alt="{{ $activity->causer->name }}">
        @else
        <div class="flex items-center justify-center w-10 h-10 bg-gray-400 rounded-full ring-8 ring-gray-100 dark:ring-gray-700"></div>
        @endif

        <span class="absolute -bottom-0.5 -right-1 bg-gray-100 dark:bg-gray-700 rounded-tl px-0.5 py-px">
            <x-heroicon-s-chat-alt class="w-5 h-5 text-gray-400" />
        </span>
    </div>
    <div class="flex-1 min-w-0">
        <div>
            @if (isset($activity['properties']['internal']) && $activity['properties']['internal'])
            <x-bit.badge class="float-right">Internal</x-bit.badge>
            @endif
            <div class="text-sm">
                @isset($activity->causer)
                <a href="#" class="font-medium text-gray-900 dark:text-gray-200">{{ $activity->causer->name }}</a>
                @endif
            </div>
            <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">
                Commented {{ $activity->created_at->diffForHumans() }}
            </p>
        </div>
        <div class="mt-2 text-sm text-gray-700 dark:text-gray-300">
            <p>
                {!! nl2br($activity['properties']['comment']) !!}
            </p>
        </div>
    </div>
</div>
