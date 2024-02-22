<nav aria-label="Progress">
    <ol
        class="divide-y divide-gray-300 rounded-md border border-gray-300 dark:divide-gray-500 dark:border-gray-500 dark:bg-gray-700 md:flex md:divide-y-0"
    >
        @foreach ($steps as $index => $step)
            <li class="relative md:flex md:flex-1">
                <div class="flex w-full items-center">
                    <span class="flex w-full items-center justify-between px-6 py-4 text-sm font-medium">
                        <div class="flex items-center">
                            @if ($step['complete'])
                                <span
                                    class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-green-500"
                                >
                                    <x-heroicon-s-check class="h-6 w-6 text-white" />
                                </span>
                            @elseif ($step['name'] === $current['name'])
                                <span
                                    class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full border-2 border-green-500"
                                >
                                    <span class="text-green-500 dark:text-green-400">0{{ $index + 1 }}</span>
                                </span>
                            @else
                                <span
                                    class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full border-2 border-gray-300 dark:border-gray-400"
                                >
                                    <span class="text-gray-500 dark:text-gray-400">0{{ $index + 1 }}</span>
                                </span>
                            @endif

                            @if (isset($step['link']) && $step['available'] === true && $step['complete'] !== true)
                                <a
                                    href="{{ $step['link'] }}"
                                    class="ml-4 animate-pulse text-lg font-medium text-green-500 dark:text-green-400"
                                >
                                    {{ $step['name'] }}
                                </a>
                            @else
                                <span class="ml-4 text-sm font-medium text-gray-900 dark:text-gray-200">
                                    {{ $step['name'] }}
                                </span>
                            @endif
                        </div>
                        @isset($step['help'])
                            <x-dynamic-component :component="$step['help']" />
                        @endif
                    </span>
                </div>

                @if (! $loop->last)
                    <div class="absolute right-0 top-0 hidden h-full w-5 md:block" aria-hidden="true">
                        <svg
                            class="h-full w-full text-gray-300 dark:text-gray-500"
                            viewBox="0 0 22 80"
                            fill="none"
                            preserveAspectRatio="none"
                        >
                            <path
                                d="M0 -2L20 40L0 82"
                                vector-effect="non-scaling-stroke"
                                stroke="currentcolor"
                                stroke-linejoin="round"
                            />
                        </svg>
                    </div>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
