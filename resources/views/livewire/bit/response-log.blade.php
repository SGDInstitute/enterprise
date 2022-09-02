<div>
    <div class="max-w-lg mx-auto bg-white rounded-md shadow dark:bg-gray-700">
        <div class="flow-root p-6">
            <ul class="-mb-8">
                @foreach ($activities as $activity)
                <li>
                    <div class="relative pb-8">
                        @if (!$loop->last)
                        <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-800" aria-hidden="true"></span>
                        @endif

                        @includeWhen($activity['description'] === 'created', 'livewire.bit.partials.created')
                        @includeWhen($activity['description'] === 'updated', 'livewire.bit.partials.updated')
                        @includeWhen($activity['description'] === 'submitted', 'livewire.bit.partials.submitted')
                        @includeWhen($activity['description'] === 'commented', 'livewire.bit.partials.commented')
                        @includeWhen($activity['description'] === 'finalized', 'livewire.bit.partials.finalized')
                    </div>
                </li>
                @endforeach

            </ul>
        </div>
        <div class="p-4 space-y-4 border-t border-gray-300 dark:border-gray-800">
            <form wire:submit.prevent="save" class="space-y-4">
                <x-bit.input.group for="comment" label="Add Comment" :error="$errors->first('comment')">
                    <x-bit.input.textarea wire:ignore class="w-full mt-1" id="comment" wire:model="comment" />
                </x-bit.input.group>
                @if ($isGalaxy)
                <x-bit.input.group for="status" label="Status">
                    <x-bit.input.select id="status" wire:model="status">
                        <option value="work-in-progress">Work in Progress</option>
                        <option value="submitted">Submitted</option>
                        <option value="in-review">In Review</option>
                        <option value="approved">Approved</option>
                        <option value="waiting-list">Waiting List</option>
                        <option value="rejected">Rejected</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="canceled">Canceled</option>
                        <option value="scheduled">Scheduled</option>
                    </x-bit.input.select>
                </x-bit.input.group>
                <x-bit.input.group for="internal">
                    <x-bit.input.checkbox id="internal" label="Internal Only" wire:model="internal" />
                    <x-bit.input.help>Check if only members of the team should see this comment</x-bit.input.help>
                </x-bit.input.group>
                @endif
                <x-bit.button.round.primary size="sm" type="submit">Save</x-bit.button.round.primary>
            </form>
        </div>
    </div>
</div>
