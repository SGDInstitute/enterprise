<?php

namespace App\Admin\Reports;

use App\Order;
use Illuminate\Support\Facades\DB;

class AllRegistrants extends Report
{
    public $name = 'All Registrants';

    public $filename = 'all-registrants';

    public $view = 'admin.reports.registrants';

    public function query()
    {
        return DB::table('users')
            ->join('profiles', 'users.id', '=', 'profiles.user_id')
            ->join('tickets', 'users.id', '=', 'tickets.user_id')
            ->join('orders', 'orders.id', '=', 'tickets.order_id')
            ->join('receipts', 'receipts.order_id', '=', 'orders.id')
            ->select(
                'orders.confirmation_number',
                'receipts.transaction_id',
                'tickets.hash',
                'users.name',
                'users.email',
                'profiles.pronouns',
                'profiles.college',
                'profiles.tshirt',
                'profiles.accommodation'
            )
            ->orderBy('confirmation_number')
            ->get();
    }
}
