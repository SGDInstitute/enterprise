<?php

namespace App\Nova\Actions;

use App\Exports\ActivityUserExport;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Maatwebsite\Excel\Facades\Excel;

class ExportSignUps extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $schedule) {
            $schedule->load('activities.users');
            $fileName = now()->format('Y-m-d-h-i').'-'.Str::slug($schedule->title).'-sign-ups.xlsx';

            Excel::store(new ActivityUserExport($schedule), $fileName, 'temp');

            return Action::download(url('temp/'.$fileName), $fileName);
        }

        return Action::message('It worked!');
    }

    public function fields()
    {
        return [];
    }
}
