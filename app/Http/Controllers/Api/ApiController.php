<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    protected function responseSuccess($data, $code = 200)
    {
        return [
            "ok"     => true,
            "code"   => $code,
            "result" => $data
        ];
    }

    protected function responseError($message, $code = 422)
    {
        return [
            "ok"     => false,
            "code"   => $code,
            "message" => $message
        ];
    }
}
