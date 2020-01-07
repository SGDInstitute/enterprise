<?php

namespace Sgd\ImportCard;

use Laravel\Nova\Actions\Action;
use Laravel\Nova\Rules\Relatable;
use Illuminate\Support\Facades\Validator;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Exceptions\NoTypeDetectedException;
use Maatwebsite\Excel\Facades\Excel;

class ImportController
{
    public function handle(NovaRequest $request)
    {
        $resource = $request->newResource();
        $importerClass = $resource::$importer;

        $data = Validator::make($request->all(), [
            'file' => 'required|file',
        ])->validate();

        Excel::import(new $importerClass, request()->file('file'));

        return Action::message(__('Import successful'));
    }

    protected function extractValidationRules($request, $resource)
    {
        return collect($resource::rulesForCreation($request))->mapWithKeys(function ($rule, $key) {
            foreach ($rule as $i => $r) {
                if (!is_object($r)) {
                    continue;
                }

                // Make sure relation checks start out with a clean query
                if (is_a($r, Relatable::class)) {
                    $rule[$i] = function () use ($r) {
                        $r->query = $r->query->newQuery();

                        return $r;
                    };
                }
            }

            return [$key => $rule];
        });
    }

    private function responseError($error)
    {
        throw ValidationException::withMessages([
            0 => [$error],
        ]);
    }
}
