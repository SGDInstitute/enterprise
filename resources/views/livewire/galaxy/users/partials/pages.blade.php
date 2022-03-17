@switch($page)
    @case('profile')
    <livewire:galaxy.users.profile :user="$user" />
    @break

    @case('orders')
    <livewire:galaxy.orders :user="$user" />
    @break

    @case('reservations')
    <livewire:galaxy.reservations :user="$user" />
    @break

    @case('donations')
    <livewire:galaxy.donations :user="$user" />
    @break

@endswitch
