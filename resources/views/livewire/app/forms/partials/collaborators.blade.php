<div>
    <p><strong>Collaborators:</strong></p>
    <x-bit.input.group :for="$item['id']" label="Add the emails of those who will be presenting with you (if any)">
        <x-bit.input.textarea class="w-full mt-1" :id="$item['id']" wire:model="answers.{{ $item['id'] }}" />
        <x-bit.input.help>Put each email on a new line or separate with commas.</x-bit.input.help>
        <x-bit.input.help>They will be added as a collaborator and will be allowed to make changes to this submission.</x-bit.input.help>
    </x-bit.input.group>
</div>
