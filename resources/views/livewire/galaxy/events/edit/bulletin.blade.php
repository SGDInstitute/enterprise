<div class="grid grid-cols-1 gap-8 md:grid-cols-2">
    <div>
        <h2 class="mb-8 text-xl font-semibold text-gray-900 dark:text-gray-200">Bulletin Board Feed</h2>

        <div class="space-y-2">
            @forelse ($event->bulletins->sortByDesc('published_at') as $bulletin)
            <x-bit.bulletin :bulletin="$bulletin" />
            @empty
            <span class="text-sm italic text-gray-600 dark:text-gray-400">No bulletins at this time</span>
            @endforelse
        </div>
    </div>
    <form wire:submit.prevent="add">
        <x-bit.panel>
            <x-bit.panel.body class="space-y-8 divide-y divide-gray-200 dark:divide-gray-900">
                <div class="space-y-2">
                    <x-bit.input.group for="title" label="Title">
                        <x-bit.input.text id="title" class="block w-full mt-1" type="text" name="title" wire:model="bulletin.title" />
                    </x-bit.input.group>
                    <x-bit.input.group for="content" label="Content">
                        <x-bit.input.markdown id="content" class="block w-full mt-1" type="text" name="content" wire:model="bulletin.content" />
                    </x-bit.input.group>
                    <x-bit.input.group for="published_at" label="Publish At">
                        <x-bit.input.date-time class="block w-full mt-1" id="start" name="published_at" wire:model="formattedPublish" />
                    </x-bit.input.group>

                    <div class="pt-4">
                        <x-form.checkbox label="Notify Users" id="notify-users" wire:model="bulletin.notify" />
                    </div>
                </div>
            </x-bit.panel.body>

            <x-bit.panel.footer>
                @if ($formChanged)
                <x-bit.button.round.primary type="submit">Save</x-bit.button.round.primary>
                <x-ui.badge color="indigo" class="ml-4">
                    Unsaved Changes
                </x-ui.badge>
                @else
                <x-bit.button.round.primary type="submit" disabled>Save</x-bit.button.round.primary>
                @endif
            </x-bit.panel.footer>
        </x-bit.panel>
    </form>
</div>
