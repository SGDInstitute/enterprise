<?php

namespace App\Nova\Actions;

use App\Exports\ResponsesExport;
use Illuminate\Bus\Queueable;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DownloadResponses extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $form) {
            $file = Excel::download(new ResponsesExport($form, $form->responses), "{$form->name}.xlsx");
            return Action::download($this->getDownloadUrl($file, "{$form->name}.xlsx"), "{$form->name}.xlsx");
        }
        return Action::message('It worked! ');
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [];
    }

    protected function getDownloadUrl(BinaryFileResponse $response, $filename): string
    {
        return url('/nova-vendor/maatwebsite/laravel-nova-excel/download?') . http_build_query([
                'path'     => $response->getFile()->getPathname(),
                'filename' => $filename,
            ]);
    }
}