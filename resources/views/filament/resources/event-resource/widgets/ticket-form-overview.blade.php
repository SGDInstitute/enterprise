<x-filament::widget>
    <div class="fi-wi-stats-overview grid gap-6 md:grid-cols-2">
        @foreach ($this->getStats() as $key => $stat)
        <x-filament::section>
            <x-slot name="heading">
                {{ ucfirst(str_replace('question-', '', $key)) }}
            </x-slot>
            @foreach ($stat as $label => $count)
            <p><strong>{{ $label === '' ? 'Empty' : $label }}:</strong> {{ $count }}</p>
            @endforeach
        </x-filament::section>
        @endforeach
    </div>
</x-filament::widget>
