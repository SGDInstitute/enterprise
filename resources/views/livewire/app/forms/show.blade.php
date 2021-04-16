<div>
    <x-bit.form.header :form="$form" />

@json($showPreviousResponses)

    <div class="container px-12 pb-12 mx-auto prose dark:prose-light">
        <form wire:submit.prevent="save" class="space-y-8">
            @foreach($form->form as $item)
                @if($this->isVisible($item))
                    @include('livewire.app.forms.partials.' . $item['style'])
                @endif
            @endforeach

            <x-bit.button.flat.primary type="submit">Save Proposal</x-bit.button.flat.primary>
        </form>
    </div>

    <x-bit.modal.dialog wire:model="showPreviousResponses">
        <x-slot name="title">Previous Responses</x-slot>

        <x-slot name="content">
            @foreach($previousResponses as $response)
            <div class="flex justify-between">
                {{ $response->id }}
                <x-bit.button.round.secondary wire:click="laod({{ $response->id }})">Load</x-bit.button.round.secondary>
            </div>
            @endforeach
        </x-slot>

        <x-slot name="footer">
            <x-bit.button.flat.secondary wire:click="$set('showPreviousResponses', false)">Close</x-bit.button.flat.secondary>
            <x-bit.button.flat.primary type="submit">Save</x-bit.button.flat.primary>
        </x-slot>
    </x-bit.modal.dialog>
</div>
