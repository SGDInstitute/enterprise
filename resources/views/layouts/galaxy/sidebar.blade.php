<div class="hidden md:flex md:flex-shrink-0">
    <div class="flex w-56 flex-col">
        <div
            class="flex flex-grow flex-col overflow-y-auto border-r border-gray-200 bg-white pb-4 pt-5 dark:border-gray-700 dark:bg-gray-850"
        >
            <div class="flex flex-shrink-0 items-center px-4">
                <img class="h-8 w-auto" src="/img/galaxy.png" alt="Galaxy" />
                <span class="ml-4 text-xl dark:text-white">Galaxy</span>
            </div>
            <div class="mt-5 flex flex-grow flex-col">
                <nav class="flex-1 space-y-1 bg-white px-2 dark:bg-gray-850">
                    @foreach (config('nav.galaxy') as $link)
                        @if (isset($link['roles']) &&auth()->user()->hasRole($link['roles']))
                            @include('layouts.galaxy.item')
                        @endif
                    @endforeach
                </nav>
            </div>
        </div>
    </div>
</div>
