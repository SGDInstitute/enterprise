<div>
    <section class="bg-green-500">
        <div class="px-8 py-4 border-b border-green-600 md:px-0">
            <div class="container mx-auto">
                <nav class="items-center hidden text-sm font-medium leading-5 sm:flex">
                    <a href="/events" class="text-gray-200 transition duration-150 ease-in-out hover:text-white hover:underline">Events</a>
                    <svg class="w-5 h-5 mx-2 text-gray-200 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        clip-rule="evenodd" />
                    </svg>
                    <a href="/events/{{ $event->slug }}" class="text-gray-200 transition duration-150 ease-in-out hover:text-white hover:underline">{{ $event->name }}</a>
                    <svg class="w-5 h-5 mx-2 text-gray-200 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        clip-rule="evenodd" />
                    </svg>
                    <span class="text-white">Message Board</span>
                </nav>
            </div>
        </div>
        <div class="container px-8 py-4 mx-auto md:px-0 flex justify-between">
            <h1 class="text-xl text-white lg:text-4xl">{{ $event->name }} Message Board</h1>
            <x-bit.button.flat.white :href="route('posts.create', $event)">Create a Post</x-bit.button.flat.white>
        </div>
    </section>
    <x-ui.container class="lg:grid lg:grid-cols-4 lg:gap-x-8 xl:grid-cols-5">
        <aside x-data="{show: false}"
            x-on:resize.debounce.window="show = (window.innerWidth > 1024) ? true : false"
            x-init="show = (window.innerWidth > 1024) ? true : false">
            <div class="flex space-x-4">
                <x-ui.search />
                <button @click="show = !show" type="button" class="-m-2 p-2 text-gray-400 hover:text-gray-500 sm:ml-6 lg:hidden">
                    <span class="sr-only">Filters</span>
                    <svg class="h-5 w-5" aria-hidden="true" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.973.206 7.372.601a.75.75 0 01.628.74v2.288a2.25 2.25 0 01-.659 1.59l-4.682 4.683a2.25 2.25 0 00-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 018 18.25v-5.757a2.25 2.25 0 00-.659-1.591L2.659 6.22A2.25 2.25 0 012 4.629V2.34a.75.75 0 01.628-.74z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
            <div x-show="show" class="space-y-6" x-collapse>
                <fieldset class="mt-6">
                    <legend class="block text-sm font-medium text-gray-900 dark:text-gray-400">Tags</legend>
                    <div class="space-y-3 pt-6">
                        @foreach ($tags as $tag)
                        <div class="flex items-center" wire:key="tags-{{ $tag->id }}">
                            <input id="tag-{{ $tag->id }}" value="{{ $tag->slug }}" wire:model="tagsFilter" type="checkbox" class="h-4 w-4 rounded border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-brand-600 focus:ring-brand-500" />
                            <label for="tag-{{ $tag->id }}" class="ml-3 text-sm text-gray-600 dark:text-gray-400">{{ $tag->name }}</label>
                        </div>
                        @endforeach
                    </div>
                </fieldset>
            </div>
        </aside>
        <section class="mt-6 lg:col-span-3 lg:mt-0 xl:col-span-4 space-y-6">
            <ul class="space-y-4">
                @forelse ($records as $post)
                <x-post wire:key="post-{{ $post->id }}" :event=$event :post=$post />
                @empty
                <li wire:key="posts-empty" class="col-span-4 relative block w-full rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-700 p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" />
                    </svg>
                    <span class="mt-2 block font-medium text-gray-900 dark:text-gray-200">No posts {{ $tagsFilter !== [] ? 'found with those filters' : 'found' }}</span>
                </li>
                @endforelse
            </ul>

            <div>
                {{ $records->links() }}
            </div>
        </section>
    </x-ui.container>
</div>
