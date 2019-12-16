<?php

namespace App\Nova\Actions;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class DownloadOrders extends DownloadExcel implements WithMapping, WithHeadingRow, WithStrictNullComparison
{
    public function map($order): array
    {
        return [
            $order->id,
            $order->event->title,
            $order->user->name,
            $order->user->email,
            $order->amount / 100,
            $order->tickets->count(),
            $order->tickets()->completed()->count(),
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