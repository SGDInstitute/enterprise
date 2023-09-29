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
                    <span class="text-white">Message Board</span>
                </nav>
            </div>
        </div>
        <div class="container flex justify-between px-8 py-4 mx-auto md:px-0">
            <h1 class="text-xl text-white lg:text-4xl">{{ $event->name }} Volunteer Opportunities</h1>
        </div>
    </section>

    <div class="max-w-2xl px-4 py-10 mx-auto">
        <div class="bg-white dark:bg-gray-800 p-6">
            <form wire:submit="signup">
                {{ $this->form }}

                <x-bit.button.flat.primary type="submit" class="mt-8">
                    {{ __('Sign up') }}
                </x-bit.button.flat.primary>
            </form>
        </div>
    </div>
</div>
