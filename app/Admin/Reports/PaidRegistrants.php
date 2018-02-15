<?php

namespace App\Admin\Reports;

use App\Order;
use Illuminate\Support\Facades\DB;

class PaidRegistrants extends Report
{
    public $name = 'Paid Registrants';

    public $filename = 'paid-registrants';

    public $view = 'admin.reports.registrants';

    public function query()
    {
        return DB::table('users')
            ->join('profiles', 'users.id', '=', 'profiles.user_id')
            ->join('tickets', 'users.id', '=', 'tickets.user_id')
            ->join('orders', 'orders.id', '=', 'tickets.order_id')
            ->select(
                'orders.confirmation_number',
                'tickets.hash',
                'users.name',
                'users.email',
                'profiles.pronouns',
                'profiles.college',
                'profiles.tshirt',
                'profiles.accommodation'
            )
            ->whereNotNull('orders.confirmation_number')
            ->orderBy('confirmation_number')
            ->get();
    }
}
