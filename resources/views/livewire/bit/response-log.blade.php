<div>
    <div class="max-w-lg mx-auto bg-gray-100 rounded-md shadow dark:bg-gray-700">
        <div class="flow-root p-6">
            <ul class="-mb-8">
                @foreach($activities as $activity)
                <li>
                    <div class="relative pb-8">
                        @if(!$loop->last)
                        <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-800" aria-hidden="true"></span>
                        @endif
                        @if($activity['description'] === 'created')
                        <div class="relative flex items-start space-x-3">
                            <div>
                                <div class="relative px-1">
                                    <div class="flex items-center justify-center w-8 h-8 bg-gray-200 rounded-full dark:bg-gray-800 ring-8 ring-gray-100 dark:ring-gray-700">
                                        <x-heroicon-s-plus class="w-5 h-5 text-gray-500" />
                                    </div>
                                </div>
                            </div>
                            <div class="min-w-0 flex-1 py-1.5">
                                <div class="text-sm text-gray-500 dark:text-gray-300">
                                    {{ $activity->causer->name }} created {{ $response->name }}
                                    <span class="text-gray-400 whitespace-nowrap">{{ $activity->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                        @elseif($activity['description'] === 'updated')
                        @if(isset($activity['properties']['old']['status']))
                        <div class="relative flex items-start space-x-3">
                            <div>
                                <div class="relative px-1">
                                    <div class="flex items-center justify-center w-8 h-8 bg-gray-200 rounded-full dark:bg-gray-800 ring-8 ring-gray-100 dark:ring-gray-700">
                                        <x-heroicon-s-adjustments class="w-5 h-5 text-gray-500" />
                                    </div>
                                </div>
                            </div>
                            <div class="min-w-0 flex-1 py-1.5">
                                <div class="text-sm text-gray-500 dark:text-gray-300">
                                    {{ $activity->causer->name }} changed status from <span class="italic">{{ $activity['properties']['old']['status'] }}</span> to <span class="italic">{{ $activity['properties']['attributes']['status'] }}</span>
                                    <span class="text-gray-400 whitespace-nowrap">{{ $activity->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="relative flex items-start space-x-3">
                            <div>
                                <div class="relative px-1">
                                    <div class="flex items-center justify-center w-8 h-8 bg-gray-200 rounded-full dark:bg-gray-800 ring-8 ring-gray-100 dark:ring-gray-700">
                                        <x-heroicon-s-pencil class="w-5 h-5 text-gray-500" />
                                    </div>
                                </div>
                            </div>
                            <div class="min-w-0 flex-1 py-1.5">
                                <div class="text-sm text-gray-500 dark:text-gray-300">
                                    {{ $activity->causer->name }} saved {{ $response->name }}
                                    <span class="text-gray-400 whitespace-nowrap">{{ $activity->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                        @endif
                        @elseif($activity['description'] === 'submitted')
                        <div class="relative flex items-start space-x-3">
                            <div>
                                <div class="relative px-1">
                                    <div class="flex items-center justify-center w-8 h-8 bg-gray-200 rounded-full dark:bg-gray-800 ring-8 ring-gray-100 dark:ring-gray-700">
                                        <x-heroicon-s-upload class="w-5 h-5 text-gray-500" />
                                    </div>
                                </div>
                            </div>
                            <div class="min-w-0 flex-1 py-1.5">
                                <div class="text-sm text-gray-500 dark:text-gray-300">
                                    {{ $activity->causer->name }} submitted {{ $response->name }} for review
                                    <span class="text-gray-400 whitespace-nowrap">{{ $activity->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                        @elseif($activity['description'] === 'commented')
                        <div class="relative flex items-start space-x-3">
                            <div class="relative">
                                <img class="flex items-center justify-center w-10 h-10 bg-gray-400 rounded-full ring-8 ring-gray-100 dark:ring-gray-700" src="{{ $activity->causer->profile_photo_url }}" alt="{{ $activity->causer->name }}">

                                <span class="absolute -bottom-0.5 -right-1 bg-gray-100 dark:bg-gray-700 rounded-tl px-0.5 py-px">
                                    <x-heroicon-s-chat-alt class="w-5 h-5 text-gray-400" />
                                </span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div>
                                    @if(isset($activity['properties']['internal']) && $activity['properties']['internal'])
                                    <x-bit.badge class="float-right">Internal</x-bit.badge>
                                    @endif
                                    <div class="text-sm">
                                        <a href="#" class="font-medium text-gray-900 dark:text-gray-200">{{ $activity->causer->name }}</a>
                                    </div>
                                    <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">
                                        Commented {{ $activity->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                <div class="mt-2 text-sm text-gray-700 dark:text-gray-300">
                                    <p>
                                        {!! nl2br($activity['properties']['comment']) !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @else
                            @json($activity)
                        @endif
                    </div>
                </li>
                @endforeach

            </ul>
        </div>
        <form wire:submit.prevent="save" class="p-6 space-y-4 border-t border-gray-300 dark:border-gray-800">
            <x-bit.input.group for="comment" label="Add Comment" :error="$errors->first('comment')">
                <x-bit.input.textarea wire:ignore class="w-full mt-1" id="comment" wire:model="comment" />
            </x-bit.input.group>
            @if($isGalaxy)
            <x-bit.input.group for="status" label="Status">
                <x-bit.input.select id="status" wire:model="status">
                    <option value="work-in-progress">Work in Progress</option>
                    <option value="submitted">Submitted</option>
                    <option value="in-review">In Review</option>
                    <option value="approved">Approved</option>
                    <option value="waiting-list">Waiting List</option>
                    <option value="rejected">Rejected</option>
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
