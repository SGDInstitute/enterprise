<x-filament-widgets::widget>
    <x-filament::section collapsible collapsed>
        <x-slot name="heading">Volunteers</x-slot>

        <div class="grid md:grid-cols-2 gap-4">
            @foreach ($shifts as $shift)
            <div>
                <h3 class="fi-section-header-heading text-base font-semibold leading-6 text-gray-950 dark:text-white mb-2">
                    {{ $shift->name }}
                    <small>({{ $shift->users->unique()->count() }} / {{ $shift->slots }})</small>
                </h3>

                <table>
                    <tbody>
                        @forelse ($shift->users->unique() as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->pronouns }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">No users</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
