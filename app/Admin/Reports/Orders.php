<?php

namespace App\Admin\Reports;

use App\Order;
use App\Profile;

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
