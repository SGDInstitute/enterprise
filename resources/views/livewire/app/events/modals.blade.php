<div>
    <section>
        <div class="block bg-green-500 shadow transition duration-150 ease-in-out">
            <div
                class="h-48 bg-gray-50 bg-cover bg-center dark:bg-gray-850"
                style="background-image: url({{ $event->backgroundUrl }})"
            >
                <img src="{{ $event->backgroundUrl }}" alt="{{ $event->name }}" class="sr-only" />
            </div>
            <div class="mx-4 -mt-8 space-y-2 bg-green-500 px-4 py-2 transition duration-150 ease-in-out">
                <p class="text-2xl text-white">{{ $event->name }}</p>
                @isset($event->subtitle)
                    <p class="text-gray-200">{{ $event->subtitle }}</p>
                @endif

                <p class="text-italic text-sm text-gray-200">{{ $event->formattedDuration }}</p>
                <p class="text-italic text-sm text-gray-200">{{ $event->formattedLocation }}</p>
            </div>
        </div>
        <div class="divide-y divide-gray-200 shadow dark:divide-gray-900">
            <button
                wire:click="showPolicyModal('description')"
                class="flex w-full items-center space-x-4 bg-gray-50 px-6 py-4 text-gray-900 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700"
            >
                <x-heroicon-o-calendar class="h-6 w-6 text-gray-600 dark:text-gray-400" />
                <span>Event Description</span>
            </button>
            @foreach ($event->settings->tabs ?? [] as $modal)
                @isset($modal['slug'])
                    <button
                        wire:click="showPolicyModal('{{ $modal['slug'] }}')"
                        class="flex w-full items-center space-x-4 bg-gray-50 px-6 py-4 text-gray-900 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700"
                    >
                        <x-dynamic-component
                            :component="$modal['icon']"
                            class="h-6 w-6 text-gray-600 dark:text-gray-400"
                        />
                        <span>{{ $modal['name'] }}</span>
                    </button>
                @endif
            @endforeach

            @if ($event->settings->get('has_volunteers', false))
                <a
                    href="{{ route('app.volunteer', $event) }}"
                    class="flex w-full items-center space-x-4 bg-gray-50 px-6 py-4 text-gray-900 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700"
                >
                    <x-heroicon-o-sparkles class="h-6 w-6 text-gray-600 dark:text-gray-400" />
                    <span>Volunteer Opportunities</span>
                </a>
            @endif

            @if (auth()->check() &&auth()->user()->hasTicketFor($event))
                <a
                    href="{{ route('message-board', $event) }}"
                    class="flex w-full items-center space-x-4 bg-gray-50 px-6 py-4 text-gray-900 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700"
                >
                    <x-heroicon-o-chat-bubble-left-right class="h-6 w-6 text-gray-600 dark:text-gray-400" />
                    <span>Message Board</span>
                </a>
            @endif
        </div>
    </section>

    <x-bit.modal.dialog wire:model.live="showModal" max-width="2xl">
        <x-slot name="title">{{ $modalTitle ?? '' }}</x-slot>

        <x-slot name="content">
            <div class="prose dark:prose-light">
                {!! $modalContent ?? '' !!}
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-bit.button.flat.secondary size="xs" wire:click="resetModal">Close</x-bit.button.flat.secondary>
        </x-slot>
    </x-bit.modal.dialog>
</div>
