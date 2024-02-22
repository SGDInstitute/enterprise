<div>
    <h2 id="thank-you-modal" class="mb-4 text-2xl text-gray-900 dark:text-gray-200">Thank You Modal</h2>
    <div class="relative flex">
        <div class="relative w-3/4 overflow-hidden rounded-md border border-gray-300 p-4 shadow dark:border-gray-700">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-4">
                <nav class="space-y-1" aria-label="Sidebar">
                    @foreach (config('nav.app.dashboard') as $link)
                        <x-galaxy.nav-link
                            :href="route($link['route'], $link['route-param'])"
                            :icon="$link['icon']"
                            :active="$link['route-param'] === 'donations'"
                        >
                            {{ $link['name'] }}
                        </x-galaxy.nav-link>
                    @endforeach
                </nav>

                <div class="col-span-3 text-gray-200">
                    <div class="space-y-8">
                        <h1 class="text-2xl text-gray-900 dark:text-gray-200">Donations</h1>

                        <div class="space-y-4">
                            <div class="mt-5 flex-col space-y-4">
                                <div class="md:flex md:items-center md:justify-between">
                                    <div class="mt-4 flex items-end md:mt-0">
                                        <x-bit.data-table.per-page wire:model.live="perPage" />
                                    </div>
                                </div>

                                <x-bit.table>
                                    <x-slot name="head">
                                        <x-bit.table.heading>Date Donated</x-bit.table.heading>
                                        <x-bit.table.heading>Type</x-bit.table.heading>
                                        <x-bit.table.heading>Amount</x-bit.table.heading>
                                        <x-bit.table.heading>Status</x-bit.table.heading>
                                        <x-bit.table.heading></x-bit.table.heading>
                                    </x-slot>

                                    <x-slot name="body">
                                        <x-bit.table.row wire:key="row-donation-1">
                                            <x-bit.table.cell>
                                                <div class="h-4 w-24 rounded bg-gray-900 dark:bg-gray-700"></div>
                                            </x-bit.table.cell>
                                            <x-bit.table.cell>
                                                <div class="h-4 w-24 rounded bg-gray-900 dark:bg-gray-700"></div>
                                            </x-bit.table.cell>
                                            <x-bit.table.cell>
                                                <div class="h-4 w-24 rounded bg-gray-900 dark:bg-gray-700"></div>
                                            </x-bit.table.cell>
                                            <x-bit.table.cell>
                                                <div class="h-4 w-24 rounded bg-gray-900 dark:bg-gray-700"></div>
                                            </x-bit.table.cell>
                                            <x-bit.table.cell class="text-right">
                                                <x-bit.button.link>View</x-bit.button.link>
                                            </x-bit.table.cell>
                                        </x-bit.table.row>
                                        <x-bit.table.row wire:key="row-donation-2">
                                            <x-bit.table.cell>
                                                <div class="h-4 w-24 rounded bg-gray-900 dark:bg-gray-700"></div>
                                            </x-bit.table.cell>
                                            <x-bit.table.cell>
                                                <div class="h-4 w-24 rounded bg-gray-900 dark:bg-gray-700"></div>
                                            </x-bit.table.cell>
                                            <x-bit.table.cell>
                                                <div class="h-4 w-24 rounded bg-gray-900 dark:bg-gray-700"></div>
                                            </x-bit.table.cell>
                                            <x-bit.table.cell>
                                                <div class="h-4 w-24 rounded bg-gray-900 dark:bg-gray-700"></div>
                                            </x-bit.table.cell>
                                            <x-bit.table.cell class="text-right">
                                                <x-bit.button.link>View</x-bit.button.link>
                                            </x-bit.table.cell>
                                        </x-bit.table.row>
                                        <x-bit.table.row wire:key="row-donation-3">
                                            <x-bit.table.cell>
                                                <div class="h-4 w-24 rounded bg-gray-900 dark:bg-gray-700"></div>
                                            </x-bit.table.cell>
                                            <x-bit.table.cell>
                                                <div class="h-4 w-24 rounded bg-gray-900 dark:bg-gray-700"></div>
                                            </x-bit.table.cell>
                                            <x-bit.table.cell>
                                                <div class="h-4 w-24 rounded bg-gray-900 dark:bg-gray-700"></div>
                                            </x-bit.table.cell>
                                            <x-bit.table.cell>
                                                <div class="h-4 w-24 rounded bg-gray-900 dark:bg-gray-700"></div>
                                            </x-bit.table.cell>
                                            <x-bit.table.cell class="text-right">
                                                <x-bit.button.link>View</x-bit.button.link>
                                            </x-bit.table.cell>
                                        </x-bit.table.row>
                                    </x-slot>
                                </x-bit.table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="absolute inset-x-0 top-0 h-full overflow-auto px-4 pb-6 pt-6 sm:px-0">
                <div class="absolute inset-0 transform transition-all">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <div
                    class="mx-auto transform overflow-scroll rounded-lg bg-white shadow-xl transition-all dark:bg-gray-800 sm:w-full sm:max-w-lg"
                >
                    <button
                        wire:click="$toggle('editPanel')"
                        for="page-image"
                        class="absolute right-4 top-4 rounded-full bg-cyan-500 p-2 text-gray-900"
                    >
                        <x-heroicon-o-pencil class="h-4 w-4" />
                    </button>
                    <div class="px-6 py-4">
                        <div class="text-lg dark:text-gray-200">
                            {{ $title->payload }}
                        </div>

                        <div class="mt-4">
                            <div class="prose dark:prose-light">
                                {!! markdown($content->payload) !!}
                            </div>
                        </div>
                    </div>

                    <div
                        class="rounded-b-lg bg-gray-100 px-6 py-4 text-right dark:border-t dark:border-gray-700 dark:bg-gray-800"
                    >
                        <x-bit.button.flat.secondary>Close</x-bit.button.flat.secondary>
                    </div>
                </div>
            </div>
        </div>

        <div class="{{ $editPanel ? '' : 'hidden' }} -ml-64 mt-16 flex-1 space-y-2">
            <div class="md:sticky md:top-16">
                <x-bit.panel>
                    <x-bit.panel.heading class="flex items-center justify-between space-x-4">
                        <h2 class="text-gray-900 dark:text-gray-200">Content Editor</h2>
                        <button wire:click="$toggle('editPanel')">
                            <x-heroicon-o-x-mark
                                class="h-6 w-6 text-gray-700 hover:text-green-500 dark:text-gray-400 dark:hover:text-green-400"
                            />
                        </button>
                    </x-bit.panel.heading>
                    <x-bit.panel.body>
                        <form wire:submit="saveContent" class="space-y-4">
                            <x-form.group label="Title" name="title" model="title.payload" type="text" />
                            <x-form.group label="Content" name="content" model="content.payload" type="markdown" />
                            <x-bit.button.round.primary type="submit">Save</x-bit.button.round.primary>
                        </form>
                    </x-bit.panel.body>
                </x-bit.panel>
            </div>
        </div>
    </div>
</div>
