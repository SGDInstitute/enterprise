<div>
    <h2 id="donation-page" class="mb-4 text-2xl text-gray-900 dark:text-gray-200">Donation Page</h2>
    <div class="relative flex">
        <div class="w-3/4 overflow-hidden border border-gray-300 rounded-md shadow dark:border-gray-700">
            <div class="mb-4">
                <div class="relative w-full bg-center bg-no-repeat bg-cover h-60 md:h-96" style="background-image: url({{ $image->payload }})">
                    <button wire:click="show('image')" for="page-image" class="absolute p-2 text-gray-900 rounded-full top-4 right-4 bg-cyan-500">
                        <x-heroicon-o-pencil class="w-4 h-4" />
                    </button>
                </div>
                <div class="relative w-4/5 px-8 py-4 -mt-6 bg-yellow-500 md:w-2/3">
                    <form wire:submit="saveTitle">
                        <input id="page-title" name="page-title" class="text-4xl text-gray-700 bg-transparent font-news-cycle" wire:model.live="title.payload" />
                    </form>
                    <label for="page-title" wire:click="show(false)" class="absolute p-2 text-gray-900 rounded-full top-1 right-4 bg-cyan-500">
                        <x-heroicon-o-pencil class="w-4 h-4" />
                    </label>
                </div>
            </div>

            <div class="relative grid grid-cols-1 gap-20 px-12 pt-12 mx-auto md:px-4 md:pb-4 md:max-w-4xl md:grid-cols-2">
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
                                    <button type="button" wire:click="$set('type', 'monthly')" class="inline-flex items-center justify-center w-full px-4 py-2 uppercase border-2 border-green-500 font-bold dark:border-green-400 {{ $type === 'monthly' ? 'bg-green-600 dark:bg-green-500 text-white' : 'text-green-500 dark:text-green-400 hover:bg-green-500 hover:text-white dark:hover:bg-green-400' }}">Monthly</button>
                                    <button type="button" wire:click="$set('type', 'one-time')" class="inline-flex items-center justify-center w-full px-4 py-2 -ml-px uppercase border-2 border-green-500 font-bold dark:border-green-400 {{ $type === 'one-time' ? 'bg-green-600 dark:bg-green-500 text-white' : 'text-green-500 dark:text-green-400 hover:bg-green-500 hover:text-white dark:hover:bg-green-400' }}">Give Once</button>
                                </div>

                                @if ($type === 'monthly')
                                <div class="relative grid grid-cols-3 gap-2">
                                    <button wire:click="show('monthly')" id="page-monthly-options" class="absolute p-2 text-gray-900 rounded-full -top-4 -right-4 bg-cyan-500">
                                        <x-heroicon-o-pencil class="w-4 h-4" />
                                    </button>
                                    @foreach ($monthlyOptions->payload as $option)
                                    <button class="btn btn-base btn-block btn-gray" id="monthly-button-{{ $option }}">${{ $option }}</button>
                                    @endforeach
                                </div>
                                @else
                                <div class="relative grid grid-cols-3 gap-2">
                                    <button wire:click="show('one-time')" id="page-one-time-options" class="absolute p-2 text-gray-900 rounded-full -top-4 -right-4 bg-cyan-500">
                                        <x-heroicon-o-pencil class="w-4 h-4" />
                                    </button>
                                    @foreach ($oneTimeOptions->payload as $option)
                                    @if ($option === 'other')
                                    @if ($otherAmount)
                                    <x-bit.input.group for="other-amount" class="col-span-2" label="Other Amount" sr-only>
                                        <x-bit.input.text id="other-amount" class="block w-full" type="number" name="other-amount" disabled placeholder="Other Amount" required leading-add-on="$" />
                                    </x-bit.input.group>
                                    @else
                                    <button class="col-span-2 btn-gray btn btn-base btn-block" wire:click="chooseOther">Other Amount</button>
                                    @endif
                                    @else
                                    <button class="btn btn-base btn-block btn-gray" id="one-time-button-{{ $option }}">${{ $option }}</button>
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
                        <button wire:click="show('content')" id="page-content" class="absolute right-0 p-2 text-gray-900 rounded-full -top-4 bg-cyan-500">
                            <x-heroicon-o-pencil class="w-4 h-4" />
                        </button>
                        {!! markdown($content->payload) !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="flex-1 mt-16 -ml-64 space-y-2 {{ $editPanel ? '' : 'hidden' }}">
            <div class="md:sticky md:top-16">
                <x-bit.panel :class="$editPanel === 'image' ? '' : 'hidden'">
                    <x-bit.panel.heading class="flex items-center justify-between space-x-4">
                        <h2 class="text-gray-900 dark:text-gray-200">Image Editor</h2>
                        <button wire:click="show(false)">
                            <x-heroicon-o-x class="w-6 h-6 text-gray-700 hover:text-green-500 dark:text-gray-400 dark:hover:text-green-400" />
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
                            <x-heroicon-o-x class="w-6 h-6 text-gray-700 hover:text-green-500 dark:text-gray-400 dark:hover:text-green-400" />
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
                            <x-heroicon-o-x class="w-6 h-6 text-gray-700 hover:text-green-500 dark:text-gray-400 dark:hover:text-green-400" />
                        </button>
                    </x-bit.panel.heading>
                    <x-bit.panel.body>
                        <ul class="space-y-1 list-disc list-inside">
                            @foreach ($monthlyOptions->payload as $option)
                            <li class="items-center space-x-2 text-gray-900 dark:text-gray-200 group">
                                <span>{{ $option }}</span>
                                <button type="button" wire:click="removeOption('monthlyOptions', '{{ $option }}')" class="px-2 py-1 rounded hover:bg-gray-500 dark:hover:bg-gray-600">
                                    <x-heroicon-o-trash class="w-4 h-4 text-green-500 transition-opacity duration-300 opacity-0 group-hover:opacity-100" />
                                </button>
                                @if (!$loop->first)
                                <button type="button" wire:click="moveOption('monthlyOptions', 'up', '{{ $option }}')" class="px-2 py-1 rounded hover:bg-gray-500 dark:hover:bg-gray-600">
                                    <x-heroicon-o-chevron-up class="w-4 h-4 text-green-500 transition-opacity duration-300 opacity-0 group-hover:opacity-100" />
                                </button>
                                @endif
                                @if (!$loop->last)
                                <button type="button" wire:click="moveOption('monthlyOptions', 'down', '{{ $option }}')" class="px-2 py-1 rounded hover:bg-gray-500 dark:hover:bg-gray-600">
                                    <x-heroicon-o-chevron-down class="w-4 h-4 text-green-500 transition-opacity duration-300 opacity-0 group-hover:opacity-100" />
                                </button>
                                @endif
                            </li>
                            @endforeach
                            <li class="text-gray-900 dark:text-gray-200">
                                <form class="inline" wire:submit="addOption('monthlyOptions')">
                                    <input class="px-2 py-1 -ml-2 bg-white border border-gray-300 rounded dark:bg-gray-800 dark:border-gray-700" wire:model.live="newPrice" />
                                </form>
                            </li>
                        </ul>
                    </x-bit.panel.body>
                </x-bit.panel>

                <x-bit.panel :class="$editPanel === 'one-time' ? '' : 'hidden'">
                    <x-bit.panel.heading class="flex items-center justify-between space-x-4">
                        <h2 class="text-gray-900 dark:text-gray-200">One-time Options</h2>
                        <button wire:click="show(false)">
                            <x-heroicon-o-x class="w-6 h-6 text-gray-700 hover:text-green-500 dark:text-gray-400 dark:hover:text-green-400" />
                        </button>
                    </x-bit.panel.heading>
                    <x-bit.panel.body>
                        @if (!in_array('other', $oneTimeOptions->payload))
                        <x-bit.alert>You can add `other` to have the user define their own amount to donate.</x-bit.alert>
                        @endif
                        <ul class="space-y-1 list-disc list-inside">
                            @foreach ($oneTimeOptions->payload as $option)
                            <li class="items-center space-x-2 text-gray-900 dark:text-gray-200 group">
                                <span>{{ $option }}</span>
                                <button type="button" wire:click="removeOption('oneTimeOptions', '{{ $option }}')" class="px-2 py-1 rounded hover:bg-gray-500 dark:hover:bg-gray-600">
                                    <x-heroicon-o-trash class="w-4 h-4 text-green-500 transition-opacity duration-300 opacity-0 group-hover:opacity-100" />
                                </button>
                            </li>
                            @endforeach
                            <li class="text-gray-900 dark:text-gray-200">
                                <form class="inline" wire:submit="addOption('oneTimeOptions')">
                                    <input class="px-2 py-1 -ml-2 bg-white border border-gray-300 rounded dark:bg-gray-800 dark:border-gray-700" wire:model.live="newPrice" />
                                </form>
                            </li>
                        </ul>
                    </x-bit.panel.body>
                </x-bit.panel>
            </div>
        </div>
    </div>
</div>
