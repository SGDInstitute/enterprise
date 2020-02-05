<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

class ForgotPasswordController extends \App\Http\Controllers\Auth\ForgotPasswordController
{
    protected function sendResetLinkResponse(Request $request, $response)
    {
        return response()->json(['status', trans($response)]);
    }

    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return response()->json(['email' => $request->only('email'), 'errors' => ['email' => trans($response)]]);
    }
}
