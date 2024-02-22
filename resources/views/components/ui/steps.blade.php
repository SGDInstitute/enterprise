<div class="bg-gray-50 dark:bg-gray-850 lg:border-b lg:border-t lg:border-gray-200 dark:lg:border-gray-700">
    <nav class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8" aria-label="Progress">
        <ol
            role="list"
            class="overflow-hidden rounded-md lg:flex lg:rounded-none lg:border-l lg:border-r lg:border-gray-200 dark:lg:border-gray-700"
        >
            @foreach ($steps as $step)
                <li class="relative overflow-hidden lg:flex-1">
                    @isset($step['route'])
                        <a
                            href="{{ $step['route'] }}"
                            class="group w-full overflow-hidden rounded-b-md border border-t-0 border-gray-200 dark:border-gray-700 lg:border-0"
                        >
                            @if ($step['current'])
                                <span
                                    class="absolute left-0 top-0 h-full w-1 bg-green-600 dark:bg-green-400 lg:bottom-0 lg:top-auto lg:h-1 lg:w-full"
                                    aria-hidden="true"
                                ></span>
                            @else
                                <span
                                    class="absolute left-0 top-0 h-full w-1 bg-transparent group-hover:bg-gray-200 dark:group-hover:bg-gray-700 lg:bottom-0 lg:top-auto lg:h-1 lg:w-full"
                                    aria-hidden="true"
                                ></span>
                            @endif
                            <span class="flex items-center px-6 py-5 text-sm font-medium lg:pl-9">
                                <span class="flex-shrink-0">
                                    @if ($step['complete'])
                                        <span
                                            class="flex h-10 w-10 items-center justify-center rounded-full bg-green-600 dark:bg-green-400"
                                        >
                                            <x-heroicon-s-check class="h-6 w-6 text-white" />
                                        </span>
                                    @elseif ($step['current'])
                                        <span
                                            class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-green-600 dark:border-green-400"
                                        >
                                            <span class="text-green-600 dark:text-green-400">
                                                0{{ $loop->iteration }}
                                            </span>
                                        </span>
                                    @else
                                        <span
                                            class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-gray-300 dark:border-gray-700"
                                        >
                                            <span class="text-gray-500 dark:text-gray-400">
                                                0{{ $loop->iteration }}
                                            </span>
                                        </span>
                                    @endif
                                </span>
                                <span class="ml-4 mt-0.5 flex min-w-0 flex-col">
                                    @if ($step['current'])
                                        <span
                                            class="text-xs font-semibold uppercase tracking-wide text-gray-900 dark:text-gray-200"
                                        >
                                            {{ $step['title'] }}
                                        </span>
                                    @else
                                        <span
                                            class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400"
                                        >
                                            {{ $step['title'] }}
                                        </span>
                                    @endif
                                    @isset($step['subtitle'])
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                            {{ $step['subtitle'] }}
                                        </span>
                                    @endif
                                </span>
                            </span>

                            @if (! $loop->first)
                                <div class="absolute inset-0 left-0 top-0 hidden w-3 lg:block" aria-hidden="true">
                                    <svg
                                        class="h-full w-full text-gray-300 dark:text-gray-700"
                                        viewBox="0 0 12 82"
                                        fill="none"
                                        preserveAspectRatio="none"
                                    >
                                        <path
                                            d="M0.5 0V31L10.5 41L0.5 51V82"
                                            stroke="currentcolor"
                                            vector-effect="non-scaling-stroke"
                                        />
                                    </svg>
                                </div>
                            @endif
                        </a>
                    @else
                        <button
                            type="button"
                            disabled
                            class="group w-full overflow-hidden rounded-b-md border border-t-0 border-gray-200 disabled:cursor-not-allowed disabled:opacity-75 dark:border-gray-700 lg:border-0"
                        >
                            @if ($step['current'])
                                <span
                                    class="absolute left-0 top-0 h-full w-1 bg-green-600 dark:bg-green-400 lg:bottom-0 lg:top-auto lg:h-1 lg:w-full"
                                    aria-hidden="true"
                                ></span>
                            @else
                                <span
                                    class="absolute left-0 top-0 h-full w-1 bg-transparent group-hover:bg-gray-200 dark:group-hover:bg-gray-700 lg:bottom-0 lg:top-auto lg:h-1 lg:w-full"
                                    aria-hidden="true"
                                ></span>
                            @endif
                            <span class="flex items-center px-6 py-5 text-sm font-medium lg:pl-9">
                                <span class="flex-shrink-0">
                                    @if ($step['complete'])
                                        <span
                                            class="flex h-10 w-10 items-center justify-center rounded-full bg-green-600 dark:bg-green-400"
                                        >
                                            <x-heroicon-s-check class="h-6 w-6 text-white" />
                                        </span>
                                    @elseif ($step['current'])
                                        <span
                                            class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-green-600 dark:border-green-400"
                                        >
                                            <span class="text-green-600 dark:text-green-400">
                                                0{{ $loop->iteration }}
                                            </span>
                                        </span>
                                    @else
                                        <span
                                            class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-gray-300 dark:border-gray-700"
                                        >
                                            <span class="text-gray-500 dark:text-gray-400">
                                                0{{ $loop->iteration }}
                                            </span>
                                        </span>
                                    @endif
                                </span>
                                <span class="ml-4 mt-0.5 flex min-w-0 flex-col">
                                    @if ($step['current'])
                                        <span
                                            class="text-xs font-semibold uppercase tracking-wide text-gray-900 dark:text-gray-200"
                                        >
                                            {{ $step['title'] }}
                                        </span>
                                    @else
                                        <span
                                            class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400"
                                        >
                                            {{ $step['title'] }}
                                        </span>
                                    @endif
                                    @isset($step['subtitle'])
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                            {{ $step['subtitle'] }}
                                        </span>
                                    @endif
                                </span>
                            </span>

                            @if (! $loop->first)
                                <div class="absolute inset-0 left-0 top-0 hidden w-3 lg:block" aria-hidden="true">
                                    <svg
                                        class="h-full w-full text-gray-300 dark:text-gray-700"
                                        viewBox="0 0 12 82"
                                        fill="none"
                                        preserveAspectRatio="none"
                                    >
                                        <path
                                            d="M0.5 0V31L10.5 41L0.5 51V82"
                                            stroke="currentcolor"
                                            vector-effect="non-scaling-stroke"
                                        />
                                    </svg>
                                </div>
                            @endif
                        </button>
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
</div>
