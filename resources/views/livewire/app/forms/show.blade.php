<div class="relative">
    <x-bit.form.header :form="$form" />

    <div class="bg-gray-800">
        <div class="container px-12 pb-12 mx-auto {{ auth()->guest() ? 'prose dark:prose-light' : '' }}">
            @if (!$fillable)
            <div class="sticky z-50 mb-8 -mx-12 top-20">
                <div class="px-4 bg-green-100 rounded-md dark:bg-green-800">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <x-heroicon-s-information-circle class="w-8 h-8 text-green-500" />
                        </div>
                        <div class="flex-1 ml-3 md:flex md:justify-between">
                            <p class="text-lg">
                                You must <a href="/login" class="text-gray-400">Login</a> or <a href="/register" class="text-gray-400">Create an Account</a> before filling out this form.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="{{ !$response->activities->isEmpty() ? 'flex justify-between' : '' }}">
                <form wire:submit.prevent="submit" class="mx-auto space-y-8 prose dark:prose-light">
                    @if ($form->type === 'workshop')
                        <p class="text-xl">All answers will be automatically saved.</p>
                    @endif
                    @foreach ($form->form as $item)
                        @includeWhen($this->isVisible($item), 'livewire.app.forms.partials.' . $item['style'])
                    @endforeach

                    @if ($form->type === 'workshop')
                    <x-bit.button.flat.primary type="submit" :disabled="!$fillable">Submit for Review</x-bit.button.flat.primary>
                    @else
                    <x-bit.button.flat.primary type="submit" :disabled="!$fillable">Save Responses</x-bit.button.flat.primary>
                    @endif
                </form>

                @if (!$response->activities->isEmpty())
                <livewire:bit.response-log :response="$response" />
                @endif
            </div>
        </div>
    </div>

    <x-bit.modal.dialog wire:model="showPreviousResponses" max-width="sm">
        <x-slot name="title">Previous Submissions</x-slot>

        <x-slot name="content">
            <div class="space-y-2">
                @foreach ($previousResponses as $response)
                <div class="flex items-center justify-between">
                    <p class="dark:text-gray-200">{{ $response->name }}</p>
                    <x-bit.button.flat.primary size="xs" wire:click="load({{ $response->id }})">Load</x-bit.button.flat.primary>
                </div>
                @endforeach
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-bit.button.flat.secondary size="xs" wire:click="$set('showPreviousResponses', false)">Close</x-bit.button.flat.secondary>
        </x-slot>
    </x-bit.modal.dialog>
</div>
