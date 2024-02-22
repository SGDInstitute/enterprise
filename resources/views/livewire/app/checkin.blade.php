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
                    <span class="text-white">Check In</span>
                </nav>
            </div>
        </div>
        <div class="container mx-auto flex justify-between px-8 py-4 md:px-0">
            <h1 class="text-xl text-white lg:text-4xl">{{ $event->name }} Check In</h1>
        </div>
    </section>

    <div class="mx-auto max-w-prose space-y-8 px-4 py-6 md:py-12">
        @include('livewire.app.checkin.' . $partial)
    </div>
</div>
