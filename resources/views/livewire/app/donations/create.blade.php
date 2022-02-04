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

            <span class="relative z-0 inline-flex w-full mx-auto rounded-md shadow-sm">
                <button type="button" wire:click="$set('form.type', 'monthly')" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-l-md hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                    Monthly
                </button>
                <button type="button" wire:click="$set('form.type', 'one-time')" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-r-md hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                    One-Time
                </button>
            </span>

            @if($form['type'] === 'monthly')
                $5
                $10
                $20
                $25
                $50
            @else
                $10
                $25
                $50
                $100
                _fill in_
            @endif

            <div>
                @if($donation !== null && $checkoutButton !== null)
                    {!! $checkoutButton->button('Go to Checkout', ['class' => 'space-x-2 justify-center flex-1 inline-flex items-center uppercase font-bold px-4 py-2 text-lg border-4 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 text-green-500 dark:text-green-400 border-green-500 dark:border-green-400 hover:bg-green-500 dark:hover:bg-green-400 hover:text-white' ]) !!}
                @else
                <x-bit.button.flat.primary wire:click="pay" size="large" :disabled="auth()->guest()">Donate {{ $form['type'] === 'monthly' ? 'Monthly' : 'Now' }}</x-bit.button.flat.primary>
                @endif
            </div>
        </div>




    </div>
</div>
