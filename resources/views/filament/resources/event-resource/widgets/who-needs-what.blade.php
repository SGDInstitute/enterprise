<x-filament-widgets::widget>
    <x-filament::section collapsible collapsed>
        <x-slot name="heading">Who Needs What</x-slot>

        <div class="flex gap-x-3 items-end pb-4">
            {{ $this->form }}

            <x-filament::button wire:click="run">Run</x-filament::button>
        </div>
        <div class="fi-section-content-ctn border-t pt-4 border-gray-200 dark:border-white/10">
            <table class="fi-ta-table w-full table-auto divide-y divide-gray-200 text-start dark:divide-white/5">
                <tbody class="divide-y divide-gray-200 dark:divide-white/5">
                    @forelse ($report as $item)
                    <tr>
                        <td>{{ $item->user->name }} <small>({{ $item->user->pronouns }})</small></td>
                        <td>
                            <button
                                x-on:click="
                                    window.navigator.clipboard.writeText(@js($item->user->email))
                                    $tooltip('Email copied')
                                "
                                class="hover:underline"
                            >
                                {{ $item->user->email }}
                            </button>
                        </td>
                        <td>
                            <x-filament::link :href="route('filament.admin.resources.tickets.view', ['record' => $item->id])">
                                View
                            </x-filament::link>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3">{{ $hasRun ? 'No tickets found' : '' }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-filament::section>

</x-filament-widgets::widget>
