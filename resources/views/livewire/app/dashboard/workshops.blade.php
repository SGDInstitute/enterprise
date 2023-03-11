<div>
    <h1 class="text-2xl text-gray-900 dark:text-gray-200">Workshop Proposals</h1>

    <div class="flex-col mt-5 space-y-4">
        <div class="md:flex md:justify-between">
            <div class="flex flex-col space-y-4 md:items-end md:space-x-4 md:flex-row md:w-1/2">
                <x-bit.input.text type="text" wire:model="filters.search" placeholder="Search Proposals..." />
            </div>
            <div class="flex items-end mt-4 md:mt-0">
                <x-bit.data-table.per-page />
            </div>
        </div>

        <x-bit.table>
            <x-slot name="head">
                @if (!$this->form)
                <x-bit.table.heading>Event</x-bit.table.heading>
                @endif
                <x-bit.table.heading>Workshop Name</x-bit.table.heading>
                <x-bit.table.heading>Status</x-bit.table.heading>
                <x-bit.table.heading>Date Created</x-bit.table.heading>
                <x-bit.table.heading />
            </x-slot>

            <x-slot name="body">
                @forelse ($workshops as $workshop)
                <x-bit.table.row wire:key="row-{{ $workshop->id }}">
                    @if (!$this->form)
                    <x-bit.table.cell>{{ $workshop->form->name }}</x-bit.table.cell>
                    @endif
                    <x-bit.table.cell>{{ $workshop->name }}</x-bit.table.cell>
                    <x-bit.table.cell>{{ $workshop->status }}</x-bit.table.cell>
                    <x-bit.table.cell>{{ $workshop->created_at->format('M, d Y') }}</x-bit.table.cell>

                    <x-bit.table.cell>
                        <x-bit.button.link size="py-1 px-2" href="{{ route('app.forms.show', ['form' => $workshop->form, 'edit' => $workshop]) }}">
                            <x-heroicon-o-pencil class="w-4 h-4 text-green-500 dark:text-green-400" />
                        </x-bit.button.link>
                        <x-bit.button.link size="py-1 px-2" wire:click="delete({{ $workshop->id }})">
                            <x-heroicon-o-trash class="w-4 h-4 text-green-500 dark:text-green-400" />
                        </x-bit.button.link>
                    </x-bit.table.cell>
                </x-bit.table.row>
                <!-- If they need to fill out the finalization form -->
                @if ($workshop->form->finalizeForm && $this->finalizeFormNeeded($workshop))
                <x-bit.table.row wire:key="row-{{ $workshop->id }}-confirm" class="bg-yellow-400 dark:bg-yellow-800">
                    <x-bit.table.cell colspan="10">
                        <div class="flex items-center justify-between w-full pl-6">
                            <div class="flex items-center space-x-2">
                                <x-heroicon-s-exclamation class="w-6 h-6" />
                                <div>
                                    <p>
                                        <span class="font-bold">Finalize Program Book Details</span>
                                        <span> for <span class="truncate">{{ $workshop->name }}</span></span>
                                    </p>
                                    <p>Due by {{ $workshop->form->finalizeForm->getFormattedEndAttribute('n/d') }} ({{ $workshop->form->finalizeForm->daysLeft }} days)</p>
                                </div>
                            </div>
                            <x-bit.button.flat.secondary :href="route('app.forms.finalize', ['form' => $workshop->form->finalizeForm, 'parent' => $workshop->id])" size="sm">Start Form</x-bit.button.flat.secondary>
                        </div>
                    </x-bit.table.cell>
                </x-bit.table.row>
                @endif
                @if ($workshop->form->finalizeForm && $this->finalizeFormSubmitted($workshop))
                <x-bit.table.row wire:key="row-{{ $workshop->id }}-confirm" class="bg-green-300 dark:bg-green-800">
                    <x-bit.table.cell colspan="10">
                        <p class="text-base">Thank you for finalizing your program book details for {{ $workshop->name }}.</p>
                        <p class="text-base">Any information that was changed will be updated when the workshop is scheduled.</p>
                        <p class="text-base">An order with comped ticket(s) has been created, and can be viewed on the <a href="/dashboard/orders-reservations">Event Tickets</a> tab.</p>
                    </x-bit.table.cell>
                </x-bit.table.row>
                @endif
                @empty
                <x-bit.table.row>
                    <x-bit.table.cell colspan="9">
                        <div class="flex items-center justify-center space-x-2">
                            <x-heroicon-o-users class="w-8 h-8 text-gray-400" />
                            <span class="py-8 text-xl font-medium text-gray-500 dark:text-gray-400 ">No workshops found...</span>
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
