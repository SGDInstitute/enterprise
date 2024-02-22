<div>
    <h2 id="donation-page" class="mb-4 text-2xl text-gray-900 dark:text-gray-200">Donation Page</h2>
    <div class="relative flex">
        <div class="w-3/4 overflow-hidden rounded-md border border-gray-300 shadow dark:border-gray-700">
            <div class="mb-4">
                <div
                    class="relative h-60 w-full bg-cover bg-center bg-no-repeat md:h-96"
                    style="background-image: url({{ $image->payload }})"
                >
                    <button
                        wire:click="show('image')"
                        for="page-image"
                        class="absolute right-4 top-4 rounded-full bg-cyan-500 p-2 text-gray-900"
                    >
                        <x-heroicon-o-pencil class="h-4 w-4" />
                    </button>
                </div>
                <div class="relative -mt-6 w-4/5 bg-yellow-500 px-8 py-4 md:w-2/3">
                    <form wire:submit="saveTitle">
                        <input
                            id="page-title"
                            name="page-title"
                            class="font-news-cycle bg-transparent text-4xl text-gray-700"
                            wire:model.live="title.payload"
                        />
                    </form>
                    <label
                        for="page-title"
                        wire:click="show(false)"
                        class="absolute right-4 top-1 rounded-full bg-cyan-500 p-2 text-gray-900"
                    >
                        <x-heroicon-o-pencil class="h-4 w-4" />
                    </label>
                </div>
            </div>

            <div
                class="relative mx-auto grid grid-cols-1 gap-20 px-12 pt-12 md:max-w-4xl md:grid-cols-2 md:px-4 md:pb-4"
            >
                <div class="space-y-8">
                    <div class="space-y-6">
                        <div class="space-y-2">
                            <h2 class="text-gray-900 dark:text-gray-200">Personal Information</h2>
                            <x-form.group label="Name" model="name" type="text" disabled />
                            <x-form.group label="Email" model="email" type="email" autocomplete="email" disabled />
                        </div>

                        <div class="space-y-2">
                            <h2 class="text-gray-900 dark:text-gray-200">Choose Amount to Donate</h2>

                            <div class="space-y-6">
                                <div class="flex">
                                    <button
                                        type="button"
                                        wire:click="$set('type', 'monthly')"
                                        class="{{ $type === 'monthly' ? 'bg-green-600 text-white dark:bg-green-500' : 'text-green-500 hover:bg-green-500 hover:text-white dark:text-green-400 dark:hover:bg-green-400' }} inline-flex w-full items-center justify-center border-2 border-green-500 px-4 py-2 font-bold uppercase dark:border-green-400"
                                    >
                                        Monthly
                                    </button>
                                    <button
                                        type="button"
                                        wire:click="$set('type', 'one-time')"
                                        class="{{ $type === 'one-time' ? 'bg-green-600 text-white dark:bg-green-500' : 'text-green-500 hover:bg-green-500 hover:text-white dark:text-green-400 dark:hover:bg-green-400' }} -ml-px inline-flex w-full items-center justify-center border-2 border-green-500 px-4 py-2 font-bold uppercase dark:border-green-400"
                                    >
                                        Give Once
                                    </button>
                                </div>

                                @if ($type === 'monthly')
                                    <div class="relative grid grid-cols-3 gap-2">
                                        <button
                                            wire:click="show('monthly')"
                                            id="page-monthly-options"
                                            class="absolute -right-4 -top-4 rounded-full bg-cyan-500 p-2 text-gray-900"
                                        >
                                            <x-heroicon-o-pencil class="h-4 w-4" />
                                        </button>
                                        @foreach ($monthlyOptions->payload as $option)
                                            <button
                                                class="btn btn-base btn-block btn-gray"
                                                id="monthly-button-{{ $option }}"
                                            >
                                                ${{ $option }}
                                            </button>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="relative grid grid-cols-3 gap-2">
                                        <button
                                            wire:click="show('one-time')"
                                            id="page-one-time-options"
                                            class="absolute -right-4 -top-4 rounded-full bg-cyan-500 p-2 text-gray-900"
                                        >
                                            <x-heroicon-o-pencil class="h-4 w-4" />
                                        </button>
                                        @foreach ($oneTimeOptions->payload as $option)
                                            @if ($option === 'other')
                                                @if ($otherAmount)
                                                    <x-bit.input.group
                                                        for="other-amount"
                                                        class="col-span-2"
                                                        label="Other Amount"
                                                        sr-only
                                                    >
                                                        <x-bit.input.text
                                                            id="other-amount"
                                                            class="block w-full"
                                                            type="number"
                                                            name="other-amount"
                                                            disabled
                                                            placeholder="Other Amount"
                                                            required
                                                            leading-add-on="$"
                                                        />
                                                    </x-bit.input.group>
                                                @else
                                                    <button
                                                        class="btn-gray btn btn-base btn-block col-span-2"
                                                        wire:click="chooseOther"
                                                    >
                                                        Other Amount
                                                    </button>
                                                @endif
                                            @else
                                                <button
                                                    class="btn btn-base btn-block btn-gray"
                                                    id="one-time-button-{{ $option }}"
                                                >
                                                    ${{ $option }}
                                                </button>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>

                        <x-bit.button.flat.accent-filled block disabled size="large">
                            Continue to Payment
                        </x-bit.button.flat.accent-filled>
                    </div>
                </div>
                <div class="prose dark:prose-light">
                    <div class="md:sticky md:top-24">
                        <button
                            wire:click="show('content')"
                            id="page-content"
                            class="absolute -top-4 right-0 rounded-full bg-cyan-500 p-2 text-gray-900"
                        >
                            <x-heroicon-o-pencil class="h-4 w-4" />
                        </button>
                        {!! markdown($content->payload) !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="{{ $editPanel ? '' : 'hidden' }} -ml-64 mt-16 flex-1 space-y-2">
            <div class="md:sticky md:top-16">
                <x-bit.panel :class="$editPanel === 'image' ? '' : 'hidden'">
                    <x-bit.panel.heading class="flex items-center justify-between space-x-4">
                        <h2 class="text-gray-900 dark:text-gray-200">Image Editor</h2>
                        <button wire:click="show(false)">
                            <x-heroicon-o-x-mark
                                class="h-6 w-6 text-gray-700 hover:text-green-500 dark:text-gray-400 dark:hover:text-green-400"
                            />
                        </button>
                    </x-bit.panel.heading>
                    <x-bit.panel.body>
                        <form wire:submit="saveImage" class="space-y-4">
                            <x-form.group model="image.payload" label="Image URL" type="text" />
                            <x-bit.button.round.primary type="submit">Save</x-bit.button.round.primary>
                        </form>
                    </x-bit.panel.body>
                </x-bit.panel>

                <x-bit.panel :class="$editPanel === 'content' ? '' : 'hidden'">
                    <x-bit.panel.heading class="flex items-center justify-between space-x-4">
                        <h2 class="text-gray-900 dark:text-gray-200">Content Editor</h2>
                        <button wire:click="show(false)">
                            <x-heroicon-o-x-mark
                                class="h-6 w-6 text-gray-700 hover:text-green-500 dark:text-gray-400 dark:hover:text-green-400"
                            />
                        </button>
                    </x-bit.panel.heading>
                    <x-bit.panel.body>
                        <form wire:submit="saveContent" class="space-y-4">
                            <x-form.markdown wire:model.live="content.payload" />
                            <x-bit.button.round.primary type="submit">Save</x-bit.button.round.primary>
                        </form>
                    </x-bit.panel.body>
                </x-bit.panel>

                <x-bit.panel :class="$editPanel === 'monthly' ? '' : 'hidden'">
                    <x-bit.panel.heading class="flex items-center justify-between space-x-4">
                        <h2 class="text-gray-900 dark:text-gray-200">Monthly Options</h2>
                        <button wire:click="show(false)">
                            <x-heroicon-o-x-mark
                                class="h-6 w-6 text-gray-700 hover:text-green-500 dark:text-gray-400 dark:hover:text-green-400"
                            />
                        </button>
                    </x-bit.panel.heading>
                    <x-bit.panel.body>
                        <ul class="list-inside list-disc space-y-1">
                            @foreach ($monthlyOptions->payload as $option)
                                <li class="group items-center space-x-2 text-gray-900 dark:text-gray-200">
                                    <span>{{ $option }}</span>
                                    <button
                                        type="button"
                                        wire:click="removeOption('monthlyOptions', '{{ $option }}')"
                                        class="rounded px-2 py-1 hover:bg-gray-500 dark:hover:bg-gray-600"
                                    >
                                        <x-heroicon-o-trash
                                            class="h-4 w-4 text-green-500 opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                                        />
                                    </button>
                                    @if (! $loop->first)
                                        <button
                                            type="button"
                                            wire:click="moveOption('monthlyOptions', 'up', '{{ $option }}')"
                                            class="rounded px-2 py-1 hover:bg-gray-500 dark:hover:bg-gray-600"
                                        >
                                            <x-heroicon-o-chevron-up
                                                class="h-4 w-4 text-green-500 opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                                            />
                                        </button>
                                    @endif

                                    @if (! $loop->last)
                                        <button
                                            type="button"
                                            wire:click="moveOption('monthlyOptions', 'down', '{{ $option }}')"
                                            class="rounded px-2 py-1 hover:bg-gray-500 dark:hover:bg-gray-600"
                                        >
                                            <x-heroicon-o-chevron-down
                                                class="h-4 w-4 text-green-500 opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                                            />
                                        </button>
                                    @endif
                                </li>
                            @endforeach

                            <li class="text-gray-900 dark:text-gray-200">
                                <form class="inline" wire:submit="addOption('monthlyOptions')">
                                    <input
                                        class="-ml-2 rounded border border-gray-300 bg-white px-2 py-1 dark:border-gray-700 dark:bg-gray-800"
                                        wire:model.live="newPrice"
                                    />
                                </form>
                            </li>
                        </ul>
                    </x-bit.panel.body>
                </x-bit.panel>

                <x-bit.panel :class="$editPanel === 'one-time' ? '' : 'hidden'">
                    <x-bit.panel.heading class="flex items-center justify-between space-x-4">
                        <h2 class="text-gray-900 dark:text-gray-200">One-time Options</h2>
                        <button wire:click="show(false)">
                            <x-heroicon-o-x-mark
                                class="h-6 w-6 text-gray-700 hover:text-green-500 dark:text-gray-400 dark:hover:text-green-400"
                            />
                        </button>
                    </x-bit.panel.heading>
                    <x-bit.panel.body>
                        @if (! in_array('other', $oneTimeOptions->payload))
                            <x-bit.alert>
                                You can add `other` to have the user define their own amount to donate.
                            </x-bit.alert>
                        @endif

                        <ul class="list-inside list-disc space-y-1">
                            @foreach ($oneTimeOptions->payload as $option)
                                <li class="group items-center space-x-2 text-gray-900 dark:text-gray-200">
                                    <span>{{ $option }}</span>
                                    <button
                                        type="button"
                                        wire:click="removeOption('oneTimeOptions', '{{ $option }}')"
                                        class="rounded px-2 py-1 hover:bg-gray-500 dark:hover:bg-gray-600"
                                    >
                                        <x-heroicon-o-trash
                                            class="h-4 w-4 text-green-500 opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                                        />
                                    </button>
                                </li>
                            @endforeach

                            <li class="text-gray-900 dark:text-gray-200">
                                <form class="inline" wire:submit="addOption('oneTimeOptions')">
                                    <input
                                        class="-ml-2 rounded border border-gray-300 bg-white px-2 py-1 dark:border-gray-700 dark:bg-gray-800"
                                        wire:model.live="newPrice"
                                    />
                                </form>
                            </li>
                        </ul>
                    </x-bit.panel.body>
                </x-bit.panel>
            </div>
        </div>
    </div>
</div>
