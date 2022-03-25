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
                <form wire:submit.prevent="submit" class="mx-auto space-y-8 prose dark:prose-light">
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
                    <div>
                        <div class="p-4 bg-gray-100 rounded-md dark:bg-gray-700">
                            {{ $response->status }}
                            <x-bit.button.flat.primary type="submit" :disabled="!$fillable">Submit for Review by Conference Team</x-bit.button.flat.primary>
                        </div>
                        @if ($showResponseLog)
                        <livewire:bit.response-log :response="$response" />
                        @endif
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
            <x-bit.button.flat.secondary size="xs" wire:click="$set('showPreviousResponses', false)">Close</x-bit.button.flat.secondary>
        </x-slot>
    </x-bit.modal.dialog>
</div>
