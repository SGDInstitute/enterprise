<x-filament::widget>
    <x-filament::card>
        <x-galaxy.paid-breakdown :data="$this->tablePaidData()" />
    </x-filament::card>
    <x-filament::card class="mt-4">
        <x-galaxy.filled-breakdown :data="$this->tableFilledData()" />
    </x-filament::card>
</x-filament::widget>
