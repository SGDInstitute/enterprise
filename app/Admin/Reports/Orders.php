<?php

namespace App\Admin\Reports;

use App\Profile;
use App\Order;

class Orders extends Report
{
    public $name = 'Orders';

    public $filename = 'Orders-Report';

    public $view = 'admin.reports.orders';

    public function query()
    {
        return Order::with(['receipt', 'event', 'user', 'tickets.user.profile'])->get();
    }
}
