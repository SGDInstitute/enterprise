<div>
    <div>
        <div class="sm:hidden">
            <label for="tabs" class="sr-only">Select a tab</label>
            <select
                id="tabs"
                wire:model.live="active"
                name="tabs"
                class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-green-500 focus:outline-none focus:ring-green-500 dark:border-gray-900 dark:bg-gray-700 dark:text-gray-200 sm:text-sm"
            >
                @foreach ($options as $option)
                    <option>{{ $option }}</option>
                @endforeach
            </select>
        </div>
        <div class="hidden sm:block">
            <div class="border-b border-gray-200 dark:border-gray-600">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    @foreach ($options as $option)
                        @if ($option === $active)
                            <button
                                wire:click="setActive('{{ $option }}')"
                                class="whitespace-nowrap border-b-2 border-green-500 px-1 py-4 text-sm font-bold text-green-500 dark:border-green-400 dark:text-green-400"
                            >
                                {{ $option }}
                            </button>
                        @else
                            <button
                                wire:click="setActive('{{ $option }}')"
                                class="whitespace-nowrap border-b-2 border-transparent px-1 py-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200"
                            >
                                {{ $option }}
                            </button>
                        @endif
                    @endforeach
                </nav>
            </div>
        </div>
    </div>

    <div class="prose py-4 dark:prose-light">
        {!! $activeContent !!}
    </div>
</div>
