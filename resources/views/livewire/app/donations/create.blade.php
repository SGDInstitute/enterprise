<div>
    <section class="mb-4">
        <div class="bg-center bg-no-repeat bg-cover h-60 md:h-96" style="background-image: url({{ $image }})">

        </div>
        <div class="w-4/5 px-8 py-4 -mt-6 bg-yellow-500 md:w-2/3">
            <h1 class="text-4xl text-gray-700 font-news-cycle">{{ $title }}</h1>
        </div>
    </section>

    <div class="relative grid grid-cols-1 gap-20 px-12 pt-12 mx-auto md:px-0 md:max-w-4xl md:grid-cols-2">
        <div class="space-y-8">
            @includeWhen($step === 1, 'livewire.app.donations.partials.step1')
            @includeWhen($step === 2, 'livewire.app.donations.partials.step2')
        </div>
        <div class="prose dark:prose-light">
            <div class="md:sticky md:top-24">
                {!! markdown($content) !!}
            </div>
        </div>
    </div>

    <livewire:auth-modals />
</div>

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
@endpush
