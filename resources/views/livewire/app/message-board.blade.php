<div>
    <section class="bg-green-500">
        <div class="border-b border-green-600 px-8 py-4 md:px-0">
            <div class="container mx-auto">
                <nav class="hidden items-center text-sm font-medium leading-5 sm:flex">
                    <a
                        href="/events"
                        class="text-gray-200 transition duration-150 ease-in-out hover:text-white hover:underline"
                    >
                        Events
                    </a>
                    <svg
                        class="mx-2 h-5 w-5 shrink-0 text-gray-200"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"
                        />
                    </svg>
                    <a
                        href="/events/{{ $event->slug }}"
                        class="text-gray-200 transition duration-150 ease-in-out hover:text-white hover:underline"
                    >
                        {{ $event->name }}
                    </a>
                    <svg
                        class="mx-2 h-5 w-5 shrink-0 text-gray-200"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"
                        />
                    </svg>
                    <span class="text-white">Message Board</span>
                </nav>
            </div>
        </div>
        <div class="container mx-auto flex justify-between px-8 py-4 md:px-0">
            <h1 class="text-xl text-white lg:text-4xl">{{ $event->name }} Message Board</h1>
            {{ $this->createAction }}
        </div>
    </section>

    @if ($acceptedTerms)
        <div
            class="mx-auto max-w-2xl px-4 py-10 sm:px-0 lg:grid lg:max-w-7xl lg:grid-cols-4 lg:gap-x-8 lg:py-16 xl:grid-cols-5"
        >
            <aside
                x-data="{ show: false }"
                x-on:resize.debounce.window="show = window.innerWidth > 1024 ? true : false"
                x-init="show = window.innerWidth > 1024 ? true : false"
            >
                <div class="flex space-x-4">
                    <div class="w-full">
                        <label for="search" class="sr-only">Search</label>
                        <div class="relative" x-data="search">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg
                                    class="h-5 w-5 text-gray-400"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                    aria-hidden="true"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                            <x-bit.input.text
                                x-ref="searchInput"
                                class="w-full pl-10"
                                id="search"
                                wire:model.live="search"
                                placeholder="Search"
                                type="search"
                            />
                            <div class="absolute inset-y-0 right-0 hidden py-1.5 pr-1.5 lg:flex">
                                <kbd
                                    class="inline-flex items-center rounded border border-gray-200 px-2 font-sans text-sm font-medium text-gray-400 dark:border-gray-800"
                                >
                                    ⌘K
                                </kbd>
                            </div>
                        </div>
                    </div>
                    <button
                        @click="show = !show"
                        type="button"
                        class="-m-2 p-2 text-gray-400 hover:text-gray-500 sm:ml-6 lg:hidden"
                    >
                        <span class="sr-only">Filters</span>
                        <svg class="h-5 w-5" aria-hidden="true" viewBox="0 0 20 20" fill="currentColor">
                            <path
                                fill-rule="evenodd"
                                d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.973.206 7.372.601a.75.75 0 01.628.74v2.288a2.25 2.25 0 01-.659 1.59l-4.682 4.683a2.25 2.25 0 00-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 018 18.25v-5.757a2.25 2.25 0 00-.659-1.591L2.659 6.22A2.25 2.25 0 012 4.629V2.34a.75.75 0 01.628-.74z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </button>
                </div>
                <div x-show="show" class="space-y-6" x-collapse>
                    <fieldset class="mt-6">
                        <legend class="block text-sm font-medium text-gray-900 dark:text-gray-400">Tags</legend>
                        <div class="space-y-3 pt-6">
                            @foreach ($tags as $tag)
                                <div class="flex items-center" wire:key="tags-{{ $tag->id }}">
                                    <input
                                        id="tag-{{ $tag->id }}"
                                        value="{{ $tag->slug }}"
                                        wire:model.live="tagsFilter"
                                        type="checkbox"
                                        class="text-brand-600 focus:ring-brand-500 h-4 w-4 rounded border-gray-300 bg-white dark:border-gray-700 dark:bg-gray-800"
                                    />
                                    <label
                                        for="tag-{{ $tag->id }}"
                                        class="ml-3 text-sm text-gray-600 dark:text-gray-400"
                                    >
                                        {{ $tag->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </fieldset>
                </div>
            </aside>
            <section class="mt-6 space-y-6 lg:col-span-3 lg:mt-0 xl:col-span-4">
                <div class="grid grid-cols-1 gap-x-4 gap-y-16 lg:grid-cols-3">
                    @forelse ($records as $post)
                        <x-post wire:key="post-{{ $post->id }}" :event="$event" :post="$post" />
                    @empty
                        <li
                            wire:key="posts-empty"
                            class="relative col-span-4 block w-full rounded-lg border-2 border-dashed border-gray-300 p-12 text-center dark:border-gray-700"
                        >
                            <svg
                                class="mx-auto h-12 w-12 text-gray-400"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1"
                                stroke="currentColor"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13"
                                />
                            </svg>
                            <span class="mt-2 block font-medium text-gray-900 dark:text-gray-200">
                                No posts {{ $tagsFilter !== [] ? 'found with those filters' : 'found' }}
                            </span>
                        </li>
                    @endforelse
                </div>

                <div>
                    {{ $records->links() }}
                </div>
            </section>
        </div>
    @else
        <div class="prose mx-auto px-4 py-10 dark:prose-light sm:px-0 lg:py-16">
            <p>
                Welcome! The MBLGTACC Attendee Message Board is for those considering or planning to attend MBLGTACC to:
            </p>
            <ul>
                <li>
                    Coordinate rideshares, share a hotel room, and other ways to share the cost of attending MBLGTACC.
                    Ex: you coordinate a bus that picks up students at a few different schools and everyone goes in on
                    the price of booking the bus.
                </li>
            </ul>

            <p>This posting board is NOT for:</p>
            <ul>
                <li>
                    Contacting MBLGTACC staff with questions about the conference. For a prompt reply, contact us at
                    <a href="https://mblgtacc.org/contact">mblgtacc.org/contact</a>
                </li>
                <li>Selling, advertising or any other forms of self-promotion</li>
                <li>Content that is not directly related to MBLGTACC</li>
            </ul>

            <p class="text-sm italic">
                The Midwest Institute for Sexuality and Gender Diversity offers this posting board as a service to
                attendees for the above named purpose(s). We will review each submitted post before it is approved and
                published; however, we claim no responsibility for any inaccurate or misleading content.
            </p>

            <p class="text-sm italic">By using this board, you agree not to:</p>
            <ul class="text-sm italic">
                <li>
                    upload, post, display, distribute or otherwise publish on the board any material that is libelous,
                    defamatory, discriminatory, obscene, pornographic, harassing or abusive, infringes any copyright,
                    trademark, or other proprietary right, violates any right of publicity or privacy, or is otherwise
                    illegal;
                </li>
                <li>use the board to post deliberately disruptive repetitive messages;</li>
                <li>impersonate any other person or entity; or,</li>
                <li>
                    upload any information, files, code or other materials that contain viruses or are able to disrupt
                    or damage our sites, software, hardware or equipment or collect or use information about other users
                    for any purpose.
                </li>
            </ul>

            <p class="text-sm italic">
                You acknowledge that messages and any other content you post or submit are not private or confidential.
            </p>

            <p class="text-sm italic">
                By using this service, you agree that the Midwest Institute for Sexuality and Gender Diversity is not
                liable for any damages arising out of or in connection with using the board.
            </p>

            <p class="text-sm italic">
                If you have questions or concerns about the content or use of this board, please contact us.
            </p>

            {{ $this->acceptAction }}
        </div>
    @endif

    <x-filament-actions::modals />
</div>
