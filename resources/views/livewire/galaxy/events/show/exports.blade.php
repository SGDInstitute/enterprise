<div class="grid grid-cols-3 gap-4">
    <x-bit.panel title="Ticket Answers">
        <x-bit.panel.body class="space-y-2">
            <x-form.group model="ticketAnswers.ticket_type" type="select" label="Ticket Type" placeholder="Select Option" :options="$event->ticketTypes->pluck('name', 'id')" />
            <x-form.group model="ticketAnswers.question" type="select" label="Question" placeholder="Select Option" :options="$questions" />
            <x-form.group model="ticketAnswers.status" type="select" label="Status" :options="['both' => 'Both', 'paid' => 'Paid', 'unpaid' => 'Unpaid']" />
            <x-bit.button.round.primary wire:click="generateTicketAnswers">Generate</x-bit.button.round.primary>
        </x-bit.panel.body>
    </x-bit.panel>
    <x-bit.panel title="All Users">
        <x-bit.panel.body class="space-y-2">
            <x-form.group model="allUsers.ticket_type" type="select" label="Ticket Type" placeholder="All" :options="$event->ticketTypes->pluck('name', 'id')" />
            <x-form.group model="allUsers.status" type="select" label="Status" :options="['both' => 'Both', 'paid' => 'Paid', 'unpaid' => 'Unpaid']" />
            <x-bit.button.round.primary wire:click="generateAllUsers">Generate</x-bit.button.round.primary>
        </x-bit.panel.body>
    </x-bit.panel>
</div>
