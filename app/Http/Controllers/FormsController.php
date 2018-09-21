<?php

namespace App\Http\Controllers;

use App\Form;
use Illuminate\Http\Request;

class FormsController extends Controller
{

    public function show(Form $form)
    {
        return $form;
    }
}
