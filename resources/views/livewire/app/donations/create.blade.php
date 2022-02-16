<div>
    <section class="mb-4">
        <div class="bg-center bg-no-repeat bg-cover h-60 md:h-96" style="background-image: url(https://sgdinstitute.org/assets/headers/header-test2.jpg)">

        </div>
        <div class="w-4/5 px-8 py-4 -mt-6 bg-yellow-300 md:w-2/3">
            <h1 class="text-4xl text-gray-700 font-news-cycle">Support our work</h1>
        </div>
    </section>

    <div class="relative grid grid-cols-1 gap-20 px-12 pt-12 mx-auto md:px-0 md:max-w-4xl md:grid-cols-2">
        <div class="space-y-8">
            @includeWhen($step === 1, 'livewire.app.donations.partials.step1')
            @includeWhen($step === 2, 'livewire.app.donations.partials.step2')
        </div>
        <div class="prose dark:prose-light">
            <div class="md:sticky md:top-24">
                <p>The Midwest Institute for Sexuality and Gender Diversity re-envisions an educational climate that centers the needs and experiences of systemically disadvantaged students and affirms and encourages sexuality and gender diversity.</p>

                <p>Our life-saving work is made possible through the generous financial support of grassroots donors. We invite you to join us with a monthly or one-time gift. Your donation will support our efforts to build community and build strong movements.</p>
            </div>
        </div>
    </div>

    <livewire:auth-modals />
</div>

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
@endpush
