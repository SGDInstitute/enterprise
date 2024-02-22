<div>
    <div class="mt-5 flex-col space-y-4">
        <div class="md:flex md:justify-between">
            <div class="flex flex-col space-y-4 md:w-1/2 md:flex-row md:items-end md:space-x-4">
                <x-bit.input.group for="search" label="Search" sr-only>
                    <x-bit.input.text
                        id="search"
                        class="mt-1 block w-full"
                        type="text"
                        name="search"
                        placeholder="Search forms..."
                        wire:model.live="filters.search"
                    />
                </x-bit.input.group>
            </div>
            <div class="mt-4 flex items-end space-x-4 md:mt-0">
                <x-bit.data-table.per-page />
                <x-bit.button.round.secondary :href="route('galaxy.forms.create')" class="flex items-center space-x-2">
                    <x-heroicon-o-plus class="h-4 w-4 text-gray-400 dark:text-gray-300" />
                    <span>Create</span>
                </x-bit.button.round.secondary>
            </div>
        </div>

        <x-bit.table>
            <x-slot name="head">
                <x-bit.table.heading
                    sortable
                    wire:click="sortBy('name')"
                    :direction="$sortField === 'name' ? $sortDirection : null"
                >
                    Name
                </x-bit.table.heading>
                <x-bit.table.heading
                    sortable
                    wire:click="sortBy('type')"
                    :direction="$sortField === 'type' ? $sortDirection : null"
                >
                    Type
                </x-bit.table.heading>
                <x-bit.table.heading>Responses</x-bit.table.heading>
                <x-bit.table.heading
                    sortable
                    wire:click="sortBy('start')"
                    :direction="$sortField === 'start' ? $sortDirection : null"
                >
                    Start
                </x-bit.table.heading>
                <x-bit.table.heading
                    sortable
                    wire:click="sortBy('end')"
                    :direction="$sortField === 'end' ? $sortDirection : null"
                >
                    End
                </x-bit.table.heading>
                <x-bit.table.heading />
            </x-slot>

            <x-slot name="body">
                @forelse ($forms as $form)
                    <x-bit.table.row wire:key="row-{{ $form->id }}">
                        <x-bit.table.cell><div class="w-64 truncate">{{ $form->name }}</div></x-bit.table.cell>
                        <x-bit.table.cell>{{ $form->type }}</x-bit.table.cell>
                        <x-bit.table.cell>{{ $form->responses_count }}</x-bit.table.cell>
                        <x-bit.table.cell>
                            {{ $form->formattedStart }} {{ $form->formattedTimezone }}
                        </x-bit.table.cell>
                        <x-bit.table.cell>{{ $form->formattedEnd }} {{ $form->formattedTimezone }}</x-bit.table.cell>
                        <x-bit.table.cell class="flex space-x-1">
                            @if ($form->type === 'survey')
                                <x-bit.button.link size="py-1 px-2" href="{{ route('galaxy.surveys.show', $form) }}">
                                    <x-heroicon-o-eye class="h-4 w-4 text-green-500 dark:text-green-400" />
                                </x-bit.button.link>
                            @else
                                <x-bit.button.link
                                    size="py-1 px-2"
                                    href="{{ route('galaxy.responses', ['form' => $form->id]) }}"
                                >
                                    <x-heroicon-o-eye class="h-4 w-4 text-green-500 dark:text-green-400" />
                                </x-bit.button.link>
                            @endif
                            <x-bit.button.link size="py-1 px-2" href="{{ route('galaxy.forms.edit', $form) }}">
                                <x-heroicon-o-cog class="h-4 w-4 text-green-500 dark:text-green-400" />
                            </x-bit.button.link>
                        </x-bit.table.cell>
                    </x-bit.table.row>
                @empty
                    <x-bit.table.row>
                        <x-bit.table.cell colspan="7">
                            <div class="flex items-center justify-center space-x-2">
                                <x-heroicon-o-calendar class="h-8 w-8 text-gray-400" />
                                <span class="py-8 text-xl font-medium text-gray-500 dark:text-gray-400">
                                    No forms found...
                                </span>
                            </div>
                        </x-bit.table.cell>
                    </x-bit.table.row>
                @endforelse
            </x-slot>
        </x-bit.table>

        <div>
            {{ $forms->links() }}
        </div>
    </div>
</div>
