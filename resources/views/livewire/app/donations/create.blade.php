<div>
    <section class="mb-4">
        <div class="bg-center bg-no-repeat bg-cover h-60 md:h-96" style="background-image: url({{ $image }})">

        </div>
        <div class="w-4/5 px-8 py-4 -mt-6 bg-yellow-500 md:w-2/3">
            <h1 class="text-4xl text-gray-700 font-news-cycle">{{ $title }}</h1>
        </div>
    </section>

    @guest
    <x-ui.alert id="authentication-alert">You must <a href="/login" class="font-bold text-white underline">Login</a> or <a href="/register" class="font-bold text-white underline">Create an Account</a> before making a donation.</x-ui.alert>
    @elseif (! auth()->user()->hasVerifiedEmail())
    <x-ui.alert id="verification-alert">You must <a href="{{ route('verification.notice') }}" class="font-bold text-white underline">verify your email</a> before filling out this form.</x-ui.alert>
    @endauth

    <div class="relative grid grid-cols-1 gap-20 px-12 pt-12 mx-auto md:px-0 md:max-w-6xl md:grid-cols-2">
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
