<?php

namespace App\Nova\Actions;

use App\Exports\ResponsesExport;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DownloadResponses extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $form) {
            if ($fields->type === 'excel') {
                $fileName = "{$form->name}.xlsx";

                Excel::store(new ResponsesExport($form, $form->responses), $fileName, 'temp');

                return Action::download(url('temp/'.$fileName), $fileName);
            } elseif ($fields->type === 'pdf') {
                $file = PDF::loadView('exports.voyager.pdf.responses', ['form' => $form]);
                $file->save("temp/{$form->name}.pdf");

                return Action::download(url("temp/{$form->name}.pdf"), "{$form->name}.pdf");
            }
        }

        return Action::message('It worked! ');
    }

    public function fields()
    {
        return [
            Select::make('Type')->options([
                'excel' => 'Excel',
                'pdf' => 'PDF',
            ]),
        ];
    }

    protected function getDownloadUrl(BinaryFileResponse $response, $filename) : string
    {
        return url('/nova-vendor/maatwebsite/laravel-nova-excel/download?').http_build_query([
            'path' => $response->getFile()->getPathname(),
            'filename' => $filename,
        ]);
    }
}
