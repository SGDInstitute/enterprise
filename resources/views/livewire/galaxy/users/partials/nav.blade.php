<div>
    <div class="sm:hidden">
        <select wire:model.live="page" aria-label="Selected tab" class="block w-full dark:bg-gray-500 dark:border-gray-400 dark:text-gray-200">
            <option value="profile">Profile</option>
            <option value="orders">Orders</option>
            <option value="reservations">Reservations</option>
            <option value="donations">Donations</option>
            <option value="workshops">Workshops</option>
        </select>
    </div>
    <div class="hidden sm:block">
        <div class="border-b border-gray-200 dark:border-gray-600">
            <nav class="flex -mb-px space-x-6">
                <x-bit.button.tab href="{{ route('galaxy.users.show', ['user' => $user, 'page' => 'profile']) }}" title="Profile" active="{{ $page === 'profile' }}" icon="heroicon-o-user" />
                <x-bit.button.tab href="{{ route('galaxy.users.show', ['user' => $user, 'page' => 'orders']) }}" title="Orders" active="{{ $page === 'orders' }}" icon="heroicon-o-shopping-bag" />
                <x-bit.button.tab href="{{ route('galaxy.users.show', ['user' => $user, 'page' => 'reservations']) }}" title="Reservations" active="{{ $page === 'reservations' }}" icon="heroicon-o-shopping-bag" />
                <x-bit.button.tab href="{{ route('galaxy.users.show', ['user' => $user, 'page' => 'donations']) }}" title="Donations" active="{{ $page === 'donations' }}" icon="heroicon-o-shopping-bag" />
                <x-bit.button.tab href="{{ route('galaxy.users.show', ['user' => $user, 'page' => 'workshops']) }}" title="Workshops" active="{{ $page === 'workshops' }}" icon="heroicon-o-shopping-bag" />
            </nav>
        </div>
    </div>
</div>
