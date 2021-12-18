<div>
    @foreach($plans as $plan)
    <div class="space-y-2">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-200">{{ $plan->name }}</h2>

        <x-bit.table>
            <x-slot name="head">
                <x-bit.table.heading>Name</x-bit.table.heading>
                <x-bit.table.heading>Cost</x-bit.table.heading>
                <x-bit.table.heading>Stripe ID</x-bit.table.heading>
            </x-slot>

            <x-slot name="body">
                @forelse($plan->prices as $price)
                    <x-bit.table.row wire:key="price-row-{{ $price->id }}">
                        <x-bit.table.cell>{{ $price->name }}</x-bit.table.cell>
                        <x-bit.table.cell>{{ $price->formattedCost }}</x-bit.table.cell>
                        <x-bit.table.cell>{{ $price->stripe_price_id }}</x-bit.table.cell>
                    </x-bit.table.row>
                @empty
                <x-bit.table.row>
                    <x-bit.table.cell colspan="9">
                        <div class="flex items-center justify-center space-x-2">
                            <x-heroicon-o-users class="w-8 h-8 text-gray-400" />
                            <span class="py-8 text-xl font-medium text-gray-500 dark:text-gray-400 glacial">No prices found...</span>
                        </div>
                    </x-bit.table.cell>
                </x-bit.table.row>
                @endforelse
            </x-slot>
        </x-bit.table>
    </div>
    @endforeach
</div>
