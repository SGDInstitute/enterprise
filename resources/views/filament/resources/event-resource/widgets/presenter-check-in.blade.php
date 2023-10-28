<x-filament-widgets::widget>
    <x-filament::section collapsible collapsed>
        <x-slot name="heading">Presenter Check-in</x-slot>

        <table class="fi-ta-table w-full table-auto divide-y divide-gray-200 text-start dark:divide-white/5">
            <thead>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Status</th>
                <th></th>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-white/5">
                @forelse ($presenters as $user)
                <tr>
                    <td>{{ $user->name }} <small>({{ $user->pronouns }})</small></td>
                    <td>
                        <button
                            x-on:click="
                                window.navigator.clipboard.writeText(@js($user->email))
                                $tooltip('Email copied')
                            "
                            class="hover:underline"
                        >
                            {{ $user->email }}
                        </button>
                    </td>
                    <td>
                        <button
                            x-on:click="
                                window.navigator.clipboard.writeText(@js($user->phone))
                                $tooltip('Email copied')
                            "
                            class="hover:underline"
                        >
                            {{ $user->phone }}
                        </button>
                    </td>
                    <td>
                        {{ $user->isCheckedInFor($record) ? '✅' : '🚨' }}
                    </td>
                    <td>
                        <x-filament::link :href="route('filament.admin.resources.users.edit', ['record' => $user->id])">
                            View
                        </x-filament::link>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3">No presenters found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </x-filament::section>

</x-filament-widgets::widget>
