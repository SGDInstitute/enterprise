<div>
    <section class="mb-4">
        <div class="bg-center bg-no-repeat bg-cover h-60 md:h-96" style="background-image: url(https://sgdinstitute.org/assets/headers/header-test2.jpg)">

        </div>
        <div class="w-4/5 px-8 py-4 -mt-6 bg-yellow-300 md:w-2/3">
            <h1 class="text-4xl text-gray-700 font-news-cycle">Giving to the Institute and our Programs</h1>
        </div>
    </section>

    <div class="px-12 mx-auto md:max-w-lg">
        <div class="pt-12 space-y-4">
            @if(auth()->guest())
            <div class="px-4 py-2 text-gray-200 bg-red-500 rounded">
                <p>Please create an account or log in before creating a donation.</p>
            </div>
            @endif

            <x-bit.input.group for="name" label="Name" :error="$errors->first('form.name')">
                <x-bit.input.text type="text" class="w-full mt-1" id="name" wire:model="form.name" />
            </x-bit.input.group>

            <x-bit.input.group for="email" label="Email" :error="$errors->first('form.email')">
                <x-bit.input.text type="email" class="w-full mt-1" id="email" wire:model="form.email" />
            </x-bit.input.group>

            <x-bit.input.group :error="$errors->first('form.is_anonymous')">
                <x-bit.input.checkbox id="anonymous" wire:model="form.is_anonymous" label="Keep donation anonymous" />
            </x-bit.input.group>

            <x-bit.input.group :error="$errors->first('form.is_company')">
                <x-bit.input.checkbox id="is_company" wire:model="form.is_company" label="This donation is on behalf of a company" />
            </x-bit.input.group>

            @if($form['is_company'])
            <x-bit.input.group for="company_name" label="Company Name" :error="$errors->first('form.company_name')">
                <x-bit.input.text type="text" class="w-full mt-1" id="company_name" wire:model="form.company_name" />
            </x-bit.input.group>

            <x-bit.input.group for="tax_id" label="Tax ID" :error="$errors->first('form.tax_id')">
                <x-bit.input.text type="text" class="w-full mt-1" id="tax_id" wire:model="form.tax_id" />
            </x-bit.input.group>
            @endif

            <x-bit.input.group for="type" label="Is this a one-time or recurring donation?" :error="$errors->first('form.type')">
                <div class="mt-1 space-y-2">
                    <x-bit.input.radio name="type" id="type-one-time" wire:model="form.type" value="one-time" label="One-time" />
                    <x-bit.input.radio name="type" id="type-monthly" wire:model="form.type" value="monthly" label="Recurring Monthly" />
                </div>
            </x-bit.input.group>

            <x-bit.input.group for="amount" label="Amount" :error="$errors->first('form.amount')">
                <x-bit.input.currency type="text" class="w-full mt-1" id="amount" wire:model="form.amount" />
            </x-bit.input.group>

            <div>
                @if($donation !== null && $checkoutButton !== null)
                    {!! $checkoutButton->button('Go to Checkout', ['class' => 'space-x-2 justify-center flex-1 inline-flex items-center uppercase font-bold px-4 py-2 text-lg border-4 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 text-green-500 dark:text-green-400 border-green-500 dark:border-green-400 hover:bg-green-500 dark:hover:bg-green-400 hover:text-white' ]) !!}
                @else
                <x-bit.button.flat.primary wire:click="pay" size="large" :disabled="auth()->guest()">Pay with Card</x-bit.button.flat.primary>
                @endif
            </div>
        </div>




    </div>
</div>
