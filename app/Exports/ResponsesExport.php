<?php

namespace App\Exports;

use App\Response;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ResponsesExport implements FromView
{
    public $form;
    public $responses;

    public function __construct($form, $responses)
    {
        $this->form = $form;
        $this->responses = $responses;
    }

    public function view(): View
    {
        return view('exports.voyager.responses', [
            'responses' => $this->responses,
            'form' => $this->form,
        ]);
    }
}
