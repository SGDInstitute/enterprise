<div>
    <section>
        <div class="block transition duration-150 ease-in-out bg-green-500 shadow">
            <div class="bg-center bg-cover h-48 bg-gray-50 dark:bg-gray-850" style="background-image: url({{ $event->backgroundUrl }});">
                <img src="{{ $event->backgroundUrl }}" alt="{{ $event->name }}" class="sr-only">
            </div>
            <div class="px-4 py-2 mx-4 -mt-8 transition duration-150 ease-in-out bg-green-500 space-y-2">
                <p class="text-2xl text-white">{{ $event->name }}</p>
                @isset($event->subtitle)
                <p class="text-gray-200">{{ $event->subtitle }}</p>
                @endif
                <p class="text-sm text-gray-200 text-italic">{{ $event->formattedDuration }}</p>
                <p class="text-sm text-gray-200 text-italic">{{ $event->formattedLocation }}</p>
            </div>
        </div>
        <div class="divide-y divide-gray-200 shadow dark:divide-gray-900">
            <button wire:click="showPolicyModal('description')" class="flex items-center w-full px-6 py-4 space-x-4 text-gray-900 bg-gray-50 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 dark:text-gray-200">
                <x-heroicon-o-calendar class="w-6 h-6 text-gray-600 dark:text-gray-400" />
                <span>Event Description</span>
            </button>
            @foreach ($event->settings->tabs ?? [] as $modal)
            @isset($modal['slug'])
            <button wire:click="showPolicyModal('{{ $modal['slug'] }}')" class="flex items-center w-full px-6 py-4 space-x-4 text-gray-900 bg-gray-50 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 dark:text-gray-200">
                <x-dynamic-component :component="$modal['icon']" class="w-6 h-6 text-gray-600 dark:text-gray-400" />
                <span>{{ $modal['name'] }}</span>
            </button>
            @endif
            @endforeach
        </div>
    </section>

    <x-bit.modal.dialog wire:model="showModal" max-width="2xl">
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
