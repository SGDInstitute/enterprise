<div>
    <section class="mb-4">
        <div class="h-60 bg-cover bg-center bg-no-repeat md:h-96" style="background-image: url({{ $image }})"></div>
        <div class="-mt-6 w-4/5 bg-yellow-500 px-8 py-4 md:w-2/3">
            <h1 class="font-news-cycle text-4xl text-gray-700">{{ $title }}</h1>
        </div>
    </section>

    @guest
        <x-ui.alert id="authentication-alert">
            You must
            <a href="/login" class="font-bold text-white underline">Login</a>
            or
            <a href="/register" class="font-bold text-white underline">Create an Account</a>
            before making a donation.
        </x-ui.alert>
    @elseif (! auth()->user()->hasVerifiedEmail())
        <x-ui.alert id="verification-alert">
            You must
            <a href="{{ route('verification.notice') }}" class="font-bold text-white underline">verify your email</a>
            before filling out this form.
        </x-ui.alert>
    @elseif (auth()->user()->hasRecurringDonation())
        <x-ui.alert id="recurring-donation-alert">
            You already have a recurring donation, if you would like you can
            <a href="{{ route('app.dashboard', ['page' => 'donations']) }}" class="font-bold text-white underline">
                update that donation
            </a>
            or make a one-time donation below.
        </x-ui.alert>
    @endauth

    <div class="relative mx-auto grid grid-cols-1 gap-8 px-12 pt-12 lg:max-w-6xl lg:grid-cols-2 lg:px-0">
        <div>
            {{ $this->form }}
        </div>
        <div class="prose dark:prose-light">
            <div class="md:sticky md:top-24">
                {!! markdown($content) !!}
            </div>
        </div>
    </div>

    <x-filament-actions::modals />
</div>

@push('scripts')
    <script src="https://js.stripe.com/v3/"></script>
@endpush
