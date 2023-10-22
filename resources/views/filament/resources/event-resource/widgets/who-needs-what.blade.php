<x-filament-widgets::widget>
    <x-filament::section>
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
                        <td>{{ $item->user->email }}</td>
                        <td>{{ $item->id }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3">No tickets found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
