<x-ui.card>
    <x-ui.card.header title="Add your review"/>
    <div>
    <div class="p-4 space-y-4 prose dark:prose-light">
        @foreach ($reviewForm->form as $item)
            @includeWhen($this->isVisible($item), 'livewire.app.forms.partials.' . $item['style'])
        @endforeach
    </div>
    <x-ui.card.footer>
        <button wire:click="save" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Save</button>
    </x-ui.card.footer>
</x-ui.card>
