<div>
    <div class="flex-col mt-5 space-y-4" x-data="{ showAdvanced: false }">
        <div class="md:flex md:justify-between">
            <div class="flex flex-col space-y-4 md:items-end md:space-x-4 md:flex-row md:w-1/2">
                <x-bit.input.text type="text" wire:model="filters.search" placeholder="Search Proposals..." />
                @if($form->settings->searchable)
                <x-bit.button.link @click="showAdvanced = !showAdvanced"><span x-show="showAdvanced" x-cloak>Hide</span> Advanced Search...</x-bit.button.link>
                @endif
            </div>
            <div class="flex items-end mt-4 md:mt-0">
                <x-bit.data-table.per-page />
            </div>
        </div>

        <!-- Advanced Search -->
        <div x-show="showAdvanced" x-cloak x-transition:enter="transition ease-out duration-100 transform" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75 transform" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
            <div class="relative p-4 bg-gray-200 rounded shadow-inner dark:bg-gray-700">
                <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                    @foreach($advancedSearchForm as $item)
                        @if($item['type'] === 'text')
                        <x-bit.input.group :for="$item['id']" :label="$item['question']" :error="$errors->first('advanced.' . $item['id'])">
                            <x-bit.input.text type="text" class="w-full mt-1" :id="$item['id']" wire:model="advanced.{{ $item['id'] }}" />
                        </x-bit.input.group>
                        @elseif($item['type'] === 'list')
                        <x-bit.input.group :for="$item['id']" :label="$item['question']" :error="$errors->first('advanced.' . $item['id'])">
                            <div class="mt-1 space-y-1">
                                @foreach($item['options'] as $key => $label)
                                @if(strpos($label, ':'))
                                <x-bit.input.checkbox :value="explode(':', $label)[0]" :id="$item['id'].'-'.$key" :label="explode(':', $label)[0]" wire:model="advanced.{{ $item['id'] }}" />
                                @else
                                <x-bit.input.checkbox :value="$label" :id="$item['id'].'-'.$key" :label="$label" wire:model="advanced.{{ $item['id'] }}" />
                                @endif
                                @endforeach
                                @if(isset($item['list-other']) && $item['list-other'] === true)
                                <x-bit.input.checkbox value="other" label="Other" wire:model="advanced.{{ $item['id'] }}" />
                                @endif
                            </div>
                        </x-bit.input.group>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        <x-bit.table>
            <x-slot name="head">
                <x-bit.table.heading>Status</x-bit.table.heading>
                @forelse($form->settings->searchable as $label)
                    <x-bit.table.heading>{{ str_replace(['question', '_', '-'], '', $label) }}</x-bit.table.heading>
                @empty
                    <x-bit.table.heading>Workshop</x-bit.table.heading>
                @endforelse
                <x-bit.table.heading>Created At</x-bit.table.heading>
                <x-bit.table.heading />
            </x-slot>

            <x-slot name="body">
                @forelse($workshops as $workshop)
                <x-bit.table.row wire:key="row-{{ $workshop->id }}">
                    <x-bit.table.cell>{{ $workshop->status }}</x-bit.table.cell>
                    @forelse($form->settings->searchable as $item)
                        <x-bit.table.cell>
                            {{ $workshop->answers[$item] ?? '?' }}
                        </x-bit.table.cell>
                    @empty
                        <x-bit.table.cell>{{ $workshop->name }}</x-bit.table.cell>
                    @endforelse
                    <x-bit.table.cell>{{ $workshop->created_at->format('M, d Y') }}</x-bit.table.cell>

                    <x-bit.table.cell>
                        <x-bit.button.link size="py-1 px-2" href="{{ route('galaxy.responses.show', ['response' => $workshop]) }}">
                            <x-heroicon-o-eye class="w-4 h-4 text-green-500 dark:text-green-400" />
                        </x-bit.button.link>
                    </x-bit.table.cell>

                </x-bit.table.row>
                @empty
                <x-bit.table.row>
                    <x-bit.table.cell colspan="9">
                        <div class="flex items-center justify-center space-x-2">
                            <x-heroicon-o-users class="w-8 h-8 text-gray-400" />
                            <span class="py-8 text-xl font-medium text-gray-500 dark:text-gray-400 glacial">No workshops found...</span>
                        </div>
                    </x-bit.table.cell>
                </x-bit.table.row>
                @endforelse
            </x-slot>
        </x-bit.table>

        <div>
            {{ $workshops->links() }}
        </div>
    </div>

</div>
