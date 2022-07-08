<div class="relative">
    <x-bit.form.header :form="$form" />

    <div class="dark:bg-gray-800">
        <div class="container px-12 pb-12 mx-auto">
            @if (!$fillable)
                <div class="sticky z-50 mx-auto mb-8 max-w-prose top-20">
                    <div class="p-4 bg-green-600 rounded-md">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <x-heroicon-s-information-circle class="w-8 h-8 text-gray-200" />
                            </div>
                            <div class="flex-1 ml-3 md:flex md:justify-between">
                                <p class="text-lg text-gray-200">
                                    You must <a href="/login" class="font-bold text-white underline">Login</a> or <a href="/register" class="font-bold text-white underline">Create an Account</a> before filling out this form.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="{{ $isWorkshopForm ? 'flex justify-between' : '' }}">
                <form id="form" class="mx-auto space-y-8 prose dark:prose-light">
                    @if ($form->type === 'workshop')
                        <p class="text-xl">All answers will be automatically saved.</p>
                    @endif
                    @foreach ($form->form as $item)
                        @includeWhen($this->isVisible($item), 'livewire.app.forms.partials.' . $item['style'])
                    @endforeach

                    @if ($form->type !== 'workshop')
                    <x-bit.button.flat.primary type="submit" :disabled="!$fillable">Save Responses</x-bit.button.flat.primary>
                    @endif
                </form>

                @if ($isWorkshopForm)
                    <div class="relative">
                        <div class="sticky z-40 w-full space-y-4 top-32">
                            <div class="p-4 space-y-4 bg-gray-100 rounded-md dark:bg-gray-700">
                                <div class="space-x-2">
                                    <span class="text-gray-700 dark:text-gray-200">Status:</span>
                                    <x-bit.badge>{{ $response->status ?? 'work-in-progress' }}</x-bit.badge>
                                </div>
                                @if (in_array($response->status, ['work-in-progress', 'submitted']))
                                <x-bit.button.flat.primary form="form" type="submit" :disabled="!$fillable">Submit for Review</x-bit.button.flat.primary>
                                @endif
                            </div>

                            @if ($showResponseLog)
                            <livewire:bit.response-log :response="$response" />
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <x-bit.modal.dialog wire:model="showPreviousResponses" max-width="6xl">
        <x-slot name="title"></x-slot>

        <x-slot name="content">
            <livewire:app.dashboard.workshops :form="$form" />
        </x-slot>

        <x-slot name="footer">
            <x-bit.button.flat.secondary wire:click="$set('showPreviousResponses', false)">Start a new proposal</x-bit.button.flat.secondary>
        </x-slot>
    </x-bit.modal.dialog>

    <form wire:submit.prevent="saveCollaborator">
        <x-bit.modal.dialog wire:model.defer="showCollaboratorModal" max-width="lg">
            <x-slot name="title">
                Add Presenter
            </x-slot>

            <x-slot name="content">
                <x-bit.input.group for="presenter-email" label="Email" :error="$errors->first('newCollaborator.email')">
                    <x-bit.input.text class="w-full" id="presenter-email" placeholder="Email" type="email" wire:model.lazy="newCollaborator.email" />
                </x-bit.input.group>

                <x-bit.input.group class="mt-4" for="presenter-name" label="Name" :error="$errors->first('newCollaborator.name')">
                    <x-bit.input.text id="presenter-name" class="w-full" placeholder="Name" type="text" wire:model="newCollaborator.name" />
                </x-bit.input.group>

                <x-bit.input.group class="mt-4" for="presenter-pronouns" label="Pronouns" :error="$errors->first('newCollaborator.pronouns')">
                    <x-bit.input.text id="presenter-pronouns" class="w-full" placeholder="Pronouns" type="text" wire:model="newCollaborator.pronouns" />
                </x-bit.input.group>
            </x-slot>

            <x-slot name="footer">
                <div class="space-x-2">
                    <x-bit.button.flat.secondary type="button" wire:click="$set('showCollaboratorModal', false)">Cancel</x-bit.button.flat.secondary>

                    <x-bit.button.flat.primary type="submit">Save</x-bit.button.flat.primary>
                </div>
            </x-slot>
        </x-bit.modal.dialog>
    </form>
</div>
