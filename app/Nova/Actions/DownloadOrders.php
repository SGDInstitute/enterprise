<?php

namespace App\Nova\Actions;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ExportOrders extends DownloadExcel implements WithMapping, WithHeadingRow
{
    public function map($order): array
    {
        return [
            $order->id,
            $order->event->name,
            $order->user->name,
            $order->user->email,
            $order->amount,
            $order->tickets->count(),
            $order->tickets()->completed()->count() / $order->tickets->count() * 100 . '% (' . $order->tickets()->completed()->count() . ')',
            Date::dateTimeToExcel($order->created_at),
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Event',
            'User Name',
            'User Email',
            'Amount',
            'Tickets',
            'Filled',
            'Created At'
        ];
    }
}