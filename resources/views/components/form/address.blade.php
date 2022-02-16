<div id="form-address" x-data="address(@entangle($attributes->wire('model')))" class="space-y-2">
    <div class="relative" @click.away="open = false">
        <x-form.label>Address</x-form.label>
        <div class="relative">
            <x-form.input x-ref="search" autocomplete="off" x-model.debounce.500ms="address.line1" id="form-line1" placeholder="Street Address" />
            <button type="button" x-show="chosen" @click="clearAddress" class="absolute top-0 right-0 z-10 h-full px-3 py-2 text-green-500 rounded-md dark:text-green-400 hover:bg-green-500 hover:text-white">
                <x-heroicon-o-x class="w-6 h-6" />
            </button>
        </div>
        <div x-show="open" class="absolute z-10 mt-2 overflow-hidden text-gray-900 bg-gray-700 border-gray-300 divide-y divide-gray-300 rounded-md border-x dark:divide-gray-600 dark:border-gray-600 dark:text-gray-200">
            <template x-for="option in options">
                <button @click="choose(option)" type="button" class="px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700" x-text="option.place_name"></button>
            </template>
        </div>
    </div>
    <div class="relative">
        <x-form.label>Address 2</x-form.label>
        <x-form.input x-model="address.line2" id="form-line2" placeholder="Unit" />
    </div>
    <div class="relative">
        <x-form.label>City</x-form.label>
        <x-form.input x-model="address.city" id="form-city" placeholder="City" />
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div class="relative">
            <x-form.label>State</x-form.label>
            <x-form.input x-model="address.state" id="form-state" placeholder="State" />
        </div>
        <div class="relative">
            <x-form.label>ZIP code</x-form.label>
            <x-form.input  x-model="address.zip" id="form-zip" placeholder="ZIP code" />
        </div>
    </div>
</div>
