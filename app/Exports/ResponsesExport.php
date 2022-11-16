<?php

namespace App\Exports;

use App\Models\Form;
use App\Models\Response;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ResponsesExport implements FromView
{
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function view(): View
    {
        return view('exports.responses', [
            'responses' => Response::where('form_id', $this->id)->get(),
            'questions' => Form::where('id', $this->id)->first()->form->where('style', 'question'),
        ]);
    }
}
