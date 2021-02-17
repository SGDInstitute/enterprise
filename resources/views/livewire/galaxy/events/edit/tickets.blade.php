<form wire:submit.prevent="save">
    <x-bit.panel>
        <x-bit.panel.body>
            @foreach($tickets as $ticket)
            <div>

            </div>
            @endforeach
        </x-bit.panel.body>
        <x-bit.panel.footer>
            @if($formChanged)
            <x-bit.button.primary type="submit">Save</x-bit.button.primary>
            <x-bit.badge color="indigo" class="ml-4">
                Unsaved Changes
            </x-bit.badge>
            @else
            <x-bit.button.primary type="submit" disabled>Save</x-bit.button.primary>
            @endif
        </x-bit.panel.footer>
    </x-bit.panel>
</form>
