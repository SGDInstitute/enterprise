<div class="prose dark:prose-light">
    <h1>Contact</h1>

    <div class="grid grid-cols-1 gap-8 md:grid-cold-2">
        <form wire:submit="contact" class="space-y-2">
            <x-bit.input.group for="name" label="Name" class="md:col-span-2">
                <x-bit.input.text id="name" class="block w-full mt-1" type="text" name="name" wire:model.live="contact.name" />
            </x-bit.input.group>
            <x-bit.input.group for="pronouns" label="Pronouns">
                <x-bit.input.text id="pronouns" class="block w-full mt-1" type="text" name="pronouns" wire:model.live="contact.pronouns" />
            </x-bit.input.group>
            <x-bit.input.group for="email" label="Email">
                <x-bit.input.text id="email" class="block w-full mt-1" type="text" name="email" wire:model.live="contact.email" />
            </x-bit.input.group>
            <x-bit.input.group for="phone" label="Phone">
                <x-bit.input.text id="phone" class="block w-full mt-1" type="text" name="phone" wire:model.live="contact.phone" />
            </x-bit.input.group>
            <x-bit.input.group for="subject" label="Subject">
                <x-bit.input.text id="subject" class="block w-full mt-1" type="text" name="subject" wire:model.live="contact.subject" />
            </x-bit.input.group>
            <x-bit.input.group for="message" label="Message">
                <x-bit.input.textarea id="message" class="block w-full mt-1" type="text" name="message" wire:model.live="contact.message" />
            </x-bit.input.group>

            <x-bit.button.flat.primary type="submit">Send</x-bit.button.flat.primary>
        </form>
        <div>
            {!! markdown($event->settings->contact) !!}
        </div>
    </div>
</div>
