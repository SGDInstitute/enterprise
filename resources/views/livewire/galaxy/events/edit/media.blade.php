<div>
    <div class="grid grid-cols-3 gap-4">
        <div>
            <x-bit.event :event="$event" :logo="$logoSrc" :background="$backgroundSrc" />
        </div>
        <div class="col-span-2">
            <x-bit.panel>
                <x-bit.panel.heading class="flex items-center justify-between">
                    <h2 class="text-lg font-bold leading-6 text-gray-900 dark:text-gray-200">Media</h2>
                    <div>
                        <x-bit.button.round.primary type="button" wire:click="save">Save</x-bit.button.round.primary>
                    </div>
                </x-bit.panel.heading>
                <x-bit.panel.body>
                    <div class="space-y-6">
                        <div>
                            <p class="mb-1 text-sm leading-5 text-gray-500 dark:text-gray-400">Logo used when {{ $event->name }} is viewed in a list of other events as well as in navbar.</p>
                        </div>
                        <div>
                            <p class="mb-1 text-sm leading-5 text-gray-500 dark:text-gray-400">Background used when {{ $event->name }} is viewed in a list of other events.</p>
                        </div>
                    </div>
                </x-bit.panel.body>
            </x-bit.panel>
        </div>
    </div>
</div>
