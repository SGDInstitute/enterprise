<?php

namespace App\Admin\Reports;

use App\Models\Order;
use Illuminate\Support\Facades\DB;

class UnpaidRegistrants extends Report
{
    public $name = 'Unpaid Registrants';

    public $filename = 'unpaid-registrants';

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
            ->whereNull('orders.confirmation_number')
            ->orderBy('confirmation_number')
            ->get();
    }
}
