<x-filament::widget>
    <x-filament::section>
        <x-galaxy.paid-breakdown :data="$this->tablePaidData()" />
    </x-filament::section>
    <x-filament::section style="margin-top: 24px">
        <x-galaxy.filled-breakdown :data="$this->tableFilledData()" />
    </x-filament::section>
</x-filament::widget>
