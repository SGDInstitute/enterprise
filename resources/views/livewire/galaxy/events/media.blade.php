<div>
    <div class="grid grid-cols-4 gap-4">
        <div>
            <img src="{{ $iconSrc }}" alt="{{ $event->name }}">
        </div>
        <div class="col-span-3">
            <x-bit.panel>
                <x-bit.panel.heading class="flex items-center justify-between">
                    <h2 class="text-lg font-bold leading-6 text-gray-900 dark:text-gray-200">Icon</h2>
                    <div>
                        <x-bit.button.primary type="button" wire:click="save">Save</x-bit.button.primary>
                    </div>
                </x-bit.panel.heading>
                <x-bit.panel.body>
                    <p class="mb-1 text-sm leading-5 text-gray-500 dark:text-gray-400">Image used when {{ $event->name }} is viewed in a list of other events.</p>
                    <x-media-library-attachment name="icon" rules="mimes:png,jpeg|max:500" />
                </x-bit.panel.body>
            </x-bit.panel>
        </div>
    </div>
</div>
