<div class="px-4 py-6 mx-auto space-y-8 md:py-12 max-w-prose">
    <h1 class="text-4xl font-bold text-center text-gray-700 dark:text-gray-100">Check In for MBLGTACC</h1>

    @includeWhen(auth()->check() && $ticket->isQueued(), 'livewire.app.checkin.in-queue')
    @includeWhen(auth()->check() && ! $ticket->isQueued() && $ticket !== null, 'livewire.app.checkin.add-to-queue')

    @includeWhen(auth()->check() && $ticket === null, 'livewire.app.checkin.need-ticket')

    @includeWhen(!auth()->check(), 'livewire.app.checkin.need-to-login')
</div>
