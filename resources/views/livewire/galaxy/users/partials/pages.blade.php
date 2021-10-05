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




@endswitch
