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

    <form wire:submit="create" class="max-w-lg mx-auto prose dark:prose-light">
        {{ $this->form }}

        <button type="submit" class="mt-8">
            Submit
        </button>
    </form>

    <x-filament-actions::modals />
</div>

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
@endpush
