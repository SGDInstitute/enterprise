<?php

namespace App\Filament\Resources\FormResource\Widgets;

use Filament\Widgets\BarChartWidget;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class FormatChart extends BarChartWidget
{
    public ?Model $record = null;

    protected static ?string $heading = 'Format';

    protected function getData(): array
    {
        $activeFilter = $this->filter;
        $options = array_keys(Arr::get($this->record->form->firstWhere('data.id', 'format'), 'data.options'));
        $data = $this->record->responses()
            ->when(Str::startsWith($activeFilter, 'status_'), function ($query) use ($activeFilter) {
                $query->where('status', Str::replace('status_', '', $activeFilter));
            })
            ->get()
            ->countBy('answers.format');

        return [
            'datasets' => [
                [
                    'label' => 'Responses by format',
                    'data' => $data,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgb(54, 162, 235)',
                    'borderWidth' => 1
                ],
            ],
            'labels' => $options,
        ];
    }

    protected function getFilters(): ?array
    {
        return [
            'none' => 'No Filter',
            'status_submitted' => 'Status: Submitted',
            'status_accepted' => 'Status: Accepted',
            'status_scheduled' => 'Status: Scheduled',
        ];
    }
}
