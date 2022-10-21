<form wire:submit.prevent="submit">
    <x-bit.panel title="Print Name Badge">
        <x-bit.panel.body class="space-y-4">
            <x-form.group type="text" model="name" id="name" label="Name" />
            <x-form.group type="text" model="pronouns" id="pronouns" label="Pronouns" />
            <x-bit.button.round.primary type="submit">Submit</x-bit.button.round.primary>
        </x-bit.panel.body>
    </x-bit.panel>
</form>
