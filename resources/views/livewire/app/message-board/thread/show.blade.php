<div>
    <section class="bg-green-500">
        <div class="px-8 py-4 border-b border-green-600 md:px-0">
            <div class="container mx-auto">
                <nav class="items-center hidden text-sm font-medium leading-5 sm:flex">
                    <a href="/events" class="text-gray-200 transition duration-150 ease-in-out hover:text-white hover:underline">Events</a>
                    <svg class="w-5 h-5 mx-2 text-gray-200 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    <a href="/events/{{ $event->slug }}" class="text-gray-200 transition duration-150 ease-in-out hover:text-white hover:underline">{{ $event->name }}</a>
                    <svg class="w-5 h-5 mx-2 text-gray-200 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    <a href="/events/{{ $event->slug }}/message-board" class="text-gray-200 transition duration-150 ease-in-out hover:text-white hover:underline">Message Board</a>
                    <svg class="w-5 h-5 mx-2 text-gray-200 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-white">Thread</span>
                </nav>
            </div>
        </div>
        <div class="container px-8 py-4 mx-auto md:px-0 flex justify-between">
            <h1 class="text-xl text-white lg:text-4xl">{{ $thread->title }}</h1>
        </div>
    </section>
    <x-ui.container  class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <x-ui.card class="md:col-span-3">
            <div class="flex items-center justify-between px-4 py-5 space-x-4 bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700 sm:px-6">
                <div class="flex items-center space-x-4">
                    <x-ui.avatar :search="$thread->user->email" class="w-12 h-12 rounded-full" />
                    <div>
                        <div>
                            <span class="text-xl mr-2">{{ $thread->user->name }}</span>
                            <span>({{ $thread->user->pronouns }})</span>
                        </div>
                        <div>posted {{ $thread->created_at->diffForHumans() }}</div>
                    </div>
                </div>

                <div>
                    @foreach($thread->tags as $tag)
                    <x-ui.badge>{{ $tag->name }}</x-ui.badge>
                    @endforeach
                </div>
            </div>

            <div class="px-8 py-6 prose dark:prose-light max-w-none prose-lg">
                {!! $thread->content !!}
            </div>
        </x-ui.card>
    </x-ui.container>
</div>